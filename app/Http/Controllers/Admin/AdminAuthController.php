<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Contracts\Auth;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{

    public function admin_login()
    {
        \Log::debug('Test debug message');
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
            //            dd($admin);
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin_dashboard')->with('message', 'login successful');
        } else {
            return back()->withErrors(['error' => 'login failed']);
        }
    }

    public function admin_logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login');
    }
}
