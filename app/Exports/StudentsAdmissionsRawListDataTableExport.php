<?php

namespace App\Exports;

use App\Models\StudentsAdmissions;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsAdmissionsRawListDataTableExport implements FromCollection, WithHeadings, WithMapping
{
    protected $StudentsAddmissionsList;

    public function __construct($StudentsAddmissionsList)
    {
        $this->StudentsAddmissionsList = $StudentsAddmissionsList;
    }

    public function collection(){
        return $this->StudentsAddmissionsList;
    }

    public function headings(): array{
        return [
            'Name',
            'Date of Birth',
            'Gender',
            'Level',
            'Residency',
            'Category',
            'Admission Status',
            'Registration Date'
        ];
    }

    public function map($data): array{
        $admission_status = '';
        if($data->admission_status == '0'){
            $admission_status = 'Pending Admission';
        }elseif($data->admission_status == 1){
            $admission_status = 'Admitted';
        }else{
            $admission_status = 'Declined';
        }

        return [
            $data->student_firstname . ' ' . $data->student_othername . ' ' . $data->student_lastname,
            $data->student_dob,
            $data->student_gender,
            $data->level->level_name,
            $data->student_residency_type,
            $data->category->category_name,
            $admission_status,
            $data->created_at
        ];
    }
}
