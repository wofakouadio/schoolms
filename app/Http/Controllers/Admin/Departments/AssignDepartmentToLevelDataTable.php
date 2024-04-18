<?php

namespace App\Http\Controllers\Admin\Departments;

use App\Http\Controllers\Controller;
use App\Models\AssignLevelToDepartment;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AssignDepartmentToLevelDataTable extends Controller
{
    public function __invoke()
    {

        $data = AssignLevelToDepartment::with('AssignLevel')->with('AssignDepartment')->where('school_id', Auth::guard('admin')
            ->user()->school_id);
//        dd($data);
        return DataTables::of($data)
            ->addColumn('level', function ($row) {
                $level = $row->AssignLevel->level_name;
                return $level ?? '...';
            })
            ->addColumn('department', function ($row) {
                $department = $row->AssignDepartment->department_name;
                return $department ?? '...';
            })
            ->addColumn('branch', function ($row) {
                $branch = $row->branch->branch_name;
                return $branch ?? '...';
            })
            ->addColumn('is_active', function ($row) {
                if ($row->is_active === 0) {
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">active</span>
                           </div>';
                } else {
                    return '<span class="badge badge-xl light badge-danger text-uppercase">disabled</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $department_id = $row->id;
                return '<div class="d-flex">
                            <a class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#edit-department-modal" data-id="'.$department_id.'">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#delete-department-modal" data-id="'.$department_id.'">
                                <i class="fa fa-trash"></i>
                            </a>
                         </div>';
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }
}
