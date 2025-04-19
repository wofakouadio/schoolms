<?php

namespace App\Http\Controllers\Admin\Student;

use App\Models\StudentsAdmissions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentsAdmissionsDatatable extends Controller
{
    public function __invoke(Request $request){

        // if (!$request->ajax()) {
        //     abort(404);
        // }
        $query = StudentsAdmissions::query()
        ->where('school_id', Auth::guard('admin')->user()->school_id)
        ->orderBy('created_at', 'DESC');

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
            $query->where('student_residency_status', $request->input('residency_status'));
        }
        if ($request->has('admission_status') && !empty($request->input('admission_status'))) {
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
            $query->whereHas('student', function ($q) use ($searchName) {
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
            // ->rawColumns(['profile','name','admission_status','action'])
            ->make(true);
    }
}
