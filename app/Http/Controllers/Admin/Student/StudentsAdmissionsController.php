<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Imports\StudentsAdmissionsImport;
use App\Models\Student;
use App\Models\StudentsAdmissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use function App\Helpers\TermAndAcademicYear;

class StudentsAdmissionsController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.student.admissions', compact('schoolTerm'));
    }

    //new student admission
    public function store(Request $request){
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

            $new_admission = StudentsAdmissions::create([
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
                'school_id' => Auth::guard('admin')->user()->school_id
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

    //edit student admission
    public function edit(Request $request){
     $data = StudentsAdmissions::where('id', $request->admission_id)->first();
     $data->getMedia('student_profile')->first();
     $data->getMedia('student_guardian_id_card')->first();
     return response()->json($data);
    }

    //update student admission
    public function update(Request $request){
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

            $update_admission = StudentsAdmissions::where('id', $request->admission_id)->update([
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
                'student_guardian_occupation' => $request->student_guardian_occupation
            ]);

            if($request->hasFile('student_profile')){
                $admission = StudentsAdmissions::where('id', $request->admission_id)->first();
                $admission->clearMediaCollection();
                $admission->addMedia($request->file('student_profile'))
                    ->toMediaCollection('student_profile');
            }

            if($request->hasFile('student_guardian_id_card')){
                $admission = StudentsAdmissions::where('id', $request->admission_id)->first();
                $admission->clearMediaCollection();
                $admission->addMedia($request->file('student_guardian_id_card'))
                    ->toMediaCollection('student_guardian_id_card');
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Admission updated successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    public function StoreBulk(Request $request){
        $request->validate([
            'admission_bulk' => ['required']
        ]);
        DB::beginTransaction();
        try {
            Excel::import(new StudentsAdmissionsImport, $request->file('admission_bulk'));
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Bulk uploaded successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //update student admission status
    public function updateAdmissionStatus(Request $request){
        DB::beginTransaction();

        if($request->admission_status == 1){
            try {
                $newAdmittedStudent = StudentsAdmissions::where('id', $request->admission_id)->first();
                //new student
                Student::create([
                    'student_id' => sprintf("%010d",Student::where('school_id', Auth::guard('admin')->user()
                            ->school_id)->count() + 1),
                    'student_firstname' => $newAdmittedStudent->student_firstname,
                    'student_othername' => $newAdmittedStudent->student_othername,
                    'student_lastname' => $newAdmittedStudent->student_lastname,
                    'student_gender' => $newAdmittedStudent->student_gender,
                    'student_dob' => $newAdmittedStudent->student_dob,
                    'student_pob' => $newAdmittedStudent->student_pob,
                    'student_branch' => $newAdmittedStudent->student_branch,
                    'student_level' => $newAdmittedStudent->student_level,
                    'student_house' => $newAdmittedStudent->student_house,
                    'student_category' => $newAdmittedStudent->student_category,
                    'student_residency_type' => $newAdmittedStudent->student_residency_type,
                    'student_guardian_name' => $newAdmittedStudent->student_guardian_name,
                    'student_guardian_contact' => $newAdmittedStudent->student_guardian_contact,
                    'student_guardian_address' => $newAdmittedStudent->student_guardian_address,
                    'student_guardian_email' => $newAdmittedStudent->student_guardian_email,
                    'student_guardian_occupation' => $newAdmittedStudent->student_guardian_occupation,
                    'student_password' => Hash::make('password'),
                    'school_id' => Auth::guard('admin')->user()->school_id
                ]);
                StudentsAdmissions::where('id', $request->admission_id)->update([
                    'admission_status' => $request->admission_status
                ]);
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'msg' => $newAdmittedStudent->student_firstname . ' '.$newAdmittedStudent->student_lastname.'
                    has been admitted as a New student successfully'
                ]);
            }catch (\Exception $th){
                DB::rollBack();
                return response()->json([
                    'status' => 201,
                    'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
                ]);
            }

        }else{
            try {
                StudentsAdmissions::where('id', $request->admission_id)->update([
                    'admission_status' => $request->admission_status
                ]);
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'msg' => 'Admission status updated successfully'
                ]);
            }catch(\Exception $th){
                DB::rollBack();
                return response()->json([
                    'status' => 201,
                    'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
                ]);
            }
        }
    }

    public function delete(Request $request){
        DB::beginTransaction();

        try {

            $delete_admission = StudentsAdmissions::where('id', $request->admission_id)->delete();

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Admission deleted successfully'
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
