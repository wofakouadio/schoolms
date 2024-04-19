<?php

namespace App\Http\Controllers\Admin\Assessment;

use App\Models\Branch;
use App\Models\Department;
use Illuminate\Http\Request;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StudentAttendanceDatatable extends Controller
{
    public function __invoke(Request $request)
    {
//        dd($request->all());
//        $data = Auth::guard('admin')->user()->attendances ;//->where('admission_status', 1);
        $data = Auth::guard('admin')->user()->student ;//->where('admission_status', 1);
            //->leftJoin('student_attendances','student_attendances.student_id','=','student_id');
//dd($data);
        $branch = Department::select('branch_id')->where('id', $request->department_id)->first();

        if ($request->filled('department_id')) {
            $data = $data->where('student_branch', $branch->branch_id);
        }else{
            $data = $data->where('student_branch', '-1');
        }
//        dd($data);
        if ($request->filled('level_id')) {
            $data = $data->where('student_level', $request->level_id);
        }
//        dd($data);
        return DataTables::of($data)

            ->addColumn('name', function ($row) {
                $name = $row->student_firstname . ' ' . $row->student_lastname;
                return $name ?? '...';
            })
            ->addColumn('gender', function ($row) {
                $gender = $row->student_gender;
                return $gender ?? '...';
            })
            ->addColumn('residency', function ($row) {
                $residency = $row->student_residency_type;
                return $residency ?? '...';
            })
            ->addColumn('level', function ($row) {
                $level = $row->level->level_name;
                return $level ?? '...';
            })
            ->addColumn('check', function ($row) {
                if($row->attendance){
                    if($row->attendance->status == 1){
//                    $status = 'checked';
                    return '
                        <div class="form-check custom-checkbox mb-3 checkbox-primary check-xl checkStudent">
                            <input type="checkbox" class="form-check-input" id="checkStudent"
                                   name="checkStudent[]" value="'.$row->id.'" checked>
                            <label class="form-check-label" for="checkStudent"></label>
                        </div>
                        ';
                }
                }else{
                    return '
                        <div class="form-check custom-checkbox mb-3 checkbox-primary check-xl checkStudent">
                            <input type="checkbox" class="form-check-input" id="checkStudent"
                                   name="checkStudent[]" value="'.$row->id.'">
                            <label class="form-check-label" for="checkStudent"></label>
                        </div>
                        ';
                }

//                dd($status);

            })
            ->rawColumns(['check'])
            ->make(true);

    }
}
