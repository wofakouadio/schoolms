<?php

namespace App\Http\Controllers\Admin\Branch;

use App\Models\Branch;
use App\Models\Department;
use Illuminate\Http\Request;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BranchesDatatable extends Controller
{
    public function __invoke()
    {
        $query = Branch::query();

        // dd($query);
        $data = Branch::where('school_id', Auth::guard('admin')->user()->school_id)->orderBy('created_at', 'DESC');
        // $data = DB::select('select * FROM branches WHERE school_id = ?', [Auth::guard('admin')
        //     ->user()->school_id]);

        return DataTables::of($data)

            ->addColumn('name', function ($row) {
                $name = $row->branch_name;
                return $name ?? '...';
            })
            ->addColumn('contact', function ($row) {
                $contact = $row->branch_contact;
                return $contact ?? '...';
            })
            ->addColumn('email', function ($row) {
                $email = $row->branch_email;
                return $email ?? '...';
            })
            ->addColumn('is_active', function ($row) {
                //                $department_status =;
                if ($row->is_active === 1) {
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">active</span>
                           </div>';
                } else {
                    return '<span class="badge badge-xl light badge-danger text-uppercase">disabled</span>';
                }
                //                return $remodelledStatus ?? '...';
            })
            ->addColumn('action', function ($row) {
                $branch_id = $row->id;
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
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-branch-modal" data-id="' . $branch_id . '">Edit Branch</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-branch-modal" data-id="' . $branch_id. '">Delete Branch</a>
                            </div>
                        </div>
                    ';
//                return '<div class="d-flex">
//                            <a data-bs-toggle="modal" data-bs-target="#edit-branch-modal" data-id="' . $branch_id . '"
//                            class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a data-bs-toggle="modal" data-bs-target="#delete-branch-modal" data-id="' . $branch_id
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
