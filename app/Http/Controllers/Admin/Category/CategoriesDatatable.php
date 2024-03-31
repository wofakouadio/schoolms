<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CategoriesDatatable extends Controller
{
    public function __invoke()
    {
        $data = Category::where('school_id', [Auth::guard('admin')->user()->school_id]);

        return DataTables::of($data)

            ->addColumn('name', function ($row) {
                $name = $row->category_name;
                return $name ?? '...';
            })
            ->addColumn('is_active', function ($row) {
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
                $category_id = $row->id;
                return '<div class="d-flex">
                            <a data-bs-toggle="modal" data-bs-target="#edit-category-modal" data-id="' . $category_id . '"
                            class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#delete-category-modal" data-id="' . $category_id
                    . '" class="btn btn-danger shadow btn-xs sharp">
                                <i class="fa fa-trash"></i>
                            </a>
                         </div>
                ';
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }
}
