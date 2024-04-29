<?php

namespace App\Http\Controllers\Admin\Report\Attendance;

use App\Http\Controllers\Controller;
use App\Models\AssignLevelToDepartment;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\TermAndAcademicYear;

class AttendanceReportController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.report.attendance.index', compact('schoolTerm'));
    }



    public function get_attendance_dates(){
        $dates = DB::table('student_attendances')->select(DB::raw('distinct DATE(created_at) as attendance_date'))
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->orderByRaw('DATE(created_at) ASC')
            ->get();
        return $dates;
    }

    public function  get_levels_by_department(Request $request)
    {
        $department_id = $request->input('department_id');
        $levels = AssignLevelToDepartment::with("AssignLevel")
            ->where("department_id", $department_id)
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->get();
//        dd($levels);
        return $levels;
    }
}
