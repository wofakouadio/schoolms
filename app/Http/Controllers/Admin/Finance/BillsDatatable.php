<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Models\Bill;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BillsDatatable extends Controller
{
    public function __invoke()
    {
        // dd();
        $data = Bill::with(['level','term'])->where('school_id', Auth::guard('admin')->user()->school_id)->orderBy('created_at', 'DESC');

        return DataTables::of($data)

            ->addColumn('academic_year', function ($row) {
                $academic_year = $row->academic_year;
                return $academic_year ?? '...';
            })
            ->addColumn('term', function ($row) {
                $term = $row->term->term_name;
                return $term ?? '...';
            })
            ->addColumn('level', function ($row) {
                $level = $row->level->level_name;
                return $level ?? '...';
            })
            ->addColumn('amount', function ($row) {
                $amount = $row->bill_amount;
                return $amount ?? '...';
            })
            ->addColumn('last_updated', function ($row) {
                $last_updated = date('F j, Y H:i:s', strtotime($row->updated_at));
                return $last_updated ?? '...';
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
                $bill_id = $row->id;
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
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-bill-modal" data-id="' . $bill_id . '">Edit Bill</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-bill-modal" data-id="' . $bill_id.'">Delete Bill</a>
                            </div>
                        </div>
                    ';
//                return '<div class="d-flex">
//                            <a data-bs-toggle="modal" data-bs-target="#edit-bill-modal" data-id="' . $bill_id . '"
//                            class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a data-bs-toggle="modal" data-bs-target="#delete-bill-modal" data-id="' . $bill_id
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
