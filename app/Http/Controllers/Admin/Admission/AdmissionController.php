<?php

namespace App\Http\Controllers\Admin\Admission;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;

class AdmissionController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.admission.index', compact('schoolTerm'));
    }

    public function getStudentIdBySchoolId(Request $request)
    {
        $school_id = Auth::guard('admin')->user()->school_id; //$request->school_id;
        return sprintf("%010d", Student::where('id', $school_id)->count() + 1);
    }
}
