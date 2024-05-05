<?php

namespace App\Http\Controllers\Admin\Departments;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DepartmentsDatatable extends Controller
{
    public function __invoke()
    {

        $data = Department::with('branch')->where('school_id', Auth::guard('admin')->user()->school_id);

        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $department_name = $row->name;
                return $department_name ?? '...';
            })
            ->addColumn('branch', function ($row) {
                $branch = $row->branch->branch_name;
                return $branch ?? '...';
            })
            ->addColumn('is_active', function ($row) {
                if ($row->is_active === 1) {
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">active</span>
                           </div>';
                } else {
                    return '<span class="badge badge-xl light badge-danger text-uppercase">disabled</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $department_id = $row->id;
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
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-department-modal" data-id="' . $department_id . '">Edit Department</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#assign-leveltodepartment-modal" data-id="' . $department_id . '"
                            data-department_name="' . $row->name . '"
                            data-branch_id="' . $row->branch->id . '"
                            data-branch_name="' . $row->branch->branch_name . '">Assign Levels to Department</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-department-modal" data-id="' . $department_id . '">Delete Department</a>
                            </div>
                        </div>
                    ';
//                return '<div class="d-flex">
//                            <a class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#edit-department-modal" data-id="' . $department_id . '">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#assign-leveltodepartment-modal" data-id="' . $department_id . '"
//                            data-department_name="' . $row->name . '"
//                            data-branch_id="' . $row->branch->id . '"
//                            data-branch_name="' . $row->branch->branch_name . '">
//                                <i class="fas fa-check-to-slot"></i>
//                            </a>
//                            <a href="" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#delete-department-modal" data-id="' . $department_id . '">
//                                <i class="fa fa-trash"></i>
//                            </a>
//                         </div>';
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }
}
