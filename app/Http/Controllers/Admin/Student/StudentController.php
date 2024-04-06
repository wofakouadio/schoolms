<?php

namespace App\Http\Controllers\Admin\Student;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function App\Helpers\TermAndAcademicYear;

class StudentController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.student.index', compact('schoolTerm'));
    }

    //auto generate student ID
    public function getStudentIdBySchoolId(Request $request){
        $school_id = Auth::guard('admin')->user()->school_id; //$request->school_id;
        return sprintf("%010d",Student::where('id', $school_id)->count() + 1);
    }

    //new student admission
    public function newStudentAdmission(Request $request){
        $request->validate([
            'student_firstname' => 'required|string',
            'student_lastname' => 'required|string',
            'student_gender' => 'required',
            'student_date_of_birth' => 'required',
            'student_place_of_birth' => 'required|string',
            'student_branch' => 'required',
            'student_level' => 'required',
            'student_house' => 'required',
            'student_residency_type' => 'required',
            'student_guardian_name' => 'required|string',
            'student_guardian_contact' => 'required',
            'student_guardian_address' => 'required|string',
            'student_guardian_email' => 'email',
            'student_guardian_occupation' => 'required',
            'student_guardian_id_card' => ['image','mimes:jpg,png,jpeg'],
            'student_profile' => ['image','mimes:jpg,png,jpeg']
        ]);

        DB::beginTransaction();

        try {

            $new_admission = Student::create([
                'student_firstname' => $request->student_firstname,
                'student_othername' => $request->student_oname,
                'student_lastname' => $request->student_lastname,
                'student_gender' => $request->student_gender,
                'student_dob' => $request->student_date_of_birth,
                'student_pob' => $request->student_place_of_birth,
                'student_branch' => $request->student_branch,
                'student_level' => $request->student_level,
                'student_house' => $request->student_house,
                'student_category' => $request->student_category,
                'student_residency_type' => $request->student_residency_type,
                'student_guardian_name' => $request->student_guardian_name,
                'student_guardian_contact' => $request->student_guardian_contact,
                'student_guardian_address' => $request->student_guardian_address,
                'student_guardian_email' => $request->student_guardian_email,
                'student_guardian_occupation' => $request->student_guardian_occupation,
                'student_password' => Hash::make('password'),
                'school_id' => Auth::guard('admin')->user()->school_id //$request->school_id
            ]);

            if($request->hasFile('student_profile')){
                $new_admission->addMedia($request->file('student_profile'))->toMediaCollection('student_profile');
            }

            if($request->hasFile('student_guardian_id_card')){
                $new_admission->addMedia($request->file('student_guardian_id_card'))->toMediaCollection('student_guardian_id_card');
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Admission submitted successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }


}
