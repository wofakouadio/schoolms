<?php

namespace App\Http\Controllers\Admin\Departments;

use App\Http\Controllers\Controller;
use App\Models\AssignLevelToDepartment;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\TermAndAcademicYear;

class AssignLevelToDepartmentController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.department.assign.index', compact('schoolTerm'));
    }

    public function store(Request $request){
        $request->validate([
            'department' => 'required',
            'level' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $getBranch = Department::select('branch_id')->where('id', $request->department)->first();
            AssignLevelToDepartment::create([
                'department_id' => $request->department,
                'level_id' => $request->level,
                'branch_id' => $getBranch->branch_id,
                'school_id' => Auth::guard('admin')->user()->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Department created successfully'
            ]);

        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);

        }
    }

    public function edit(Request $request){

    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }
}
