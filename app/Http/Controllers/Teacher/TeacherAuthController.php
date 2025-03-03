<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountPermission;
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

        $teacher = Teacher::where('teacher_email', $request->input('teacher_email'))->first();

        if ($teacher) {
            $accountPermission = AccountPermission::where('user_id', $teacher->id)->first(); // Check account permission

            if (Auth::guard('teacher')->attempt(['teacher_email' => $request->teacher_email, 'password' => $request->teacher_password])) {
                if ($accountPermission && $accountPermission->status == 1) {
                    Auth::guard('teacher')->login($teacher);
                    flash()->addSuccess('Login Successfully');
                    return redirect()->route('teacher_dashboard');
                } else {
                    $statusMessage = $accountPermission ? 'The account has been ' . ($accountPermission->status == 2 ? 'locked' : 'disabled') : 'not found';
                    flash()->addError($statusMessage);
                    return back();
                }
            } else {
                flash()->addError('Login failed');
                return back();
            }
        } else {
            flash()->addError('Teacher not found');
            return back();
        }
    }

    public function teacher_logout()
    {
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher_login');
    }
}
