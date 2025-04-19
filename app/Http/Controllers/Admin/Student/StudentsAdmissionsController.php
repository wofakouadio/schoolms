<?php

namespace App\Http\Controllers\Admin\Student;

use App\Models\Bill;
use App\Models\Student;
use App\Models\BillingLog;
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
use App\Models\StudentsHealthRecords;
use App\Models\AssignLevelToDepartment;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\StudentsAdmissionsExport;
use App\Exports\StudentsAdmissionsRawListDataTableExport;
use App\Imports\StudentsAdmissionsImport;
use Maatwebsite\Excel\Excel as ExcelExcel;

// use App\DataTables\StudentAdmissionDataTable;
use function App\Helpers\TermAndAcademicYear;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StudentsAdmissionsController extends Controller
{
    //index
    // public function index(StudentAdmissionDataTable $dataTable)
    // {
    //     $schoolTerm = TermAndAcademicYear();

    //     return view('admin.dashboard.student.admissions', compact('schoolTerm'));
    // }

    public function index()
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
            'student_profile' => ['image', 'mimes:jpg,png,jpeg'],
            'student_birth_type' => 'required',
            'student_weight' => 'required',
            'student_having_chronic_disease' => 'required',
            'student_having_generic_disease' => 'required',
            'student_having_allergies' => 'required',
            'student_having_stitches' => 'required'
        ]);

        DB::beginTransaction();

        try {
            // admit new student
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

            // add student health report
            StudentsHealthRecords::create([
                'student_id' => $new_admission->id,
                'student_birth_type' => $request->student_birth_type,
                'student_birth_type_other' => $request->student_birth_type_other,
                'student_weight' => $request->student_weight,
                'student_having_chronic_disease' => $request->student_having_chronic_disease,
                'student_has_chronic_disease' => $request->student_has_chronic_disease,
                'student_having_generic_disease' => $request->student_having_generic_disease,
                'student_has_generic_disease' => $request->student_has_generic_disease,
                'student_having_allergies' => $request->student_having_allergies,
                'student_has_allergies' => $request->student_has_allergies,
                'student_having_stitches' => $request->student_having_stitches,
                'student_has_stitches' => $request->student_has_stitches,
                'causes_for_student_has_stitches' => $request->causes_for_student_has_stitches,
                'student_other_health_info' => $request->student_other_health_info,
                'school_id' => Auth::guard('admin')->user()->school_id,
                'branch_id' => $request->student_branch
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

    public function export_admissions_template(Request $request)
    {
        return Excel::download(new StudentsAdmissionsExport, 'template_admission.xlsx');
    }

    //edit student admission
    public function edit(Request $request)
    {
        $student = StudentsAdmissions::where('id', $request->admission_id)->first();
        $health = StudentsHealthRecords::where('student_id', $request->admission_id)->first();
        $student->getMedia('student_profile')->first();
        $student->getMedia('student_guardian_id_card')->first();
        $response = [
            'studentData' => $student,
            'healthData' => $health
        ];
        // dd($response);
        return response()->json($response);
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
            'student_profile' => ['image', 'mimes:jpg,png,jpeg'],
            'student_birth_type' => 'required',
            'student_weight' => 'required',
            'student_having_chronic_disease' => 'required',
            'student_having_generic_disease' => 'required',
            'student_having_allergies' => 'required',
            'student_having_stitches' => 'required'
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

            StudentsHealthRecords::where([
                'id' => $request->student_health_id,
            ])->update([
                'student_birth_type' => $request->student_birth_type,
                'student_birth_type_other' => $request->student_birth_type_other,
                'student_weight' => $request->student_weight,
                'student_having_chronic_disease' => $request->student_having_chronic_disease,
                'student_has_chronic_disease' => $request->student_has_chronic_disease,
                'student_having_generic_disease' => $request->student_having_generic_disease,
                'student_has_generic_disease' => $request->student_has_generic_disease,
                'student_having_allergies' => $request->student_having_allergies,
                'student_has_allergies' => $request->student_has_allergies,
                'student_having_stitches' => $request->student_having_stitches,
                'student_has_stitches' => $request->student_has_stitches,
                'causes_for_student_has_stitches' => $request->causes_for_student_has_stitches,
                'student_other_health_info' => $request->student_other_health_info
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
                        "payment_status" => 'awaiting_payment',
                        "student_id" => $newAdmittedStudent->id,
                        "level_id" => $newAdmittedStudent->student_level,
                        "description" => "Admission Fee",
                        "items" => "Admission Fee"
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
                            "payment_status" => 'awaiting_payment',
                            "student_id" => $newAdmittedStudent->id,
                            "level_id" => $newAdmittedStudent->student_level,
                            "description" => $x->item,
                            "items" => $x->item,
                        ]);
                    }
                }


                //update student admissions table with bill amounts
                $newAdmittedStudent->update([
                    'current_bill_amount' => $billbreakdown->bill_amount,
                    'total_bill_amount' => $newAdmittedStudent->previous_arrears + $billbreakdown->bill_amount,
                ]);

                //log bill in billing log
                $billing_log = BillingLog::create([
                    'student_id' => $newAdmittedStudent->id,
                    'academic_year_id' => $current_academic_year->id,
                    'term_id' => $current_academic_year->term->id,
                    'level_id' => $newAdmittedStudent->student_level,
                    'school_id' => $user->school_id,
                    'branch_id' => $user->branch_id,
                    'amount_billed' => $billbreakdown->bill_amount
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

    // delete student admission
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

    // get students by level id
    public function getStudentsByLevelId(Request $request)
    {
        $students = StudentsAdmissions::where([
            'student_level' => $request->level_id,
            'admission_status' => 1,
            'school_id' => Auth::guard('admin')->user()->school_id
        ])->get();
        return response()->json($students);
    }

    public function StudentsAdmissionsDatatable(Request $request){
        // if (!$request->ajax()) {
        //     abort(404);
        // }
        $query = StudentsAdmissions::query()
        ->where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            // 'admission_status' => 0
        ])->orderBy('created_at', 'DESC');

        // // Apply filters
        if ($request->has('level') && !empty($request->input('level'))) {
            $query->where('student_level', $request->input('level'));
        }
        if ($request->has('branch') && !empty($request->input('branch'))) {
            $query->where('student_branch', $request->input('branch'));
        }
        if ($request->has('category') && !empty($request->input('category'))) {
            $query->where('student_category', $request->input('category'));
        }
        if ($request->has('house') && !empty($request->input('house'))) {
            $query->where('student_house', $request->input('house'));
        }
        if ($request->has('residency_status') && !empty($request->input('residency_status'))) {
            $query->where('student_residency_type', $request->input('residency_status'));
        }
        if ($request->has('admission_status') && empty($request->input('admission_status'))) {
            $query->where('admission_status', '0');
        }else{
            $query->where('admission_status', $request->input('admission_status'));
        }
        if ($request->has('gender') && !empty($request->input('gender'))) {
            $query->where('student_gender', $request->input('gender'));
        }
        // if ($request->has('description') && !empty($request->input('description'))) {
        //     $description = $request->input('description');
        //     $query->where('description', 'LIKE', "%{$description}%");
        // }
        // if ($request->has('student_id') && !empty($request->input('student_id'))) {
        //     $query->whereHas('student', function ($q) use ($request) {
        //         $q->where('student_id', $request->input('student_id'));
        //     });
        // }
        if ($request->has('student_name') && !empty($request->input('student_name'))) {
            $searchName = $request->input('student_name');
            $query->where(function ($q) use ($searchName) {
                $q->where('student_firstname', 'LIKE', "%{$searchName}%")
                    ->orWhere('student_othername', 'LIKE', "%{$searchName}%")
                    ->orWhere('student_lastname', 'LIKE', "%{$searchName}%");
            });
        }
        if ($request->has('date_of_birth') && $request->filled('date_of_birth')) {
            $query->where('student_dob', $request->input('date_of_birth'));
        }
        if ($request->has('registration_date') && $request->filled('registration_date')) {
            $query->where('created_at', $request->input('registration_date'));
        }

        $data = $query->with('level', 'school', 'branch', 'house', 'category')->get();

        // dd($data);
        // $data = StudentsAdmissions::with('level')
        //     ->where('school_id',[Auth::guard('admin')->user()->school_id])
        //     ->orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('profile', function($row){
//                $mediaItems = $row->model->getMedia(*);
                if($row->getMedia('student_profile')->count() <= 0){
                    $profile = "<img src='". asset('assets/images/profile/small/pic1.jpg') ."' class='rounded-circle' width=35>";
                }else{
                    $profile = "<img src='".$row->getFirstMediaUrl('student_profile')."' class='rounded-circle' width=35>";
                }
                return $profile ?? '...';
            })
            ->addColumn('name', function ($row){
                $name = $row->student_firstname . ' ' . $row->student_othername . ' ' . $row->student_lastname;
                return $name ?? '...';
            })
            ->addColumn('dob', function ($row){
                return date('F j Y', strtotime($row->student_dob)) ?? '...';
            })
            ->addColumn('gender', function($row){
                $gender = $row->student_gender;
                return $gender ?? '...';
            })
            ->addColumn('level', function($row){
                $level = $row->level->level_name;
                return $level ?? '...';
            })
            ->addColumn('residency', function($row){
                $residency = $row->student_residency_type;
                return $residency ?? '...';
            })
            ->addColumn('admission_status', function($row){
//                $department_status =;
                if( $row->admission_status == 0 ){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-warning text-uppercase">pending admission</span>
                           </div>';
                }elseif( $row->admission_status == 1 ){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">admitted</span>
                           </div>';
                }else{
                    return '<span class="badge badge-xl light badge-danger text-uppercase">declined</span>';
                }
//                return $remodelledStatus ?? '...';
            })
            ->addColumn('action', function($row){
                $student_admission_id = $row->id;
                return '
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                        <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                        <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                    </g>
                                </svg>
                            </button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-student-admission-modal" data-id="'
                    .$student_admission_id.'">Edit Student Admission</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-student-admission-status-modal" data-id="'
                    .$student_admission_id.'">Edit Student Admission Status</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-student-admission-modal" data-id="'
                    .$student_admission_id.'">Delete Student Admission</a>
                            </div>
                        </div>
                    ';
//                return '<div class="d-flex">
//                            <a data-bs-toggle="modal" data-bs-target="#edit-student-admission-modal" data-id="'
//                    .$student_admission_id.'"
//                            class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a data-bs-toggle="modal" data-bs-target="#edit-student-admission-status-modal" data-id="'
//                    .$student_admission_id.'"
//                            class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-check-to-slot"></i>
//                            </a>
//                            <a data-bs-toggle="modal" data-bs-target="#delete-student-admission-modal" data-id="'
//                    .$student_admission_id
//                    .'" class="btn btn-danger shadow btn-xs sharp">
//                                <i class="fa fa-trash"></i>
//                            </a>
//                         </div>';
            })
            ->rawColumns(['profile','name','admission_status','action'])
            ->make(true);
    }

    public function export_StudentsAdmissionsDatatable(Request $request){
        // if (!$request->ajax()) {
        //     abort(404);
        // }
        $query = StudentsAdmissions::query()
        ->where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            // 'admission_status' => 0
        ]);
        // ->orderBy('created_at', 'DESC');

        // // Apply filters
        if ($request->has('level') && !empty($request->input('level'))) {
            $query->where('student_level', $request->input('level'));
        }
        if ($request->has('branch') && !empty($request->input('branch'))) {
            $query->where('student_branch', $request->input('branch'));
        }
        if ($request->has('category') && !empty($request->input('category'))) {
            $query->where('student_category', $request->input('category'));
        }
        if ($request->has('house') && !empty($request->input('house'))) {
            $query->where('student_house', $request->input('house'));
        }
        if ($request->has('residency_status') && !empty($request->input('residency_status'))) {
            $query->where('student_residency_type', $request->input('residency_status'));
        }
        if ($request->has('admission_status') && empty($request->input('admission_status'))) {
            $query->where('admission_status', '0');
        }else{
            $query->where('admission_status', $request->input('admission_status'));
        }
        if ($request->has('gender') && !empty($request->input('gender'))) {
            $query->where('student_gender', $request->input('gender'));
        }
        // if ($request->has('description') && !empty($request->input('description'))) {
        //     $description = $request->input('description');
        //     $query->where('description', 'LIKE', "%{$description}%");
        // }
        // if ($request->has('student_id') && !empty($request->input('student_id'))) {
        //     $query->whereHas('student', function ($q) use ($request) {
        //         $q->where('student_id', $request->input('student_id'));
        //     });
        // }
        if ($request->has('student_name') && !empty($request->input('student_name'))) {
            $searchName = $request->input('student_name');
            $query->where(function ($q) use ($searchName) {
                $q->where('student_firstname', 'LIKE', "%{$searchName}%")
                    ->orWhere('student_othername', 'LIKE', "%{$searchName}%")
                    ->orWhere('student_lastname', 'LIKE', "%{$searchName}%");
            });
        }
        if ($request->has('date_of_birth') && $request->filled('date_of_birth')) {
            $query->where('student_dob', $request->input('date_of_birth'));
        }
        if ($request->has('registration_date') && $request->filled('registration_date')) {
            $query->where('created_at', $request->input('registration_date'));
        }

        $data = $query->with('level', 'school', 'branch', 'house', 'category')->get();

        return Excel::download(new StudentsAdmissionsRawListDataTableExport($data), 'Students_Admissions_List_'.date('Y-m-d').'.xlsx');
    }
}
