<?php

namespace App\Http\Controllers\Admin\School;

use App\Models\Term;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TermsDatatable extends Controller
{
    public function __invoke(){
        $data = Term::where('school_id',[Auth::guard('admin')->user()->school_id]);

        return DataTables::of($data)
            ->addColumn('name', function ($row){
                $name = $row->term_name;
                return $name ?? '...';
            })
            ->addColumn('opening_date', function($row){
                $opening_date = date('F j, Y', strtotime($row->term_opening_date));
                return $opening_date ?? '...';
            })
            ->addColumn('closing_date', function($row){
                $closing_date = date('F j, Y', strtotime($row->term_closing_date));
                return $closing_date ?? '...';
            })
            ->addColumn('academic_year', function($row){
                $academic_year = $row->term_academic_year;
                return $academic_year ?? '...';
            })
            ->addColumn('is_active', function($row){
                if( $row->is_active === 0 ){
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-danger text-uppercase">disabled</span>
                           </div>';
                }else{
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">active</span>
                            </div>';
                }
            })
            ->addColumn('action', function($row){
                $term_id = $row->id;
                return '<div class="d-flex">
                            <a data-bs-toggle="modal" data-bs-target="#edit-term-modal" data-id="'.$term_id.'"
                            class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#delete-term-modal" data-id="'.$term_id
                    .'" class="btn btn-danger shadow btn-xs sharp">
                                <i class="fa fa-trash"></i>
                            </a>
                         </div>';
            })
            ->rawColumns(['is_active','action'])
            ->make(true);
    }
}
