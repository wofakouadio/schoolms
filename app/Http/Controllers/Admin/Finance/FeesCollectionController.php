<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\StudentsAdmissions;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolCurrency;


class FeesCollectionController extends Controller
{
    //index()
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $transactions = [] ?? null;
        return view("admin.dashboard.finance.transactions.index", compact("schoolTerm", "transactions"));
    }

    public function create(Request $request){
        $schoolTerm = TermAndAcademicYear();
        $student_id = $request->student_id;
        $schoolCurrency = SchoolCurrency();
        // dd($schoolCurrency);
        $getStudent = StudentsAdmissions::with('level')->where("student_id" , $student_id)->first();

        // get student transactions based on student id
        $transactions = Transaction::where([
            'student_id' => $getStudent->id,
            'school_id' => Auth::guard('admin')->user()->school_id
        ])->get();

        $studentData = [
            'student_uuid' => $getStudent->id,
            'student_id' => $student_id,
            'student_name' => $getStudent->student_firstname .' ' . $getStudent->student_othername . ' ' . $getStudent->lastname,
            'student_level' => $getStudent->level->level_name,

        ];
        // dd($transactions);
        return view("admin.dashboard.finance.transactions.index", compact("schoolTerm", "transactions", "studentData", "schoolCurrency"));
        // $transactions = [
        //     'studentTransactions' =>
        // ];
    }

    public function store(Request $request){
        dd($request->all());
    }
}
