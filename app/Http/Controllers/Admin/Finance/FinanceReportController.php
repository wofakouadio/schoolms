<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\StudentsAdmissions;
use App\Models\Transaction;
use App\Models\School;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
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
        // $records = [] ?? null;
        // $arrears_records = [] ?? null;
        // $is_active = '';
        // dd($transaction_types);
        // $studentsList = StudentsAdmissions::with('level', 'house', 'category')
        // ->where([
        //     'school_id' => Auth::guard('admin')->user()->school_id,
        //     'admission_status' => 1
        //     ])->orderBy('student_id', 'asc')
        // ->get()->groupBy('category.category_name');
        // return view('admin.dashboard.finance.reports.index', compact('schoolTerm', 'schoolCurrency', 'records', 'arrears_records', 'studentsList', 'is_active'));
        return view('admin.dashboard.finance.reports.index', compact('schoolTerm', 'schoolCurrency', ));
    }
/**************************************************/
/************************ Fees ************/
    // method to fetch student data
    public function get_student_finance_data(Request $request){
        $schoolTerm = TermAndAcademicYear();
        $schoolCurrency = SchoolCurrency();
        $records = [] ?? null;
        $student_uuid = $request->student_uuid;
        // gde student data
        $student = StudentsAdmissions::with('level', 'house', 'category', 'branch')->where("id", '=',$student_uuid)->first();
        // get student photo
        $student_photo = $student->getFirstMediaUrl('student_profile') ?? asset('assets/images/profile/small/pic1.jpg');
        // $student_photo = $student->getMedia('student_profile')->first() ?? asset('assets/images/profile/small/pic1.jpg');
        // get financial records
        $records = Transaction::where("student_id", $student_uuid)->get();
        // get school data
        $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
        // school profile
        $schoolPhoto = $schoolData->getFirstMediaUrl('school_logo') ?? asset('assets/images/avatar/1.jpg');
        $studentsList = StudentsAdmissions::with('level', 'house', 'category')
        ->where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            'admission_status' => 1
            ])->orderBy('student_id', 'asc')
        ->get()->groupBy('category.category_name');
        $data = [
            'student' => $student,
            'student_photo' => $student_photo,
            'schoolData' => $schoolData,
            'schoolPhoto' => $schoolPhoto,
        ];
        $is_active = 'fees';
        // dd($records);
        return view('admin.dashboard.finance.reports.index', compact('schoolTerm', 'schoolCurrency', 'records', 'data', 'studentsList', 'is_active'));
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
        $records = Transaction::where("student_id", $request->student_uuid)->orderBy('paid_at', 'desc')->get();
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
        // dd($request->all());
        $schoolTerm = TermAndAcademicYear();
        $schoolCurrency = SchoolCurrency();
        $arrears_records = [] ?? null;
        $student_uuid = $request->student_uuid;

        // $student_photo = $student->getMedia('student_profile')->first() ?? asset('assets/images/profile/small/pic1.jpg');
        // get financial arrears records
        $arrears_records = Transaction::where([
            "student_id" => $student_uuid,
            'payment_status' => 'awaiting_payment',
            'payment_status' => 'partial_payment'
            ])->orderBy('paid_at', 'desc')->get();
        // dd($arrears_records);
        // gde student data
        $student = StudentsAdmissions::with('level', 'house', 'category', 'branch')->where("id", "=", $student_uuid)->first();
        // get student photo
        $student_photo = $student->getFirstMediaUrl('student_profile') ?? asset('assets/images/profile/small/pic1.jpg');
        // get school data
        $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
        // school profile
        $schoolPhoto = $schoolData->getFirstMediaUrl('school_logo') ?? asset('assets/images/avatar/1.jpg');
        // student List
        $studentsList = StudentsAdmissions::with('level', 'house', 'category')
        ->where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            'admission_status' => 1
            ])->orderBy('student_id', 'asc')
        ->get()->groupBy('category.category_name');

        $data = [
            'student' => $student,
            'student_photo' => $student_photo,
            'schoolData' => $schoolData,
            'schoolPhoto' => $schoolPhoto,
        ];
        $is_active = 'arrears';
        // dd($student);

        return view('admin.dashboard.finance.reports.index', compact('schoolTerm', 'schoolCurrency', 'arrears_records', 'data', 'studentsList', 'is_active'));
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
            // 'payment_status' => 'partial_payment'
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

    public function general_transactional_report(Request $request)
    {
        // Don't hit this method if the request is not ajax
        // if (!$request->ajax()) {
        //     abort(404);
        // }

        // // If there are no values in the request or filters, return an empty array
        // if (empty($request->diet) && empty($request->student_id) && empty($request->category) && empty($request->level)) {
        // //     //get current diet id from examinations table where registration_status is 1
        //     $current_diet = Examination::where('authority_to_site', 1)->first();
        //     //assign the current diet id to the request diet
        //     $request->diet = $current_diet->id;
        //     // dd($request->diet);
        //     // $request->merge(['diet' => $current_diet->id]);
        //     // return response()->json([]);
        // }

        $query = Transaction::query();
            // ->whereIn('id', function ($query) {
            //     $query->select('examination_registration_id')
            //         ->from('examination_applied_subjects')
            //         ->whereNull('deferment')
            //         ->whereNotNull('paid_at');
            // });

        // // Apply filters
        if ($request->has('invoice_id') && !empty($request->input('invoice_id')) ) {
            $query->where('invoice_id', $request->input('invoice_id'));
        }
        if ($request->has('level') && !empty($request->input('level')) ) {
            $query->where('level_id', $request->input('level'));
        }
        if ($request->has('term') && !empty($request->input('term')) ) {
            $query->where('term_id', $request->input('term'));
        }
        if ($request->has('academic_year') && !empty($request->input('academic_year')) ) {
            $query->where('academic_year_id', $request->input('academic_year'));
        }
        if ($request->has('transaction_type') && !empty($request->input('transaction_type')) ) {
            $query->where('transaction_type', $request->input('transaction_type'));
        }
        if ($request->has('payment_status') && !empty($request->input('payment_status')) ) {
            $query->where('payment_status', $request->input('payment_status'));
        }
        if ($request->has('reference') && !empty($request->input('reference')) ) {
            $query->where('reference', $request->input('reference'));
        }
        if ($request->has('student_id') && !empty($request->input('student_id')) ) {
            $query->whereHas('student', function($q) use ($request){
                $q->where('student_id', $request->input('student_id'));
            });
        }
        if ($request->has('student_name') && !empty($request->input('student_name')) ) {
            $searchName = $request->input('student_name');
            $query->whereHas('student', function($q) use ($searchName){
                $q->where('student_firstname', 'LIKE', "%{$searchName}%")
                  ->orWhere('student_othername', 'LIKE', "%{$searchName}%")
                  ->orWhere('student_lastname', 'LIKE', "%{$searchName}%");
            });
        }
        if (($request->has('paid_at_to') && !empty($request->input('paid_at_to'))) && ($request->has('paid_at_from') && !empty($request->input('paid_at_from')))) {
            $query->whereBetween('paid_at', [$request->paid_at_from, $request->paid_at_to]);
        }
        if ($request->has('created_at_to') && $request->has('created_at_from')) {
            $query->whereBetween('created_at', [$request->created_at_from, $request->created_at_to]);
        }

        // if ($request->has('student_id') && !empty($request->input('student_id'))) {
        //     $query->whereHas('user', function ($q) use ($request) {
        //         $q->where('student_id', $request->input('student_id'));
        //     });
        // }

        // // if ($request->has('category') && !empty($request->input('category'))) {
        // //     $query->whereHas('examination', function ($q) use ($request) {
        // //         $q->where('exam_type', $request->input('category'));
        // //     });
        // // }

        // if ($request->has('level') && !empty($request->input('level'))) {

        //     $query->whereIn('id', function ($q) {
        //         $q->select('examination_registration_id')
        //             ->from('examination_applied_subjects')
        //             ->whereNull('deferment')
        //             ->whereNotNull('paid_at');
        //     });

        //     // $query->where('level', $request->input('level'));
        //     // ->whereHas('examinationAppliedSubjects', function ($q) {
        //     //     $q->whereNull('deferment_approval')
        //     //       ->whereNotNull('paid_at');
        //     // });
        //     // $query->whereHas('examinationAppliedSubjects', function ($q) use ($request) {
        //     //     $q->where('level', $request->input('level'));
        //     // });
        // }

        $data = $query->with('level', 'student', 'academic_year', 'term')
        ->where('school_id', '=' ,Auth::guard('admin')->user()->school_id)
        ->get();
        // dd($data);
        return Datatables::of($data)
            ->addColumn('invoice_id', function($row){
                return $row->invoice_id ?? '...';
            })
            ->addColumn('student_id', function ($row) {
                return $row->student->student_id ?? '...';
            })
            ->addColumn('student_name', function ($row) {
                return $row->student->student_firstname.' '.$row->student->student_othername.' '.$row->student->student_lastname ?? '...';
            })
            ->addColumn('level', function ($row) {
                return $row->level->level_name ?? '...';
            })
            ->addColumn('term', function ($row) {
                return $row->term->term_name ?? '...';
            })
            ->addcolumn('academic_year', function($row){
                return $row->academic_year->academic_year_start.'/'.$row->academic_year->academic_year_end ?? '...';
            })
            ->addcolumn('description', function($row){
                return $row->description ?? '...';
            })
            ->addColumn('amount_due', function ($row) {
                return $row->currency.' '.$row->amount_due ?? '...';
            })
            ->addColumn('amount_paid', function ($row) {
                return $row->currency.' '.$row->amount_paid ?? '...';
            })
            ->addColumn('balance', function ($row) {
                return $row->currency.' '.$row->balance ?? '...';
            })
            ->addColumn('transaction_type', function ($row) {
                return $row->transaction_type ?? '...';
            })
            ->addColumn('status', function ($row) {
                if($row->transaction_type == 'awaiting_payment'){
                    $status = 'Unpaid';
                }elseif($row->transaction_type == 'partial_payment'){
                    $status = 'Partially Paid';
                }else{
                    $status = 'Paid';
                }
                return $status ?? '...';
            })
            ->addColumn('paid_at', function ($row) {
                return $row->paid_at ?? '...';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at ?? '...';
            })
            ->addColumn('reference', function ($row) {
                return $row->reference ?? '...';
            })
            // ->addColumn('action', function ($row) {
            //     // if (auth()->user()->can('admin.reports.update') && $row->status === 'awaiting_payment') {
            //     //     $action = '<button data-id="' . $row->id . '"  data-toggle="modal" data-target="#default" class=" btn btn-primary btn-sm">Pay</button>';
            //     // } elseif ($row->status === 'Paid' && $row->documents != null) {
            //     //     if ($row->documents->extension === 'pdf') {
            //     //         $action = '<a target="_blank" href="http://docs.google.com/gview?url=' . $row->documents->id . '">View</a> |';
            //     //     } else {
            //     //         $action = '<a target="_blank" href="' . $row->documents->url . '">View</a>';
            //     //     }

            //     //     $action = $action . '<a href="/sms/admin/download/certificate/' . $row->documents->id . '">Download</a>';
            //     // }
            //     return '$action' ?? '...';
            // })
            ->make(true);

    }
}
