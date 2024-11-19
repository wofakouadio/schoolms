<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\StudentsAdmissions;
use App\Models\Transaction;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolCurrency;

class FinanceReportController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $schoolCurrency = SchoolCurrency();
        $records = [] ?? null;
        $arrears_records = [] ?? null;
        return view('admin.dashboard.finance.reports.index', compact('schoolTerm', 'schoolCurrency', 'records', 'arrears_records'));
    }
/**************************************************/
/************************ Fees ************/
    // method to fetch student data
    public function get_student_finance_data(Request $request){
        $schoolTerm = TermAndAcademicYear();
        $schoolCurrency = SchoolCurrency();
        $records = [] ?? null;
        // gde student data
        $student = StudentsAdmissions::with('level', 'house', 'category', 'branch')->where("student_id", $request->student_id)->first();
        // get student photo
        $student_photo = $student->getFirstMediaUrl('student_profile') ?? asset('assets/images/profile/small/pic1.jpg');
        // $student_photo = $student->getMedia('student_profile')->first() ?? asset('assets/images/profile/small/pic1.jpg');
        // get financial records
        $records = Transaction::where("student_id", $student->id)->get();
        // get school data
        $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
        // school profile
        $schoolPhoto = $schoolData->getFirstMediaUrl('school_logo') ?? asset('assets/images/avatar/1.jpg');
        // dd($records);
        return view('admin.dashboard.finance.reports.index', compact('schoolTerm', 'schoolCurrency', 'records', 'student', 'student_photo', 'schoolData', 'schoolPhoto'));
    }

    // method to download student finance report
    public function download_student_finance_data(Request $request){
        $schoolTerm = TermAndAcademicYear();
        $schoolCurrency = SchoolCurrency();
        $records = [] ?? null;
        // gde student data
        $student = StudentsAdmissions::with('level', 'house', 'category', 'branch')->where("id", $request->student_uuid)->first();
        // get student photo
        $student_photo = $student->getFirstMediaUrl('student_profile') ?? asset('assets/images/profile/small/pic1.jpg');
        // $student_photo = $student->getMedia('student_profile')->first() ?? asset('assets/images/profile/small/pic1.jpg');
        // get financial records
        $records = Transaction::where("student_id", $request->student_uuid)->get();
        // get school data
        $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
        // school profile
        $schoolPhoto = $schoolData->getFirstMediaUrl('school_logo') ?? asset('assets/images/avatar/1.jpg');
        // dd($records);
        $pdf = Pdf::loadView("admin.dashboard.finance.reports.StudentFinanceReportDownload", compact('schoolTerm', 'schoolCurrency', 'records', 'student', 'student_photo', 'schoolData', 'schoolPhoto'))
            ->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
        return $pdf->stream($student->student_id . '_' . $student->student_firstname . '_' . $student->student_lastname . '_FinanceReport.pdf');
    }
/******************** ARREARS ******************************/

    public function get_student_finance_arrears_data(Request $request){
        $schoolTerm = TermAndAcademicYear();
        $schoolCurrency = SchoolCurrency();
        $arrears_records = [] ?? null;
        // gde student data
        $student = StudentsAdmissions::with('level', 'house', 'category', 'branch')->where("student_id", $request->student_id)->first();
        // get student photo
        $student_photo = $student->getFirstMediaUrl('student_profile') ?? asset('assets/images/profile/small/pic1.jpg');
        // $student_photo = $student->getMedia('student_profile')->first() ?? asset('assets/images/profile/small/pic1.jpg');
        // get financial arrears records
        $arrears_records = Transaction::where([
            "student_id" => $student->id,
            'payment_status' => 'awaiting_payment',
            'payment_status' => 'partial_payment'
            ])->get();
        // dd($arrears_records);
        // get school data
        $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
        // school profile
        $schoolPhoto = $schoolData->getFirstMediaUrl('school_logo') ?? asset('assets/images/avatar/1.jpg');
        // dd($records);
        return view('admin.dashboard.finance.reports.index', compact('schoolTerm', 'schoolCurrency', 'arrears_records', 'student', 'student_photo', 'schoolData', 'schoolPhoto'));
    }

    public function download_student_finance_arrears_data(Request $request){
        $schoolTerm = TermAndAcademicYear();
        $schoolCurrency = SchoolCurrency();
        $records = [] ?? null;
        // gde student data
        $student = StudentsAdmissions::with('level', 'house', 'category', 'branch')->where("id", $request->student_uuid)->first();
        // get student photo
        $student_photo = $student->getFirstMediaUrl('student_profile') ?? asset('assets/images/profile/small/pic1.jpg');
        // $student_photo = $student->getMedia('student_profile')->first() ?? asset('assets/images/profile/small/pic1.jpg');
        // get financial arrears records
        $arrears_records = Transaction::where([
            "student_id" => $student->id,
            'payment_status' => 'awaiting_payment',
            'payment_status' => 'partial_payment'
            ])->get();
        // get school data
        $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
        // school profile
        $schoolPhoto = $schoolData->getFirstMediaUrl('school_logo') ?? asset('assets/images/avatar/1.jpg');
        // dd($records);
        $pdf = Pdf::loadView("admin.dashboard.finance.reports.StudentFinanceArrearsReportDownload", compact('schoolTerm', 'schoolCurrency', 'arrears_records', 'student', 'student_photo', 'schoolData', 'schoolPhoto'))
            ->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
        return $pdf->stream($student->student_id . '_' . $student->student_firstname . '_' . $student->student_lastname . '_FinanceArrearsReport.pdf');
    }
}
