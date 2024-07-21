<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        return view('admin.dashboard.finance.student-bill.index', compact('schoolTerm', 'schoolCurrency', 'studentData'));
    }

    public function feesView(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.finance.student.bills.index', compact('schoolTerm'));
    }
}
