<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HousesListExport implements FromCollection, WithHeadings, WithMapping
{
    protected $HousesList;

    public function __construct($HousesList)
    {
        $this->HousesList = $HousesList;
    }

    public function collection()
    {
        return $this->HousesList;
    }

    public function headings(): array
    {
        return[
            '#',
            'Name',
            'Branch',
            'School',
            'Status',
            'Created At'
        ];
    }

    public function map($data): array{
        static $count = 0;
        $status = '';
        if($data->is_active == '1'){
            $status = 'ACTIVE';
        }else{
            $status = 'DISABLED';
        }
        return [
            ++$count,
            $data->house_name,
            $data->branch->branch_name,
            $data->school->school_name,
            $status,
            $data->created_at
        ];
    }
}
