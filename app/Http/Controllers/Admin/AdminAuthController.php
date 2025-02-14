<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminPasswordReset;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Contracts\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Flasher\SweetAlert\Prime\SweetAlertInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminForgotPassword;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{

    public function admin_login()
    {
        return view('admin.auth.login');
    }

    public function forgot_password()
    {
        return view('admin.auth.forgot-password');
    }

    public function reset_password()
    {
        return view('admin.auth.reset-password');
    }

    public function admin_authentication(Request $request)
    {

        $request->validate([
            'admin_email' => 'required|email',
            'admin_password' => 'required'
        ]);

        //        $adminCredentials = $request->only('admin_email', 'admin_password');

        //        if(Auth::guard('admin')->attempt( $adminCredentials ) ){
        if (Auth::guard('admin')->attempt(['admin_email' => $request->admin_email, 'password' => $request->admin_password])) {
            $admin = Admin::where('admin_email', $request->input('admin_email'))->first();
            if($admin->is_active == 1){
                Auth::guard('admin')->login($admin);
                // Alert::success('Login Successfully...');
                // return redirect()->route('admin_dashboard')->with('message', 'login successful');

                flash()->option('timeout', 5000)->addSuccess('Login Successful');
                // return redirect()->route('admin_dashboard')->with('success', 'Login Successful');
                return redirect()->route('admin_dashboard');
            }else{
                // Alert::error('The account has been disabled...');
                // return back()->withErrors(['error' => 'The account has been disabled']);
                return back()->with('error', 'The account has been disabled');
            }
        } else {
            // Alert::error('Login failed...');
            // return back()->withErrors(['error' => 'login failed']);
            return back()->with('warning', 'Wrong User details');
        }
    }

    public function admin_logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login');
    }

    // admin forgot password
    public function admin_forgot_password(Request $request){
        $request->validate([
            'admin_email' => 'required|email'
        ]);

        $admin = Admin::where('admin_email', $request->admin_email)->first();
        if($admin){
            // create token
            $token = Str::random(64);
            // save the token
            AdminPasswordReset::create([
                'email' => $request->admin_email,
                'token' => $token
            ]);
            $MailMessage = 'Click the link below to reset your password';
            // send email
            Mail::to($request->admin_email)->send(new AdminForgotPassword($MailMessage, $token, $request->admin_email));
            // return the output
            return redirect()->route('admin_login')->with('success', 'Password reset link sent to your email');
        }else{
            return back()->with('error', 'Email not found');
        }
    }

    // get reset password page
    public function admin_reset_password_get($token, $email){
        // let check if token is valid
        $checkTokenIsValid = AdminPasswordReset::where([
            'email' => $email,
            'token' => $token,
            'deleted_at' => null
        ])->first();

        if(!$checkTokenIsValid){
            // Alert::error('Invalid token...');
            return redirect()->route('admin_login')->with('error', 'Invalid token 3');
        }else{
            return view('admin.auth.reset-password', compact('token', 'email'));
        }
    }

    // post reset password
    public function admin_reset_password_post(Request $request){
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ]);

        // validate the token
        $ValidateToken = AdminPasswordReset::where([
            'email' => $request->email,
            'token' => $request->token,
            'deleted_at' => null
        ])->first();

        if(!$ValidateToken){
            return redirect()->route('admin_login')->with('error', 'Invalid token');
        }

        try{
            // let update admin password
            Admin::where('admin_email', $request->email)->update([
                'admin_password' => Hash::make($request->new_password)
            ]);
            // delete the token
            AdminPasswordReset::where('email', $request->email)->delete();
            return redirect()->route('admin_login')->with('success', 'Password reset successful');
        }catch(\Exception $th){
            return back()->with('error', 'Password reset failed');
        }
    }

}
