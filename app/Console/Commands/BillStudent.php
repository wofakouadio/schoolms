<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\Term;
use App\Models\School;
use App\Models\BillingLog;
use App\Models\Transaction;
use App\Services\SMSService;
use Illuminate\Support\Str;
use App\Models\AcademicYear;
use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Bus\Queueable;
use App\Models\StudentsAdmissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BillStudent extends Command implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $signature = 'bill:students';
    protected $description = 'Bill Students and Notify Parents';
    private $smsService;
    protected $timeout = 3600; // 1 hour timeout
    protected $chunkSize = 50; // Reduced chunk size
    private $originalTimeout;

    public function __construct(SMSService $smsService)
    {
        parent::__construct();
        $this->smsService = $smsService;
    }

    public function handle()
    {
        try {
            $this->setTimeoutLimit();

            School::query()
                ->chunk(10, function ($schools) {
                    foreach ($schools as $school) {
                        $this->processSchool($school);
                    }
                });

            $this->info('All Students have been billed and notifications sent.');
        } catch (\Exception $e) {
            $this->error("Command failed: " . $e->getMessage());
            return 1;
        } finally {
            $this->resetTimeoutLimit();
        }
    }

    private function setTimeoutLimit()
    {
        $this->originalTimeout = ini_get('max_execution_time');
        set_time_limit($this->timeout);
    }

    private function resetTimeoutLimit()
    {
        if ($this->originalTimeout !== false) {
            set_time_limit($this->originalTimeout);
        }
    }

    private function processSchool(School $school)
    {
        $activeYear = $this->getActiveAcademicYear($school);
        $activeTerm = $this->getActiveTerm($school);

        if (!$activeYear || !$activeTerm) {
            $this->warn("School {$school->school_name} has no active academic year or term");
            return;
        }

        $this->info("Billing students for {$school->school_name}");
        $this->info("Active Term: {$activeTerm->term_name}");
        $this->info("Active Academic Year: {$activeYear->academic_year_start} - {$activeYear->academic_year_end}");
        $this->processStudents($school, $activeYear, $activeTerm);
    }

    private function processStudents(School $school, AcademicYear $activeYear, Term $activeTerm)
    {
        StudentsAdmissions::query()
            ->where('school_id', $school->id)
            ->where('student_status', 1)
            ->whereDoesntHave('billingLogs', function ($query) use ($activeYear, $activeTerm) {
                $query->where('academic_year_id', $activeYear->id)
                    ->where('term_id', $activeTerm->id);
            })
            ->chunkById($this->chunkSize, function ($students) use ($school, $activeYear, $activeTerm) {
                try {
                    $this->processBatch($students, $school, $activeYear, $activeTerm);
                } catch (\Exception $e) {
                    $this->warn("Failed to process batch: " . $e->getMessage());
                    // Continue with next batch instead of failing completely
                }
            });
    }

    private function processBatch($students, $school, $activeYear, $activeTerm)
    {
        DB::transaction(function () use ($students, $school, $activeYear, $activeTerm) {
            foreach ($students as $student) {
                try {
                    $bill = $this->getBill($student, $school, $activeYear, $activeTerm);
                    if (!$bill) continue;

                    // Get arrears before creating new transactions
                    $arrears = $this->getStudentArrears($student);

                    $totalAmount = $this->createTransactions($student, $bill, $activeYear, $activeTerm);
                    $this->createBillingLog($student, $school, $activeYear, $activeTerm, $totalAmount);

                    // Pass both current bill and arrears
                    $this->notifyParent($student, $totalAmount, $activeYear, $activeTerm, $arrears);
                } catch (\Exception $e) {
                    // Log the error but continue with next student
                    $this->warn("Failed to process student {$student->id}: " . $e->getMessage());
                }
            }
        }, 3); // Add 3 retries for transaction
    }

    private function getBill($student, $school, $activeYear, $activeTerm)
    {
        return Bill::where([
            'academic_year' => $activeYear->id,
            'term_id' => $activeTerm->id,
            'level_id' => $student->student_level,
            'branch_id' => $student->student_branch,
            'school_id' => $school->id,
            'is_active' => 1,
        ])->first();
    }

    private function createTransactions($student, $bill, $activeYear, $activeTerm)
    {
        $totalAmount = 0;

        foreach ($bill->billsbreakdown as $breakdown) {
            Transaction::create([
                'id' => Str::uuid(),
                'student_id' => $student->id,
                'level_id' => $student->student_level,
                'term_id' => $activeTerm->id,
                'academic_year_id' => $activeYear->id,
                'description' => $breakdown->item,
                'amount_due' => $breakdown->amount,
                'items' => $breakdown->item,
                'payment_status' => 'awaiting_payment',
                'school_id' => $student->school_id,
                'branch_id' => $student->student_branch
            ]);

            $totalAmount += $breakdown->amount;
        }

        return $totalAmount;
    }

    private function createBillingLog($student, $school, $activeYear, $activeTerm, $totalAmount)
    {
        BillingLog::create([
            'id' => Str::uuid(),
            'student_id' => $student->id,
            'academic_year_id' => $activeYear->id,
            'term_id' => $activeTerm->id,
            'level_id' => $student->student_level,
            'school_id' => $school->id,
            'branch_id' => $student->student_branch,
            'amount_billed' => $totalAmount
        ]);
    }

    private function getStudentArrears($student)
    {
        return Transaction::where([
            'student_id' => $student->id,
            'payment_status' => 'awaiting_payment'
        ])->sum('amount_due');
    }

    private function notifyParent($student, $totalAmount, $activeYear, $activeTerm, $arrears)
    {
        if (!$student->student_guardian_contact) {
            return;
        }

        $arrears = $arrears ?? $this->getStudentArrears($student);
        $student_fullname = "{$student->student_firstname} {$student->student_lastname}";
        $currency = Currency::where('school_id',$student->school_id)->where('is_default_currency', 1)->first();

        $symbol = $currency ? $currency->symbol : 'GHS';

        $message = sprintf(
            "Dear %s,\nBills for %s\n(%s - Term %s) = %s %s\nArrears: %s %s\nTotal Due: %s %s\nKindly settle. Thanks.",
            $student->student_guardian_name,
            $student_fullname,
            $activeYear->academic_year_start . '/' . $activeYear->academic_year_end,
            $activeTerm->term_name,
            $symbol,
            number_format($totalAmount, 2),
            $symbol,
            number_format($arrears, 2),
            $symbol,
            number_format($totalAmount + $arrears, 2)
        );

        $this->smsService->sendSMS($student->student_guardian_contact, $message);
    }

    private function getActiveAcademicYear(School $school)
    {
        return AcademicYear::where('school_id', $school->id)
            ->where('is_active', 1)
            ->first();
    }

    private function getActiveTerm(School $school)
    {
        return Term::where('school_id', $school->id)
            ->where('is_active', 1)
            ->first();
    }
}
