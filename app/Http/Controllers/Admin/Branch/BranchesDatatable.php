<?php

namespace App\Http\Controllers\Admin\Branch;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BranchesDatatable extends Controller
{
    public function __invoke(){
        $data = DB::select('select * FROM branches WHERE school_id = ?', [Auth::guard('admin')
            ->user()->school_id]);

        return DataTables::of($data)

            ->addColumn('name', function ($row){
                $name = $row->branch_name ;
                return $name ?? '...';
            })
            ->addColumn('contact', function($row){
                $contact = $row->branch_contact;
                return $contact ?? '...';
            })
            ->addColumn('email', function($row){
                $email = $row->branch_email;
                return $email ?? '...';
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
                $branch_id = $row->id;
                return '<div class="d-flex">
                            <a data-bs-toggle="modal" data-bs-target="#edit-branch-modal" data-id="'.$branch_id.'"
                            class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#delete-branch-modal" data-id="'.$branch_id
                    .'" class="btn btn-danger shadow btn-xs sharp">
                                <i class="fa fa-trash"></i>
                            </a>
                         </div>
                ';
            })
            ->rawColumns(['is_active','action'])
            ->make(true);
    }
}
