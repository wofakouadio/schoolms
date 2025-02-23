<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\StudentsAdmissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolCurrency;

class FinanceController extends Controller
{
    //index finance dashboard
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.finance.index', compact('schoolTerm'));
    }

    //index finance expenditure
    public function expenditureView(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.finance.expenditure.index', compact('schoolTerm'));
    }

    public function billsView(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.finance.bills.index', compact('schoolTerm'));
    }

    public function studentBillView(){
        $schoolTerm = TermAndAcademicYear();
        $schoolCurrency = SchoolCurrency();
        $studentData = null;
        // $categories = Category::where(['school_id' => Auth::guard('admin')->user()->school_id, 'is_active' => 1])->get();
        // $studentsList = StudentsAdmissions::with('level', 'house', 'category')
        // ->where([
        //     'school_id' => Auth::guard('admin')->user()->school_id,
        //     'admission_status' => 1
        //     ])->orderBy('student_id', 'asc')
        // ->get()->groupBy('category.category_name');
        // dd($studentsList);
        return view('admin.dashboard.finance.student-bill.index', compact('schoolTerm', 'schoolCurrency', 'studentData'));
    }

    public function feesView(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.finance.student.bills.index', compact('schoolTerm'));
    }
}
