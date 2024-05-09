<?php

namespace App\Http\Controllers\Admin\Subjects;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SubjectDatatable extends Controller
{
    public function __invoke()
    {
        $data = Subject::where('school_id',[Auth::guard('admin')->user()->school_id])
            ->orderBy('created_at', 'DESC');
//                ->where('description', '!=', '');
        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $subject_name = $row->subject_name;
                return $subject_name ?? '...';
            })
            ->addColumn('subject_type', function ($row) {
                $subject_type = $row->description;
                return $subject_type ?? '';
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
                $subject_id = $row->id;
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
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit_subject_modal" data-id="'.$subject_id.'">Edit Subject</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete_subject_modal" data-id="'.$subject_id.'">Delete Subject</a>
                            </div>
                        </div>
                    ';
//                return '<div class="d-flex">
//                            <a href="" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#edit_subject_modal" data-id="'.$subject_id.'">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a href="" class="btn btn-danger shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#delete_subject_modal" data-id="'.$subject_id.'">
//                                <i class="fa fa-trash"></i>
//                            </a>
//                         </div>';
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }
}
