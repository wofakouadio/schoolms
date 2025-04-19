<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BranchesListDataTableExport implements FromCollection, WithHeadings, WithMapping
{
    protected $BranchesList;

    public function __construct($BranchesList)
    {
        $this->BranchesList = $BranchesList;
    }

    public function collection()
    {
        return $this->BranchesList;
    }

    public function headings(): array{
        return [
            '#',
            'Name',
            'Description',
            'Contact',
            'Email',
            'Location',
            'Status',
            'School',
            'Created At'
        ];
    }

    public function map($data): array{
        static $count = 0;
        $status = '';
        if($data->is_active == '0'){
            $status = 'ACTIVE';
        }else{
            $status = 'DISABLED';
        }

        return [
            ++$count,
            $data->branch_name,
            $data->branch_description,
            $data->branch_contact,
            $data-> branch_email,
            $data->branch_location,
            $status,
            $data->school->school_name,
            $data->created_at
        ];
    }
}
