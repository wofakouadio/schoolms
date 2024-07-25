<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\Term;
use App\Models\School;
use App\Models\BillingLog;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\AcademicYear;
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
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bill:students';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bill Students';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $schools = School::all();

        DB::beginTransaction();
        try {
            foreach ($schools as $school) {
                $activeAcademicYear = AcademicYear::where('school_id', $school->id)
                    ->where('is_active', 1)
                    ->first();

                $activeTerm = Term::where('school_id', $school->id)
                    ->where('is_active', 1)
                    ->first();

                if (!$activeAcademicYear || !$activeTerm) {
                    continue;
                }

                $students = StudentsAdmissions::where('school_id', $school->id)
                    ->where('student_status', 1) // Adjust the condition if necessary
                    ->whereDoesntHave('billingLogs', function ($query) use ($activeAcademicYear, $activeTerm) {
                        $query->where('academic_year_id', $activeAcademicYear->id)
                            ->where('term_id', $activeTerm->id);
                    })
                    ->take(1000)
                    ->get();

                foreach ($students as $student) {
                    DB::transaction(function () use ($student, $activeAcademicYear, $activeTerm, $school) {
                        $bill = Bill::where('academic_year', $activeAcademicYear->id)
                            ->where('term_id', $activeTerm->id)
                            ->where('level_id', $student->student_level)
                            ->where('branch_id', $student->student_branch)
                            ->where('school_id', $school->id)
                            ->where('is_active', 1)
                            ->first();

                        if ($bill) {
                            $billBreakdowns = $bill->billsbreakdown;

                            foreach ($billBreakdowns as $breakdown) {
                                Transaction::create([
                                    'id' => Str::uuid(),
                                    'student_id' => $student->id,
                                    'level_id' => $student->student_level,
                                    'term_id' => $activeTerm->id,
                                    'academic_year_id' => $activeAcademicYear->id,
                                    'description' => $breakdown->item,
                                    'amount_due' => $breakdown->amount,
                                    'items' => $breakdown->item,
                                    'payment_status' => 'awaiting_pending',
                                    'school_id' => $student->school_id,
                                    'branch_id' => $student->student_branch
                                ]);
                            }

                            BillingLog::create([
                                'id' => Str::uuid(),
                                'student_id' => $student->id,
                                'academic_year_id' => $activeAcademicYear->id,
                                'term_id' => $activeTerm->id
                            ]);
                        }
                    });
                }
            }
            DB::commit();
            $this->info('All Students have been billed.');
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
