<?php

namespace App\Jobs;

use App\Models\Bill;
use App\Models\Term;
use App\Models\School;
use App\Models\BillingLog;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\AcademicYear;
use App\Models\BillBreakdown;
use Illuminate\Bus\Queueable;
use App\Models\StudentsAdmissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BillStudentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $schools = School::all();

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
                ->whereDoesntHave('BillingLogs', function ($query) use ($activeAcademicYear, $activeTerm) {
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
                        $billBreakdowns = $bill->billBreakdowns;

                        foreach ($billBreakdowns as $breakdown) {
                            Transaction::create([
                                'id' => Str::uuid(),
                                // 'invoice_id' => uniqid(),
                                'student_id' => $student->id,
                                'level_id' => $student->student_level,
                                'term_id' => $activeTerm->id,
                                'academic_year_id' => $activeAcademicYear->id,
                                'description' => $breakdown->item,
                                // 'currency' => 'USD', // Adjust the currency if needed
                                'amount_due' => $breakdown->amount,
                                // 'amount_paid' => 0.00,
                                // 'balance' => $breakdown->amount,
                                // 'transaction_type' => 'debit',
                                'items' => $breakdown->item,
                                'payment_status' => 'awaiting_pending',
                                // 'paid_at' => null,
                                // 'reference' => uniqid(),
                                'school_id' => $student->school_id,
                                'branch_id' => $student->student_branch,
                                // 'created_at' => now(),
                                // 'updated_at' => now(),
                            ]);
                        }

                        BillingLog::create([
                            'id' => Str::uuid(),
                            'student_id' => $student->id,
                            'academic_year_id' => $activeAcademicYear->id,
                            'term_id' => $activeTerm->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                });
            }
        }
    }
}















// namespace App\Jobs;

// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Support\Facades\DB;

// class BillStudentsJob implements ShouldQueue
// {
//     public function handle()
//     {
//         // Get all students that have not been billed
//         $students = DB::table('students_admissions')
//             ->leftJoin('billings', function ($join) {
//                 $join->on('students_admissions.id', '=', 'billings.student_id')
//                     ->where('billings.term_id', '=', DB::raw('students.current_term_id'))
//                     ->where('billings.academic_year_id', '=', DB::raw('students_admissions.current_academic_year'));
//             })
//             ->whereNull('(link unavailable)')
//             ->get();

//         // Mark the student records as billed
//         foreach ($students as $student) {
//             DB::table('students')
//                 ->where('id', $student->id)
//                 ->update([
//                     'billed' => true
//                 ]);

//             // Create a new billing record
//             DB::table('billings')->insert([
//                 'student_id' => $student->id,
//                 'term_id' => $student->current_term_id,
//                 'academic_year' => $student->current_academic_year
//             ]);
//         }
//     }
// }
