<?php

namespace App\Http\Controllers\Admin\House;

use App\Http\Controllers\Controller;
use App\Models\House;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HousesDatatable extends Controller
{
    public function __invoke()
    {

        $data = House::with('school', 'branch')->where('houses.school_id', [Auth::guard('admin')->user()->school_id]);
        // $data = DB::select('select h.id, h.house_name, h.house_type, b.branch_name, h.is_active FROM houses h JOIN branches b ON b.school_id = h.school_id AND b.id = h.branch_id WHERE h.school_id = ?', [Auth::guard('admin')->user()->school_id]);
        // dd($data->get());
        return DataTables::of($data)

            ->addColumn('name', function ($row) {
                $name = $row->house_name;
                return $name ?? '...';
            })
            ->addColumn('type', function ($row) {
                if ($row->house_type === 'Boys') {
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-primary">
                                    Boys <i class="mdi mdi-gender-male"></i>
                                </span>
                           </div>';
                } else {
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-primary">
                                    Girls <i class="mdi mdi-gender-female"></i>
                                </span>
                           </div>';
                }
            })
            ->addColumn('branch', function ($row) {
                $branch = $row->branch->branch_name;
                return $branch ?? '...';
            })
            ->addColumn('is_active', function ($row) {
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
                $house_id = $row->id;
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
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-house-modal" data-id="' . $house_id . '">Edit House</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-house-modal" data-id="' . $house_id.'">Delete House</a>
                            </div>
                        </div>
                    ';
//                return '<div class="d-flex">
//                            <a data-bs-toggle="modal" data-bs-target="#edit-house-modal" data-id="' . $house_id . '"
//                            class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a data-bs-toggle="modal" data-bs-target="#delete-house-modal" data-id="' . $house_id
//                    . '" class="btn btn-danger shadow btn-xs sharp">
//                                <i class="fa fa-trash"></i>
//                            </a>
//                         </div>
//                ';
            })
            ->rawColumns(['type', 'is_active', 'action'])
            ->make(true);
    }
}
