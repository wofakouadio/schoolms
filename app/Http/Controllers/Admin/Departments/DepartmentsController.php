<?php

namespace App\Http\Controllers\Admin\Departments;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\TermAndAcademicYear;


class DepartmentsController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        return view("admin.dashboard.department.main.index", compact('schoolTerm'));
    }


    // store new department
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'branch' => 'required'
        ]);

        DB::beginTransaction();

        try {

            Department::create([
                'name' => strtoupper($request->name),
                'description' => $request->description,
                'school_id' => Auth::guard('admin')->user()->school_id,
                'branch_id' => $request->branch
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

    //edit department
    public function edit(Request $request)
    {
        $data = Department::where('id', $request->department_id)->first();
        return response()->json($data);
    }

    //update department
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'branch' => 'required',
            'department_status' => 'required'
        ]);

        DB::beginTransaction();

        try {

            Department::where('id', $request->department_id)->update([
                'name' => strtoupper($request->name),
                'description' => $request->description,
                'branch_id' => $request->branch,
                'is_active' => $request->department_status
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Department updated successfully'
            ]);

        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);

        }
    }

    //delete department
    public function delete(Request $request)
    {
        DB::beginTransaction();

        try {

            Department::where('id', $request->department_id)->delete();

            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Department deleted successfully'
            ]);

        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);

        }
    }

    //get departments by school id
    public function getDepartmentsBySchoolId()
    {
        $output = [];
        $departments = Department::with('branch')->where('school_id', Auth::guard('admin')->user()->school_id)->where
        ('is_active', 0)->get();
        $output[] .= "<option value=''>Choose</option>";
        foreach ($departments as $department){
            $output[] .= "<option value='".$department->id."'>".$department->name . ' - ' .
                $department->branch->branch_name . ' Branch'
                ."</option>";
        }
        return $output;
    }

}
