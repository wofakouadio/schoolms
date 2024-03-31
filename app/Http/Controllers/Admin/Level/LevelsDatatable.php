<?php

namespace App\Http\Controllers\Admin\Level;

use App\Models\Level;
use App\Models\Department;
use Illuminate\Http\Request;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LevelsDatatable extends Controller
{
    public function __invoke()
    {
        $data = Level::with('branch')->where('school_id', [Auth::guard('admin')->user()->school_id]);
        // $data = DB::select('select l.id, l.level_name, b.branch_name, l.is_active FROM levels l JOIN branches b ON b.school_id = l.school_id AND b.id = l.branch_id WHERE l.school_id = ?', [Auth::guard('admin')->user()->school_id]);

        return DataTables::of($data)

            ->addColumn('name', function ($row) {
                $name = $row->level_name;
                return $name ?? '...';
            })
            ->addColumn('branch', function ($row) {
                $branch = $row->branch->branch_name;
                return $branch ?? '...';
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
                $level_id = $row->id;
                return '<div class="d-flex">
                            <a data-bs-toggle="modal" data-bs-target="#edit-level-modal" data-id="' . $level_id . '"
                            class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#delete-level-modal" data-id="' . $level_id
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
