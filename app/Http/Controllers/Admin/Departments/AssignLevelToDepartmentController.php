<?php

namespace App\Http\Controllers\Admin\Departments;

use App\Http\Controllers\Controller;
use App\Models\AssignLevelToDepartment;
use App\Models\Department;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function App\Helpers\TermAndAcademicYear;

class AssignLevelToDepartmentController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.department.assign.index', compact('schoolTerm'));
    }

    public function store(Request $request)
    {
        //        dd($request->all());
        $request->validate([
            'department' => 'required',
            'level.*' => 'required'
        ]);
        $data = [];
        $getBranch = Department::select('branch_id')->where('id', $request->department)->first();
        foreach ($request->level as $key => $value) {
            $data[] = [
                'department_id' => $request->department,
                'branch_id' => $getBranch->branch_id,
                'level_id' => $value,
                'admin_id' => Auth::guard('admin')->user()->school_id,
            ];
        }
        AssignLevelToDepartment::upsert($data);
        // dd($data);
    }

    // get levels based on selected department
    public function get_department_levels(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id'
        ]);
        $levels = Level::where([
            'school_id' => Auth::guard('admin')->user()->school_id,
        ])->get();

        // Fetch levels already assigned to the department (if any)
        $assignedLevels = AssignLevelToDepartment::where('department_id', $request->department_id)->pluck('level_id');

        // Filter out levels that are already assigned
        $availableLevels = $levels->whereIn('id', $assignedLevels);

        return response()->json($availableLevels);
    }

    //    public function store(Request $request){
    //        $request->validate([
    //            'department' => 'required',
    //            'level' => 'required'
    //        ]);
    //        DB::beginTransaction();
    //        try {
    //            $getBranch = Department::select('branch_id')->where('id', $request->department)->first();
    //            AssignLevelToDepartment::create([
    //                'department_id' => $request->department,
    //                'level_id' => $request->level,
    //                'branch_id' => $getBranch->branch_id,
    //                'school_id' => Auth::guard('admin')->user()->school_id
    //            ]);
    //            DB::commit();
    //            return response()->json([
    //                'status' => 200,
    //                'msg' => 'Department created successfully'
    //            ]);
    //
    //        } catch (\Exception $th) {
    //            DB::rollBack();
    //            return response()->json([
    //                'status' => 201,
    //                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
    //            ]);
    //
    //        }
    //    }

    public function edit(Request $request)
    {

    }

    public function update(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }
}
