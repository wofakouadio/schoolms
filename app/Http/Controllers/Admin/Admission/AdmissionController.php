<?php

namespace App\Http\Controllers\Admin\Admission;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    //index
    public function index(){
        return view('admin.dashboard.admission.index');
    }

    public function getStudentIdBySchoolId(Request $request){
        $school_id = $request->school_id;
        return sprintf("%010d",Student::where('id', $school_id)->count() + 1);
    }
}
