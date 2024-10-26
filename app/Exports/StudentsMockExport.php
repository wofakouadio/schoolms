<?php

namespace App\Exports;

use App\Models\StudentMock;
use App\Models\Mock;
use App\Models\StudentsAdmissions;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsMockExport implements FromCollection, Responsable
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function mock(Mock $mock){
        $this->mock = $mock;
        return $mock;
    }

    public function level($level){
        $this->level = $level;
        return $level;
    }

    public function __construct($level)
    {
        $this->level = $level;
    }

    public function collection()
    {
        return StudentsAdmissions::with('level')
            ->where('student_level', $this->level)
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->get();
//        return StudentMock::all();
    }
}
