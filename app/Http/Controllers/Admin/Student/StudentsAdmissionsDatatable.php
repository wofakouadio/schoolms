<?php

namespace App\Http\Controllers\Admin\Student;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StudentsAdmissionsDatatable extends Controller
{
    public function __invoke(){
        $data = Student::with('level', 'model')->where('school_id',[Auth::guard('admin')->user()->school_id]);
        // $data = DB::select('select * FROM teachers WHERE school_id = ?', [Auth::guard('admin')
        //     ->user()->school_id]);
        return DataTables::of($data)
            ->addColumn('profile', function($row){
//                $mediaItems = $row->model->getMedia(*);
//                if($row->teacher_profile === "user-profile-default.png"){
//                    $profile = "<img src='/storage/teachers/profiles/".$row->teacher_profile."' class='rounded-circle' width=35>";
//                }else{
//                    $profile = "<img src='/storage/".$row->teacher_profile."' class='rounded-circle' width=35>";
//                }
//                return $profile ?? '...';
            })
            ->addColumn('name', function ($row){
                $name = $row->student_firstname . ' ' . $row->student_othername . ' ' . $row->student_lastname;
                return $name ?? '...';
            })
            ->addColumn('dob', function ($row){
                return date('l F j Y', strtotime($row->student_dob)) ?? '...';
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
                if( $row->admission_status === 0 ){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-warning text-uppercase">pending</span>
                           </div>';
                }else{
                    return '<span class="badge badge-xl light badge-danger text-uppercase">admitted</span>';
                }
//                return $remodelledStatus ?? '...';
            })
            ->addColumn('is_active', function($row){
//                $department_status =;
                if( $row->is_active === 0 ){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">active</span>
                           </div>';
                }else{
                    return '<span class="badge badge-xl light badge-danger text-uppercase">disabled</span>';
                }
//                return $remodelledStatus ?? '...';
            })
            ->addColumn('action', function($row){
                $student_admission_id = $row->id;
                return '<div class="d-flex">
                            <a data-bs-toggle="modal" data-bs-target="#edit-student-admission-modal" data-id="'
                    .$student_admission_id.'"
                            class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#delete-student-admission-modal" data-id="'
                    .$student_admission_id
                    .'" class="btn btn-danger shadow btn-xs sharp">
                                <i class="fa fa-trash"></i>
                            </a>
                         </div>';
//                <a href="/admin/department/{{$department->id}}/edit" class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a href="/admin/department/{{$department->id}}" class="btn btn-danger shadow btn-xs sharp">
//                                <i class="fa fa-trash"></i>
//                            </a>
            })
            ->rawColumns(['profile','name','admission_status', 'is_active','action'])
            ->make(true);
    }
}
