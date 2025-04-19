<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LevelsListDataTableExport implements FromCollection, WithHeadings, WithMapping
{
    protected $LevelsList;

    public function __construct($LevelsList){
        $this->LevelsList = $LevelsList;
    }

    public function collection()
    {
        return $this->LevelsList;
    }

    public function headings(): array
    {
        return [
            '#',
            'Class/Level',
            'Description',
            'Branch',
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
            $data->level_name,
            $data->level_description,
            $data->branch->branch_name,
            $status,
            $data->school->school_name,
            $data->created_at
        ];
    }
}
