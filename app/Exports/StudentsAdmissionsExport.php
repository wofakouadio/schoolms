<?php

namespace App\Exports;

use App\Models\StudentsAdmissions;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsAdmissionsExport implements FromView, ShouldAutoSize, WithStyles
{
   public function styles(Worksheet $sheet){

   }

   public function view(): View{
        // school data
        $schoolData = School::where('id', Auth::guard('admin')->user()->school_id)->first();
    return view('admin.dashboard.student.students_admissions_export', [
        'schoolData' => $schoolData
    ]);
   }

}
