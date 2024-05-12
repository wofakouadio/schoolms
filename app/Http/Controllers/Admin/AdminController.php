<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;

class AdminController extends Controller
{

    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $schoolData = School::where('id', Auth::guard('admin')->user()->school_id)->first();
        $schoolData->getMedia("school_logo")->first();
        return view('admin.dashboard.index', ['schoolData' => $schoolData,
            'schoolTerm' => $schoolTerm]);
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
