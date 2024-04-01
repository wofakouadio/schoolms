<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    //load teacher  page on dashboard
    public function index()
    {
        return view('admin.dashboard.teacher.index');
    }
    //insert new teacher record
    public function store(Request $request)
    {
        $request->validate([
            'teacher_title' => 'required',
            'teacher_firstname' => 'required',
            'teacher_lastname' => 'required',
            'teacher_gender' => 'required',
            'teacher_date_of_birth' => 'required',
            'teacher_place_of_birth' => 'required',
            'teacher_nationality' => 'required',
            'teacher_address' => 'required',
            'teacher_email' => 'required|lowercase|unique:' . Teacher::class,
            'teacher_contact' => 'required|unique:' . Teacher::class,
            'teacher_school_attended' => 'required',
            'teacher_admission_year' => 'required',
            'teacher_completion_year' => 'required',
            'teacher_country' => 'required',
            'teacher_first_appointment' => 'required',
            'teacher_present_school' => 'required',
            'teacher_qualification' => 'required',
            'teacher_professional' => 'required',
            'teacher_rank' => 'required',
            'teacher_ghana_card' => 'required'
        ]);

        // if ($request->hasFile('teacher_profile')){
        //     $teacher_profile = $request->file('teacher_profile')->store('teachers/profiles', 'public');
        // }else{
        //     $teacher_profile = 'user-profile-default.png';
        // }

        DB::beginTransaction();

        try {
            $teacher = Teacher::create([
                'teacher_staff_id' => $request->teacher_staff_id,
                'teacher_title' => $request->teacher_title,
                'teacher_firstname' => $request->teacher_firstname,
                'teacher_othername' => $request->teacher_oname,
                'teacher_lastname' => $request->teacher_lastname,
                'teacher_gender' => $request->teacher_gender,
                'teacher_dob' => $request->teacher_date_of_birth,
                'teacher_pob' => $request->teacher_place_of_birth,
                'teacher_nationality' => $request->teacher_nationality,
                'teacher_address' => $request->teacher_address,
                'teacher_email' => $request->teacher_email,
                'teacher_contact' => $request->teacher_contact,
                // 'teacher_profile' => $teacher_profile,
                'teacher_school_attended' => $request->teacher_school_attended,
                'teacher_admission_year' => $request->teacher_admission_year,
                'teacher_completion_year' => $request->teacher_completion_year,
                'teacher_country' => $request->teacher_country,
                'teacher_region' => $request->teacher_region,
                'teacher_district' => $request->teacher_district,
                'teacher_first_app' => $request->teacher_first_appointment,
                'teacher_present_school' => $request->teacher_present_school,
                'teacher_qualification' => $request->teacher_qualification,
                'teacher_professional' => $request->teacher_professional,
                'teacher_rank' => $request->teacher_rank,
                'teacher_circuit' => $request->teacher_circuit,
                'teacher_reg_number' => $request->teacher_reg_num,
                'teacher_district_file_number' => $request->teacher_district_file_number,
                'teacher_bank_name' => $request->teacher_bank_name,
                'teacher_account_number' => $request->teacher_acc_number,
                'teacher_bank_branch' => $request->teacher_bank_branch,
                'teacher_ssnit' => $request->teacher_ssnit,
                'teacher_ntc' => $request->teacher_ntc,
                'teacher_ghana_card' => $request->teacher_ghana_card,
                'school_id' => Auth::guard('admin')->user()->school_id //$request->school_id,
            ]);

            if ($request->hasFile('teacher_profile')) {

                $teacher->addMedia($request->file('teacher_profile'))
                    ->toMediaCollection('teacher_profile');
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Teacher created successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }
    //fetch teacher record based on teacher id
    public function edit(Request $request)
    {
        $data = Teacher::where('id', $request->teacher_id)->get();
        return response()->json($data);
    }
    //update teacher record
    public function update(Request $request)
    {
        $request->validate([
            'teacher_title' => 'required',
            'teacher_firstname' => 'required',
            'teacher_lastname' => 'required',
            'teacher_gender' => 'required',
            'teacher_date_of_birth' => 'required',
            'teacher_place_of_birth' => 'required',
            'teacher_nationality' => 'required',
            'teacher_address' => 'required',
            'teacher_email' => 'required|lowercase',
            'teacher_contact' => 'required',
            'teacher_school_attended' => 'required',
            'teacher_admission_year' => 'required',
            'teacher_completion_year' => 'required',
            'teacher_country' => 'required',
            'teacher_first_appointment' => 'required',
            'teacher_present_school' => 'required',
            'teacher_qualification' => 'required',
            'teacher_professional' => 'required',
            'teacher_rank' => 'required',
            'teacher_ghana_card' => 'required'
        ]);

        // if ($request->hasFile('teacher_profile')) {
        //     $teacher_profile = $request->file('teacher_profile')->store('teachers/profiles', 'public');
        // } else {
        //     $teacher_profile = $request->teacher_fetched_profile;
        // }

        DB::beginTransaction();

        try {
            $teacher = Teacher::where('id', $request->teacher_id)->update([
                'teacher_staff_id' => $request->teacher_staff_id,
                'teacher_title' => $request->teacher_title,
                'teacher_firstname' => $request->teacher_firstname,
                'teacher_othername' => $request->teacher_oname,
                'teacher_lastname' => $request->teacher_lastname,
                'teacher_gender' => $request->teacher_gender,
                'teacher_dob' => $request->teacher_date_of_birth,
                'teacher_pob' => $request->teacher_place_of_birth,
                'teacher_nationality' => $request->teacher_nationality,
                'teacher_address' => $request->teacher_address,
                'teacher_email' => $request->teacher_email,
                'teacher_contact' => $request->teacher_contact,
                // 'teacher_profile' => $teacher_profile,
                'teacher_school_attended' => $request->teacher_school_attended,
                'teacher_admission_year' => $request->teacher_admission_year,
                'teacher_completion_year' => $request->teacher_completion_year,
                'teacher_country' => $request->teacher_country,
                'teacher_region' => $request->teacher_region,
                'teacher_district' => $request->teacher_district,
                'teacher_first_app' => $request->teacher_first_appointment,
                'teacher_present_school' => $request->teacher_present_school,
                'teacher_qualification' => $request->teacher_qualification,
                'teacher_professional' => $request->teacher_professional,
                'teacher_rank' => $request->teacher_rank,
                'teacher_circuit' => $request->teacher_circuit,
                'teacher_reg_number' => $request->teacher_reg_num,
                'teacher_district_file_number' => $request->teacher_district_file_number,
                'teacher_bank_name' => $request->teacher_bank_name,
                'teacher_account_number' => $request->teacher_acc_number,
                'teacher_bank_branch' => $request->teacher_bank_branch,
                'teacher_ssnit' => $request->teacher_ssnit,
                'teacher_ntc' => $request->teacher_ntc,
                'teacher_ghana_card' => $request->teacher_ghana_card,
                'is_active' => $request->teacher_is_active ? 1 : 0
            ]);


            if ($request->hasFile('teacher_profile')) {

                $teacher->addMedia($request->file('teacher_profile'))
                    ->toMediaCollection('teacher_profile');
            }


            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Teacher updated successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }
    //delete teacher record
    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            Teacher::where('id', $request->teacher_id)->delete();

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Teacher deleted successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }
}
