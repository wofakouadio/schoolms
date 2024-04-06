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
        $data = Bill::with('level')->with('term')->where('school_id', Auth::guard('admin')->user()->school_id);

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
                $bill_id = $row->id;
                return '<div class="d-flex">
                            <a data-bs-toggle="modal" data-bs-target="#edit-bill-modal" data-id="' . $bill_id . '"
                            class="btn btn-primary shadow btn-xs sharp me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#delete-bill-modal" data-id="' . $bill_id
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
