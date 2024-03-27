<?php

namespace App\Http\Controllers\Admin\House;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HousesDatatable extends Controller
{
    public function __invoke(){
        $data = DB::select('select h.id, h.house_name, h.house_type, b.branch_name, h.is_active FROM houses h JOIN branches b ON b.school_id = h.school_id AND b.id = h.branch_id WHERE h.school_id = ?', [Auth::guard('admin')->user()->school_id]);

        return DataTables::of($data)

            ->addColumn('name', function ($row){
                $name = $row->house_name ;
                return $name ?? '...';
            })
            ->addColumn('type', function ($row){
                if($row->house_type === 'Boys'){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-primary">
                                    <i class="mdi mdi-gender-male"></i>
                                </span>
                           </div>';
                }else{
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-primary">
                                    <i class="mdi mdi-gender-female"></i>
                                </span>
                           </div>';
                }
            })
            ->addColumn('branch', function($row){
                $branch = $row->branch_name;
                return $branch ?? '...';
            })
            ->addColumn('is_active', function($row){
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
                $house_id = $row->id;
                return '<div class="d-flex">
                            <a data-bs-toggle="modal" data-bs-target="#edit-house-modal" data-id="'.$house_id.'"
                            class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#delete-house-modal" data-id="'.$house_id
                    .'" class="btn btn-danger shadow btn-xs sharp">
                                <i class="fa fa-trash"></i>
                            </a>
                         </div>
                ';
            })
            ->rawColumns(['type','is_active','action'])
            ->make(true);
    }
}
