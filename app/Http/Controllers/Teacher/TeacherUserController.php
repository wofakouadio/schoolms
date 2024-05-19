<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Term;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;

class TeacherUserController extends Controller
{

    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $schoolData = School::where('id', Auth::guard('teacher')->user()->school_id)->first();
        $schoolData->getMedia("school_logo")->first();
        return view('teacher.dashboard.index', ['schoolData' => $schoolData,
            'schoolTerm' => $schoolTerm]);
    }

    public function getActiveTermBySchoolID(){
        $data = [];
        $ActiveTerm = Term::with('academic_year')
            ->where('is_active', 1)
            ->where('school_id', Auth::guard('teacher')->user()->school_id)
            ->first();
        $data = [
            'term_id' => $ActiveTerm->id,
            'term_name' => $ActiveTerm->term_name,
            'academic_year_start' => $ActiveTerm->academic_year->academic_year_start,
            'academic_year_end' => $ActiveTerm->academic_year->academic_year_end,
        ];
        return response()->json($data);
    }

    public function getTermsBySchoolId(){
        $output = [];
        $terms = Term::with('academic_year')->where('school_id', Auth::guard('teacher')
            ->user()->school_id)
            ->get();
        $output[] .= "<option value=''>Choose</option>";
        foreach ($terms as $term){
            $output[] .= "<option value='".$term->id."'>".$term->term_name.' - '
                .$term->academic_year->academic_year_start."/".$term->academic_year->academic_year_end."</option>";
        }
        return $output;
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
