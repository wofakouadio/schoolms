<?php

namespace App\Http\Controllers\Admin\Student;

use App\Models\Bill;
use App\Models\Student;
use App\Models\Department;
use App\Models\Transaction;
use App\Models\AcademicYear;
use App\Models\AdmissionFee;
use Illuminate\Http\Request;
use App\Models\StudentsAdmissions;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AssignLevelToDepartment;
use App\Imports\StudentsAdmissionsImport;

use App\DataTables\StudentAdmissionDataTable;
use function App\Helpers\TermAndAcademicYear;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StudentsAdmissionsController extends Controller
{
    //index
    public function index(StudentAdmissionDataTable $dataTable)
    {
        $schoolTerm = TermAndAcademicYear();

        return view('admin.dashboard.student.admissions', compact('schoolTerm'));
    }

    //new student admission
    public function store(Request $request)
    {
        $request->validate([
            'student_firstname' => 'required|string',
            'student_lastname' => 'required|string',
            'student_gender' => 'required',
            'student_date_of_birth' => 'required',
            'student_place_of_birth' => 'required|string',
            'student_branch' => 'required',
            'student_level' => 'required',
            // 'student_house' => 'required',
            'student_residency_type' => 'required',
            'student_guardian_name' => 'required|string',
            'student_guardian_contact' => 'required',
            'student_guardian_address' => 'required|string',
            // 'student_guardian_email' => 'email',
            'student_guardian_occupation' => 'required',
            'student_guardian_id_card' => ['image', 'mimes:jpg,png,jpeg'],
            'student_profile' => ['image', 'mimes:jpg,png,jpeg']
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
                'student_guardian_email' => $request->student_guardian_email ?? '',
                'student_guardian_occupation' => $request->student_guardian_occupation,
                'school_id' => Auth::guard('admin')->user()->school_id
            ]);

            if ($request->hasFile('student_profile')) {
                $new_admission->addMedia($request->file('student_profile'))->toMediaCollection('student_profile');
            }

            if ($request->hasFile('student_guardian_id_card')) {
                $new_admission->addMedia($request->file('student_guardian_id_card'))->toMediaCollection('student_guardian_id_card');
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Admission submitted successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //bulk upload of student information
    public function storebulk(Request $request)
    {
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
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //edit student admission
    public function edit(Request $request)
    {
        $data = StudentsAdmissions::where('id', $request->admission_id)->first();
        $data->getMedia('student_profile')->first();
        $data->getMedia('student_guardian_id_card')->first();
        return response()->json($data);
    }

    //update student admission
    public function update(Request $request)
    {
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
            'student_guardian_id_card' => ['image', 'mimes:jpg,png,jpeg'],
            'student_profile' => ['image', 'mimes:jpg,png,jpeg']
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
                'student_guardian_email' => $request->student_guardian_email ?? '',
                'student_guardian_occupation' => $request->student_guardian_occupation
            ]);

            if ($request->hasFile('student_profile')) {
                $admission = StudentsAdmissions::where('id', $request->admission_id)->first();
                $admission->clearMediaCollection();
                $admission->addMedia($request->file('student_profile'))
                    ->toMediaCollection('student_profile');
            }

            if ($request->hasFile('student_guardian_id_card')) {
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
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //update student admission status
    public function updateAdmissionStatus(Request $request)
    {
        DB::beginTransaction();

        if ($request->admission_status == 1) {
            try {
                $newAdmittedStudent = StudentsAdmissions::where('id', $request->admission_id)->first();
                //new student
                StudentsAdmissions::where('id', $request->admission_id)->update([
                    'student_id' => sprintf("%010d", StudentsAdmissions::where('school_id', Auth::guard('admin')->user()
                        ->school_id)->where('student_status', 1)->count() + 1),
                    'student_password' => Hash::make('password'),
                    'student_status' => $request->admission_status,
                    'admission_status' => $request->admission_status
                ]);

                $user = Auth::guard('admin')->user();
                // $bill = [];

                //get current academic year
                $current_academic_year = AcademicYear::where(['school_id' => $user->school_id, 'is_active' => 1])->first();

                //get student/level department
                $assign_level_to_depatment = AssignLevelToDepartment::where('level_id', $newAdmittedStudent->student_level)
                    ->where(['school_id' => $user->school_id, 'branch_id' => $user->branch_id])->first();

                //bill student for admission
                $getAdmissionBill = AdmissionFee::where([
                    'academic_year_id' => $current_academic_year->id,
                    'department_id' => $assign_level_to_depatment->department_id
                ])->first();

                if (!$getAdmissionBill) {
                    return response()->json([
                        'status' => 201,
                        'msg' => "Error: There is no Admission Bill. Kindly set it up."
                    ]);
                }

                $bill_exists = Transaction::where([
                    'academic_year_id' => $current_academic_year->id,
                    "student_id" => $newAdmittedStudent->id,
                    'level_id' => $newAdmittedStudent->student_level,
                    "description" => "Admission Fee",
                    'school_id' => $user->school_id,
                    'branch_id' => $user->branch_id
                ])->exists();

                if (!$bill_exists) {
                    //create admission bill
                    $admission_bill = Transaction::create([
                        "academic_year_id" => $current_academic_year->id,
                        "amount_due" => $getAdmissionBill->amount,
                        "student_id" => $newAdmittedStudent->id,
                        "level_id" => $newAdmittedStudent->student_level,
                        "description" => "Admission Fee"
                    ]);
                }

                //get current bill breakdown
                $billbreakdown = Bill::with('billsbreakdown')->where([
                    'academic_year' => $current_academic_year->id,
                    'level_id' => $newAdmittedStudent->student_level,
                    'school_id' => $user->school_id,
                    'branch_id' => $user->branch_id
                ])->first();

                if (!$billbreakdown) {
                    return response()->json([
                        'status' => 201,
                        'msg' => "Error: There is no active Bill. Kindly set it up."
                    ]);
                }

                foreach ($billbreakdown->billsbreakdown as $x) {

                    $bill_exists = Transaction::where([
                        'academic_year_id' => $current_academic_year->id,
                        "student_id" => $newAdmittedStudent->id,
                        "description" => $x->item,
                        'level_id' => $newAdmittedStudent->student_level,
                        'school_id' => $user->school_id,
                        'branch_id' => $user->branch_id
                    ])->exists();

                    if (!$bill_exists) {
                        Transaction::create([
                            "academic_year_id" => $current_academic_year->id,
                            "amount_due" => $x->amount,
                            "student_id" => $newAdmittedStudent->id,
                            "level_id" => $newAdmittedStudent->student_level,
                            "description" => $x->item
                        ]);
                    }
                }


                //update student admissions table with bill amounts
                $newAdmittedStudent->update([
                    'current_bill_amount' => $billbreakdown->bill_amount,
                    'total_bill_amount' => $newAdmittedStudent->previous_arrears + $billbreakdown->bill_amount,
                ]);

                DB::commit();
                return response()->json([
                    'status' => 200,
                    'msg' => $newAdmittedStudent->student_firstname . ' ' . $newAdmittedStudent->student_lastname . '
                    has been admitted as a New student successfully'
                ]);
            } catch (\Exception $th) {
                DB::rollBack();
                return response()->json([
                    'status' => 201,
                    'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
                ]);
            }
        } else {
            try {
                StudentsAdmissions::where('id', $request->admission_id)->update([
                    'admission_status' => $request->admission_status
                ]);
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'msg' => 'Admission status updated successfully'
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

    public function delete(Request $request)
    {
        DB::beginTransaction();

        try {

            $delete_admission = StudentsAdmissions::where('id', $request->admission_id)->delete();

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Admission deleted successfully'
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
