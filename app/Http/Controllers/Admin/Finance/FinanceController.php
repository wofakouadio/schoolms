<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function App\Helpers\TermAndAcademicYear;

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
}
