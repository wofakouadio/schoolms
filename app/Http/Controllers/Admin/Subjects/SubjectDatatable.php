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
        $data = Subject::where('school_id',[Auth::guard('admin')->user()->school_id]);
//                ->where('description', '!=', '');
        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $subject_name = $row->subject_name;
                return $subject_name ?? '...';
            })
            ->addColumn('subject_type', function ($row) {
                $subject_type = $row->description;
                return $subject_type ?? '...';
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
                $subject_id = $row->id;
                return '<div class="d-flex">
                            <a href="" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#edit_subject_modal" data-id="'.$subject_id.'">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="" class="btn btn-danger shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#delete_subject_modal" data-id="'.$subject_id.'">
                                <i class="fa fa-trash"></i>
                            </a>
                         </div>';
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }
}
