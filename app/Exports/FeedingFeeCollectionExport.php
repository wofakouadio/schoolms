<?php

namespace App\Exports;

use App\Models\FeedingFeeCollection;
use App\Models\AcademicYear;
use App\Models\School;
use App\Models\Term;
use App\Models\FeedingFee;
use App\Models\Level;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class FeedingFeeCollectionExport implements FromView, ShouldAutoSize, WithStyles
{

    public $school_id;
    public $term_id;
    public $academic_year_id;
    public $feeding_fee_id;
    public $week;
    public $date;

    public function __construct($school_id, $term_id, $academic_year_id, $feeding_fee_id, $week, $date){
        $this->school_id = $school_id;
        $this->term_id = $term_id;
        $this->academic_year_id = $academic_year_id;
        $this->feeding_fee_id = $feeding_fee_id;
        $this->week = $week;
        $this->date = $date;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 16, 'center' => true]],
            2    => ['font' => ['bold' => true, 'size' => 15]],
            3   => ['font' => ['bold' => true, 'size' => 14]],
            4   => ['font' => ['bold' => true, 'size' => 14]],
            5   => ['font' => ['bold' => true, 'size' => 14]],
            6   => ['font' => ['bold' => true, 'size' => 14]],
            7   => ['font' => ['bold' => true, 'size' => 14]],
            // 'A'  => ['font' => ['size' => 13]],
            // 'B'  => ['font' => ['size' => 13]],
            // 'C'  => ['font' => ['size' => 13]],
            // 'D'  => ['font' => ['size' => 13]],
            // 'E'  => ['font' => ['size' => 13]],
            // 'F'  => ['font' => ['size' => 13]],
            // 'G'  => ['font' => ['size' => 13]],
            // 'H'  => ['font' => ['size' => 13]],
            // 'C'  => ['font' => ['size' => 13]],
        ];
    }

    public function view(): View{
        // school data
        $schoolData = School::where('id', $this->school_id)->first();
        // Week
        $weekData = $this->week;
        // Term
        $termData = Term::where('id', $this->term_id)->first();
        //Academic year
        $academicYearData = AcademicYear::where('id' , $this->academic_year_id)->first();
        //Feeding Fee Amount
        $feedingFeeData = FeedingFee::with('school_currency')->where('id', $this->feeding_fee_id)->first();
        // Levels
        $levelsData = Level::where('school_id', $this->school_id)->get();

        return view('admin.dashboard.finance.feeding-fee.feeding_fee_collection_export', [
            'levelsData' => $levelsData,
            'feedingFeeData' => $feedingFeeData,
            'academicYearData' => $academicYearData,
            'termData' => $termData,
            'weekData' => $weekData,
            'schoolData' => $schoolData,
            'date' => $this->date
        ]);
    }

}
