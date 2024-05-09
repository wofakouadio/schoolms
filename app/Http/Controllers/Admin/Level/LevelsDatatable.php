<?php

namespace App\Http\Controllers\Admin\Level;

use App\Models\Level;
use App\Models\Department;
use Illuminate\Http\Request;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LevelsDatatable extends Controller
{
    public function __invoke()
    {
        $data = Level::with('branch')->where('school_id', [Auth::guard('admin')->user()
            ->school_id])->orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $name = $row->level_name;
                return $name ?? '...';
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
                $level_id = $row->id;
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
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-level-modal" data-id="' . $level_id . '">Edit Level</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#assign-subjects-to-level-modal" data-id="' .
                    $level_id . '" data-name="'.$row->level_name.'">Assign Subjects to Level</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-level-modal" data-id="' . $level_id.'">Delete Level</a>
                            </div>
                        </div>
                    ';
//                return '<div class="d-flex">
//                            <a data-bs-toggle="modal" data-bs-target="#edit-level-modal" data-id="' . $level_id . '"
//                            class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a data-bs-toggle="modal" data-bs-target="#assign-subjects-to-level-modal" data-id="' .
//                    $level_id . '" data-name="'.$row->level_name.'"
//                            class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-check-to-slot"></i>
//                            </a>
//                            <a data-bs-toggle="modal" data-bs-target="#delete-level-modal" data-id="' . $level_id
//                    . '" class="btn btn-danger shadow btn-xs sharp">
//                                <i class="fa fa-trash"></i>
//                            </a>
//                         </div>
//                ';
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }
}
