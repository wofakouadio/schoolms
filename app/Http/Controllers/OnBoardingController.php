<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\House;
use App\Models\School;
use App\Models\SchoolsPackage;
use \Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OnBoardingController extends Controller
{
    //to launch the on-boarding process
    public function index()
    {
        return view('get-started.register');
    }

    //on-boarding method to store new account user
    public function getStarted(Request $request){

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
            'school_logo' => 'image|mimes:jpeg,jpg,png,gif'
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
                    'school_name' => strtoupper($request->school_name),
                    'school_location' => $request->school_location,
                    'school_phoneNumber' => $request->school_phoneNumber,
                    'school_email' => $request->school_email,
                    'admin_id' => $reg_admin
                ]);
                if($request->hasFile('school_logo')){
                    $school->addMedia($request->file('school_logo'))
                        ->toMediaCollection('school_logo');
                }

                $reg_school = $school->id;
                if($reg_school){
                    $branch = Branch::create([
                        'branch_name' => strtoupper('HeadQuarters'),
                        'branch_description' => 'This is the main branch of ' . $school->school_name,
                        'branch_location' => $request->school_location,
                        'branch_email' => $request->school_email,
                        'branch_contact' => $request->school_phoneNumber,
                        'school_id' => $reg_school
                    ]);
                    Admin::where('id', $reg_admin)->update([
                        'school_id' => $reg_school,
                        'branch_id' => $branch->id
                    ]);
                }

                House::create([
                    'house_name' => 'N/A',
                    'house_description' => 'N/A',
                    'house_type' => 'N/A',
                    'school_id' => $reg_school,
                    'branch_id' => $branch->id
                ]);
            }

            DB::commit();
                return redirect()->route('package-selection')->with('school', $reg_school);
        } catch(\Exception $th){

            // dd($th);
            DB::rollBack();
            return redirect('/get-started')->with('message', 'Registration failed. Error:' . $th->getMessage());
        }
    }

    public function packageSelection(){
        return view('get-started.select-package');
    }

    public function processPackageSelection(Request $request){
        DB::beginTransaction();
        try {
            SchoolsPackage::create([
                'school_id' => $request->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Account created successfully. You will be redirected to the login page'
            ]);
        }catch(\Exception $th){
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }
}
