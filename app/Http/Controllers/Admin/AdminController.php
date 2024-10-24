<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Teacher;
use App\Models\StudentsAdmissions;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;

class AdminController extends Controller
{

    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $schoolData = School::where('id', Auth::guard('admin')->user()->school_id)->first();
        $schoolData->getMedia("school_logo")->first();
        // students
        $studentsCount = StudentsAdmissions::where('school_id', Auth::guard('admin')->user()->school_id)->count();
        $studentsBoys = StudentsAdmissions::where(['school_id' => Auth::guard('admin')->user()->school_id, 'student_gender' => 'Male'])->count();
        $studentsGirls = StudentsAdmissions::where(['school_id' => Auth::guard('admin')->user()->school_id, 'student_gender' => 'Female'])->count();
        // teachers
        $teachersCount = Teacher::where('school_id', Auth::guard('admin')->user()->school_id)->count();
        $teachersBoys = Teacher::where(['school_id' => Auth::guard('admin')->user()->school_id, 'teacher_gender' => 'Male'])->count();
        $teachersGirls = Teacher::where(['school_id' => Auth::guard('admin')->user()->school_id, 'teacher_gender' => 'Female'])->count();
        $dashRecords = [
            'studentsCount' => $studentsCount,
            'studentsBoys' => $studentsBoys,
            'studentsGirls' => $studentsGirls,
            'teachersCount' => $teachersCount,
            'teachersBoys' => $teachersBoys,
            'teachersGirls' => $teachersGirls
        ];
        // dd($dashRecords);
        return view('admin.dashboard.index', compact('schoolData', 'schoolTerm', 'dashRecords'));
    }

    //login
//    public function login(Request $request){
//        $request->validate([
//            'admin_email' => 'required|email',
//            'admin_password' => 'required'
//        ]);
//
//        $credentials = $request->only('admin_email', 'admin_password');
//
//        if(Auth::guard('admin')->attempt( $credentials ) ){
//            $admin = Admin::where('admin_email','=', $request->admin_email)->first();
//            Auth::guard('admin')->login($admin);
//            return redirect('')->route('admin.dashboard')->with('success', 'login successful');
//        }else{
//            return redirect('')->route('auth.login')->with('error', 'login failed');
//        }
//    }
}
