<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\School;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    //index
    public function index(){
        return view('admin.dashboard.index');
    }

    //login
    public function login(Request $request){
        $request->validate([
            'admin_email' => 'required|email',
            'admin_password' => 'required'
        ]);

        $credentials = $request->only('admin_email', 'admin_password');

        if(Auth::guard('admin')->attempt( $credentials ) ){
            $admin = Admin::where('admin_email','=', $request->admin_email)->first();
            Auth::guard('admin')->login($admin);
            return redirect('')->route('admin.dashboard')->with('success', 'login successful');
        }else{
            return redirect('')->route('auth.login')->with('error', 'login failed');
        }
    }
}
