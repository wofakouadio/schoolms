<?php

namespace App\Imports;

use App\Models\StudentsAdmissions;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsAdmissionsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new StudentsAdmissions([
            'student_firstname' => $row['firstname'],
            'student_othername' => $row['othername'],
            'student_lastname' => $row['lastname'],
            'student_gender' => $row['gender'],
            'student_dob' => $row['date_of_birth'],
            'student_pob' => $row['place_of_birth'],
            'student_branch' => $row['branch'],
            'student_level' => $row['level'],
            'student_house' => $row['house'],
            'student_category' => $row['category'],
            'student_residency_type' => $row['residency_type'],
            'student_guardian_name' => $row['guardian_name'],
            'student_guardian_contact' => $row['guardian_contact'],
            'student_guardian_address' => $row['guardian_address'],
            'student_guardian_email' => $row['guardian_email'],
            'student_guardian_occupation' => $row['guardian_occupation'],
            'school_id' => Auth::guard('admin')->user()->school_id
        ]);
    }
}
