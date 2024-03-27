<?php

namespace App\Http\Controllers\Admin\Departments;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DepartmentsDatatable extends Controller
{
    public function __invoke(){
        $data = DB::select('select id, name, is_active FROM departments WHERE school_id = ?', [Auth::guard('admin')
            ->user()->school_id]);

        return DataTables::of($data[])
            ->addColumn('name', function($row){
                $department_name = $row->name;
                return $department_name ?? '...';
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
                $department_id = $row->id;
                return '<div class="d-flex">
                            <a href="" class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="" class="btn btn-danger shadow btn-xs sharp">
                                <i class="fa fa-trash"></i>
                            </a>
                         </div>';
//                <a href="/admin/department/{{$department->id}}/edit" class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a href="/admin/department/{{$department->id}}" class="btn btn-danger shadow btn-xs sharp">
//                                <i class="fa fa-trash"></i>
//                            </a>
            })
            ->rawColumns(['is_active','action'])
            ->make(true);
    }
}
