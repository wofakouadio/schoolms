<?php

namespace App\Http\Controllers\Admin\Assessment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function App\Helpers\TermAndAcademicYear;

class StudentAttendanceController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.assessment.attendance.index', compact('schoolTerm'));
    }
}
