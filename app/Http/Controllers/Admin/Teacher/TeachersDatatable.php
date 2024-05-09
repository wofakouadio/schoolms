<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TeachersDatatable extends Controller
{
    public function __invoke(){
        $data = Teacher::where('school_id',[Auth::guard('admin')->user()->school_id])->orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('profile', function($row){

                if($row->getMedia('teacher_profile')->count() <= 0){
                    $profile = "<img src='". asset('assets/images/profile/small/pic1.jpg') ."' class='rounded-circle' width=35>";
                }else{
                    $profile = "<img src='".$row->getFirstMediaUrl('teacher_profile')."' class='rounded-circle' width=35>";
                }
                return $profile ?? '...';
            })
            ->addColumn('name', function ($row){
                $name = $row->teacher_firstname . ' ' . $row->teacher_othername . ' ' . $row->teacher_lastname;
                return $name ?? '...';
            })
            ->addColumn('gender', function($row){
                $gender = $row->teacher_gender;
                return $gender ?? '...';
            })
            ->addColumn('contact', function($row){
                $contact = $row->teacher_contact;
                return $contact ?? '...';
            })
            ->addColumn('email', function($row){
                $email = $row->teacher_email;
                return $email ?? '...';
            })
            ->addColumn('staff_id', function($row){
                $staff_id = $row->teacher_staff_id;
                return $staff_id ?? '...';
            })
            ->addColumn('rank', function($row){
                $rank = $row->teacher_rank;
                return $rank ?? '...';
            })
            ->addColumn('is_active', function($row){
//                $department_status =;
                if( $row->is_active === 1 ){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">active</span>
                           </div>';
                }else{
                    return '<span class="badge badge-xl light badge-danger text-uppercase">disabled</span>';
                }
//                return $remodelledStatus ?? '...';
            })
            ->addColumn('action', function($row){
                $teacher_id = $row->id;
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
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-teacher-modal" data-id="'.$teacher_id.'">Edit Teacher</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-teacher-modal" data-id="'.$teacher_id.'">Delete Teacher</a>
                            </div>
                        </div>
                    ';
//                return '<div class="d-flex">
//                            <a data-bs-toggle="modal" data-bs-target="#edit-teacher-modal" data-id="'.$teacher_id.'"
//                            class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a data-bs-toggle="modal" data-bs-target="#delete-teacher-modal" data-id="'.$teacher_id
//                    .'" class="btn btn-danger shadow btn-xs sharp">
//                                <i class="fa fa-trash"></i>
//                            </a>
//                         </div>';
//                <a href="/admin/department/{{$department->id}}/edit" class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a href="/admin/department/{{$department->id}}" class="btn btn-danger shadow btn-xs sharp">
//                                <i class="fa fa-trash"></i>
//                            </a>
            })
            ->rawColumns(['profile','name','is_active','action'])
            ->make(true);
    }
}
