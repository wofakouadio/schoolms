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
    // store
    public function getStarted(Request $request){

        // dd($request->all());

        $request->validate([
            'admin_firstName' => ['required', 'string', 'max:255'],
            'admin_lastName' => ['required', 'string', 'max:255'],
            'admin_phoneNumber' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class],
            'admin_password' => ['required','confirmed'],
            'school_name' => ['required', 'string', 'max:255'],
            'school_location' => ['required', 'string', 'max:255'],
            'school_phoneNumber' => ['required', 'string', 'max:255'],
            'school_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.School::class],
        ]);

        DB::beginTransaction();

        try{
            $admin = Admin::create([
                'admin_firstName' => $request->admin_firstName,
                'admin_lastName' => $request->admin_lastName,
                'admin_phoneNumber' => $request->admin_phoneNumber,
                'admin_email' => $request->admin_email,
                'admin_password' => Hash::make($request->admin_password),
            ]);

            if($admin){
                $reg_admin = $admin->id;
                $school = School::create([
                    'school_name' => $request->school_name,
                    'school_location' => $request->school_location,
                    'school_phoneNumber' => $request->school_phoneNumber,
                    'school_email' => $request->school_email,
                    'admin_id' => $reg_admin
                ]);

                $reg_school = $school->id;
                if($reg_school){
                    Admin::where('id', $reg_admin)->update([
                        'school_id' => $reg_school
                    ]);
                }

                // dd(['admin id ' => $reg_admin, 'school_id' => $reg_school]);
            }

            DB::commit();

            // return redirect('/')->with('success', 'Welcome to the new world');
            return redirect('/get-started/select-package')->with('message', 'Welcome to the new World');

        } catch(\Exception $th){

            // dd($th);
            DB::rollBack();
            return redirect('/get-started')->with('message', 'Registration failed. Error:' . $th->getMessage());
        }




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
