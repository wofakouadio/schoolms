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
        $data = Teacher::where('school_id',[Auth::guard('admin')->user()->school_id]);
        // $data = DB::select('select * FROM teachers WHERE school_id = ?', [Auth::guard('admin')
        //     ->user()->school_id]);

        return DataTables::of($data)
            ->addColumn('profile', function($row){
                if($row->teacher_profile === "user-profile-default.png"){
                    $profile = "<img src='/storage/teachers/profiles/".$row->teacher_profile."' class='rounded-circle' width=35>";
                }else{
                    $profile = "<img src='/storage/".$row->teacher_profile."' class='rounded-circle' width=35>";
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
                $teacher_id = $row->id;
                return '<div class="d-flex">
                            <a data-bs-toggle="modal" data-bs-target="#edit-teacher-modal" data-id="'.$teacher_id.'"
                            class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#delete-teacher-modal" data-id="'.$teacher_id
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
            ->rawColumns(['profile','name','is_active','action'])
            ->make(true);
    }
}
