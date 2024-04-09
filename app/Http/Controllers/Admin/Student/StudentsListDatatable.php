<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentsAdmissions;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StudentsListDatatable extends Controller
{
    public function __invoke(){
        $data = StudentsAdmissions::with('level')->where('school_id',[Auth::guard('admin')->user()
            ->school_id])->where('admission_status', '=', 1);
//        dd($data);
        return DataTables::of($data)
            ->addColumn('serial_number', function ($row){
                $serial_number = $row->student_id;
                return $serial_number ?? '...';
            })
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
            ->addColumn('student_status', function($row){
//                $department_status =;
                if( $row->student_status === 1 ){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">in</span>
                           </div>';
                }elseif( $row->student_status === 2 ){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-secondary text-uppercase">out</span>
                           </div>';
                }elseif( $row->student_status === 3 ){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-warning text-uppercase">stop</span>
                           </div>';
                }elseif( $row->student_status === 4 ){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-light text-uppercase">sick</span>
                           </div>';
                }elseif( $row->student_status === 5 ){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-info text-uppercase">restore</span>
                           </div>';
                }else{
                    return '<span class="badge badge-xl light badge-danger text-uppercase">dismiss</span>';
                }
//                return $remodelledStatus ?? '...';
            })
            ->addColumn('action', function($row){
                $student_id = $row->student_id;
                return '<div class="d-flex">
                            <a data-bs-toggle="modal" data-bs-target="#edit-student-modal" data-id="'
                    .$student_id.'"
                            class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#edit-student-status-modal" data-id="'
                    .$student_id.'"
                            class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-check-to-slot"></i>
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#delete-student-modal" data-id="'
                    .$student_id
                    .'" class="btn btn-danger shadow btn-xs sharp">
                                <i class="fa fa-trash"></i>
                            </a>
                         </div>';
            })
            ->rawColumns(['profile','name','student_status','action'])
            ->make(true);
    }
}
