<?php

namespace App\Http\Controllers\Admin\Report\MidTerm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function App\Helpers\TermAndAcademicYear;

class MidTermReportController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.report.mid-term.index', compact('schoolTerm'));
    }
}
