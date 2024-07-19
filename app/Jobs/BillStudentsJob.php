<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class BillStudentsJob implements ShouldQueue
{
    public function handle()
    {
        // Get all students that have not been billed
        $students = DB::table('students_admissions')
            ->leftJoin('billings', function ($join) {
                $join->on('students_admissions.id', '=', 'billings.student_id')
                    ->where('billings.term_id', '=', DB::raw('students.current_term_id'))
                    ->where('billings.academic_year_id', '=', DB::raw('students_admissions.current_academic_year'));
            })
            ->whereNull('(link unavailable)')
            ->get();

        // Mark the student records as billed
        foreach ($students as $student) {
            DB::table('students')
                ->where('id', $student->id)
                ->update([
                    'billed' => true
                ]);

            // Create a new billing record
            DB::table('billings')->insert([
                'student_id' => $student->id,
                'term_id' => $student->current_term_id,
                'academic_year' => $student->current_academic_year
            ]);
        }
    }
}
