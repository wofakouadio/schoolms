<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use function App\Helpers\TermAndAcademicYear;



class TeacherController extends Controller
{
    //load teacher  page on dashboard
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.teacher.index', compact('schoolTerm'));
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
            'teacher_contact' => 'required|digits:10|unique:' . Teacher::class,
            'teacher_school_attended' => 'string',
            'teacher_admission_year' => 'required',
            'teacher_completion_year' => 'required',
            'teacher_country' => 'required',
            'teacher_first_appointment' => 'required',
            'teacher_present_school' => 'required',
            'teacher_qualification' => 'required',
            'teacher_professional' => 'required',
            'teacher_rank' => 'required',
            'teacher_ghana_card' => 'required',
            'teacher_profile' => ['image','mimes:jpg,png,jpeg']
        ]);

        DB::beginTransaction();

        try {
            $teacher = Teacher::create([
                'teacher_staff_id' => $request->teacher_staff_id,
                'teacher_title' => $request->teacher_title,
                'teacher_firstname' => strtoupper($request->teacher_firstname),
                'teacher_othername' => strtoupper($request->teacher_oname),
                'teacher_lastname' => strtoupper($request->teacher_lastname),
                'teacher_gender' => $request->teacher_gender,
                'teacher_dob' => $request->teacher_date_of_birth,
                'teacher_pob' => strtoupper($request->teacher_place_of_birth),
                'teacher_nationality' => strtoupper($request->teacher_nationality),
                'teacher_address' => strtoupper($request->teacher_address),
                'teacher_email' => $request->teacher_email,
                'teacher_contact' => $request->teacher_contact,
                'teacher_school_attended' => strtoupper($request->teacher_school_attended),
                'teacher_admission_year' => $request->teacher_admission_year,
                'teacher_completion_year' => $request->teacher_completion_year,
                'teacher_country' => strtoupper($request->teacher_country),
                'teacher_region' => strtoupper($request->teacher_region),
                'teacher_district' => strtoupper($request->teacher_district),
                'teacher_first_app' => $request->teacher_first_appointment,
                'teacher_present_school' => strtoupper($request->teacher_present_school),
                'teacher_qualification' => $request->teacher_qualification,
                'teacher_professional' => $request->teacher_professional,
                'teacher_rank' => $request->teacher_rank,
                'teacher_circuit' => strtoupper($request->teacher_circuit),
                'teacher_reg_number' => strtoupper($request->teacher_reg_num),
                'teacher_district_file_number' => strtoupper($request->teacher_district_file_number),
                'teacher_bank_name' => strtoupper($request->teacher_bank_name),
                'teacher_account_number' => $request->teacher_acc_number,
                'teacher_bank_branch' => strtoupper($request->teacher_bank_branch),
                'teacher_ssnit' => strtoupper($request->teacher_ssnit),
                'teacher_ntc' => $request->teacher_ntc,
                'teacher_ghana_card' => strtoupper($request->teacher_ghana_card),
                'teacher_password' => Hash::make('password'),
                'school_id' => Auth::guard('admin')->user()->school_id
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
       $data = Teacher::where('id', $request->teacher_id)->first();
       $data->getMedia('teacher_profile')->first();
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
            'teacher_contact' => 'required|digits:10',
            'teacher_school_attended' => 'required',
            'teacher_admission_year' => 'required',
            'teacher_completion_year' => 'required',
            'teacher_country' => 'required',
            'teacher_first_appointment' => 'required',
            'teacher_present_school' => 'required',
            'teacher_qualification' => 'required',
            'teacher_professional' => 'required',
            'teacher_rank' => 'required',
            'teacher_ghana_card' => 'required',
            'teacher_profile' => ['image','mimes:jpg,png,jpeg']
        ]);

        DB::beginTransaction();

        try {
            $teacher = Teacher::where('id', $request->teacher_id)->update([
                'teacher_staff_id' => $request->teacher_staff_id,
                'teacher_title' => $request->teacher_title,
                'teacher_firstname' => strtoupper($request->teacher_firstname),
                'teacher_othername' => strtoupper($request->teacher_oname),
                'teacher_lastname' => strtoupper($request->teacher_lastname),
                'teacher_gender' => $request->teacher_gender,
                'teacher_dob' => $request->teacher_date_of_birth,
                'teacher_pob' => strtoupper($request->teacher_place_of_birth),
                'teacher_nationality' => strtoupper($request->teacher_nationality),
                'teacher_address' => strtoupper($request->teacher_address),
                'teacher_email' => $request->teacher_email,
                'teacher_contact' => $request->teacher_contact,
                'teacher_school_attended' => strtoupper($request->teacher_school_attended),
                'teacher_admission_year' => $request->teacher_admission_year,
                'teacher_completion_year' => $request->teacher_completion_year,
                'teacher_country' => strtoupper($request->teacher_country),
                'teacher_region' => strtoupper($request->teacher_region),
                'teacher_district' => strtoupper($request->teacher_district),
                'teacher_first_app' => $request->teacher_first_appointment,
                'teacher_present_school' => strtoupper($request->teacher_present_school),
                'teacher_qualification' => $request->teacher_qualification,
                'teacher_professional' => $request->teacher_professional,
                'teacher_rank' => $request->teacher_rank,
                'teacher_circuit' => strtoupper($request->teacher_circuit),
                'teacher_reg_number' => strtoupper($request->teacher_reg_num),
                'teacher_district_file_number' => strtoupper($request->teacher_district_file_number),
                'teacher_bank_name' => strtoupper($request->teacher_bank_name),
                'teacher_account_number' => $request->teacher_acc_number,
                'teacher_bank_branch' => strtoupper($request->teacher_bank_branch),
                'teacher_ssnit' => strtoupper($request->teacher_ssnit),
                'teacher_ntc' => strtoupper($request->teacher_ntc),
                'teacher_ghana_card' => strtoupper($request->teacher_ghana_card),
                'is_active' => $request->teacher_is_active ? 1 : 0
            ]);


            if ($request->hasFile('teacher_profile')) {
                $teacher = Teacher::where('id', $request->teacher_id)->first();
                $teacher->clearMediaCollection('teacher_profile');
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

    //assign level to teacher index
    public function assignLevelsToTeacherIndex()
    {
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.teacher.assign_level_to_teacher', compact('schoolTerm'));
    }

    public function getTeachersBySchool(){
//        $data = [];
//        $data[] = '<option value="">Choose</option>';
        $teachers = Teacher::where('school_id', Auth::guard('admin')->user()->school_id)
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->get();
//        foreach ($teachers as $teacher){
//            $data[] = '<option value="'.$teacher->id.'">' . $teacher->teacher_firstname . ' ' .
//                $teacher->teacher_lastname . '</option>';
//        }
        return response()->json($teachers);
    }

    public function assign_subjects_to_teacher(Request $request){
        $teacher = $request->teacher;
        $level = $request->level;
        $data = [];

        DB::beginTransaction();

        try {
            foreach($request->subject as $subject){
                $data[] = [
                    'id' => Str::uuid(),
                    'teacher_id' => $teacher,
                    'level_id' => $level,
                    'subject_id' => $subject,
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }

            DB::table('subjects_to_teachers')->insert($data);
            DB::commit();

            Alert::success('Notification','Subjects assigned to Teacher Successfully');
            return back();
//            return redirect()->route('assign-levels-to-teacher');
        } catch (\Exception $th) {
            DB::rollBack();
//            dd($th->getMessage());
            Alert::alert('Notification',$th->getMessage());
            return back();
        }


//        dd($request->all());

    }
}
