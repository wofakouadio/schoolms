<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flasher\Prime\FlasherInterface;
use RealRashid\SweetAlert\Facades\Alert;

class TeacherAuthController extends Controller
{

    public function teacher_login()
    {
        return view('teacher.auth.login');
    }

    public function forgot_password()
    {
        return view('teacher.auth.forgot-password');
    }

    public function teacher_authentication(Request $request)
    {
        $request->validate([
            'teacher_email' => 'required|email',
            'teacher_password' => 'required'
        ]);

        if (Auth::guard('teacher')->attempt(['teacher_email' => $request->teacher_email, 'password' =>
            $request->teacher_password])) {
            $teacher = Teacher::where('teacher_email', $request->input('teacher_email'))->first();
            if($teacher->is_active == 1){
                Auth::guard('teacher')->login($teacher);
                flash()->success( 'Login Successfully');
                return redirect()->route('teacher_dashboard');
            }else{
                flash()->error('The account has been disabled');
                return back();
            }
        } else {
            flash()->error('Login failed');
            return back();
        }
    }

    public function teacher_logout()
    {
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher_login');
    }
}
