<?php

namespace App\Http\Controllers\Admin\Assessment;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Mock;
use Illuminate\Http\Request;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MockDatatable extends Controller
{
    public function __invoke()
    {
        $data = Mock::where('school_id', Auth::guard('admin')->user()->school_id);

        return DataTables::of($data)

            ->addColumn('name', function ($row) {
                $name = $row->mock_type;
                return $name ?? '...';
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
                $mock_id = $row->id;
                return '<div class="d-flex">
                            <a class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#edit-mock-setup-modal" data-id="'.$mock_id.'">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#assign-subjects-to-mock-modal" data-id="'.$mock_id.'" data-name="'.$row->mock_type.'">
                                <i class="fas fa-check-to-slot"></i>
                            </a>
                            <a href="" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#delete-mock-setup-modal" data-id="'.$mock_id.'">
                                <i class="fa fa-trash"></i>
                            </a>
                         </div>';
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);

    }
}
