<?php

namespace App\Http\Controllers\Admin\Subjects;

use App\Models\Subject;
use Illuminate\Http\Request;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SubjectsDatatable extends Controller
{
    public function __invoke()
    {
        $data = Subject::with('department')->where('school_id',[Auth::guard('admin')->user()->school_id]);

        // $data = DB::select('select id, subject_name, department, is_active FROM subjects');

        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $subject_name = $row->name;
                return $subject_name ?? '...';
            })
            ->addColumn('department', function ($row) {
                $department = $row->department->department_name;
                return $department ?? '...';
            })
            ->addColumn('is_active', function ($row) {
                //                $subject_status =;
                if ($row->is_active === 0) {
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">active</span>
                           </div>';
                } else {
                    return '<span class="badge badge-xl light badge-danger text-uppercase">disabled</span>';
                }
                //                return $remodelledStatus ?? '...';
            })
            ->addColumn('action', function ($row) {
                $subject_id = $row->id;
                return '<div class="d-flex">
                            <a href="" class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="" class="btn btn-danger shadow btn-xs sharp">
                                <i class="fa fa-trash"></i>
                            </a>
                         </div>';
                //                <a href="/admin/subject/{{$subject->id}}/edit" class="btn btn-primary shadow btn-xs sharp me-1">
                //                                <i class="fas fa-pencil-alt"></i>
                //                            </a>
                //                            <a href="/admin/subject/{{$subject->id}}" class="btn btn-danger shadow btn-xs sharp">
                //                                <i class="fa fa-trash"></i>
                //                            </a>
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }
}
