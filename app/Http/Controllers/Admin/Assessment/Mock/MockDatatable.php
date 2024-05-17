<?php

namespace App\Http\Controllers\Admin\Assessment\Mock;

use App\Http\Controllers\Controller;
use App\Models\Mock;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MockDatatable extends Controller
{
    public function __invoke()
    {
        $data = Mock::where('school_id', Auth::guard('admin')->user()->school_id)->orderBy('created_at', 'DESC');

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
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-mock-setup-modal" data-id="'.$mock_id.'">Edit Mock</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#assign-subjects-to-mock-modal" data-id="'.$mock_id.'" data-name="'.$row->mock_type.'">Assign Subjects to Mock</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-mock-setup-modal" data-id="'.$mock_id.'">Delete Mock</a>
                            </div>
                        </div>
                    ';
//                return '<div class="d-flex">
//                            <a class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#edit-mock-setup-modal" data-id="'.$mock_id.'">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#assign-subjects-to-mock-modal" data-id="'.$mock_id.'" data-name="'.$row->mock_type.'">
//                                <i class="fas fa-check-to-slot"></i>
//                            </a>
//                            <a href="" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#delete-mock-setup-modal" data-id="'.$mock_id.'">
//                                <i class="fa fa-trash"></i>
//                            </a>
//                         </div>';
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);

    }
}
