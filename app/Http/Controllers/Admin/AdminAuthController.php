<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Contracts\Auth;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Flasher\SweetAlert\Prime\SweetAlertInterface;

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
                Alert::error('The account has been disabled...');
                // return back()->withErrors(['error' => 'The account has been disabled']);
                return back()->with('error', 'The account has been disabled');
            }
        } else {
            Alert::error('Login failed...');
            // return back()->withErrors(['error' => 'login failed']);
            return back()->with('warning', 'The account has been disabled');
        }
    }

    public function admin_logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login');
    }
}
