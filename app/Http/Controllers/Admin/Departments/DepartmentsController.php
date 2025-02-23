<?php

namespace App\Http\Controllers\Admin\Departments;

use App\Http\Controllers\Controller;
use App\Models\AssignLevelToDepartment;
use App\Models\Department;
use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function App\Helpers\TermAndAcademicYear;

class DepartmentsController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view("admin.dashboard.department.main.index", compact('schoolTerm'));
    }


    // store new department
    public function store(Request $request){
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
        $departments = Department::with('branch')->where('school_id', Auth::guard('admin')->user()->school_id)->where('is_active', 1)->get();
        $output[] = "<option value=''>Choose</option>";
        foreach ($departments as $department) {
            $output[] = "<option value='".$department->id."'>".$department->name . ' - ' .
                $department->branch->branch_name . ' Branch'
                ."</option>";
        }
        return $output;
    }

    //get levels based on department and branch
    public function getLevelsBasedOnDepartmentAndBranch(Request $request)
    {
        $branch_id = $request->branch_id;
        $department_id = $request->department_id;
        $output = [];

        // Get all levels for this branch and school
        $levels = Level::select('id', 'level_name')
            ->where([
                'branch_id' => $branch_id,
                'school_id' => Auth::guard('admin')->user()->school_id
            ])
            ->get();

        // Get assigned levels for this department
        $assignedLevels = AssignLevelToDepartment::where([
            'branch_id' => $branch_id,
            'school_id' => Auth::guard('admin')->user()->school_id,
            'department_id' => $department_id
        ])
        ->pluck('level_id')
        ->toArray();

        // Generate checkbox for each level
        foreach ($levels as $level) {
            $isChecked = in_array($level->id, $assignedLevels) ? 'checked' : '';

            $output[] = '<div class="col-xl-3 col-xxl-6 col-6">
                            <div class="form-check custom-checkbox mb-3">
                                <input type="checkbox"
                                       class="form-check-input"
                                       name="level[]"
                                       value="'.$level->id.'"
                                       '.$isChecked.'>
                                <label class="form-check-label">'.$level->level_name.'</label>
                            </div>
                        </div>';
        }

        return $output;
    }

    public function newassignleveltodepartment(Request $request){
        $request->validate([
            'department_id' => 'required',
            'branch_id' => 'required',
            'level' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            $data = [];
            $existingAssignments = AssignLevelToDepartment::where('department_id', $request->department_id)
                ->pluck('level_id')
                ->toArray();

            foreach ($request->level as $level_id) {
                // Skip if this level is already assigned to this department
                if (in_array($level_id, $existingAssignments)) {
                    continue;
                }

                $data[] = [
                    'id' => Str::uuid(),
                    'department_id' => $request->department_id,
                    'branch_id' => $request->branch_id,
                    'level_id' => $level_id,
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }

            if (!empty($data)) {
                AssignLevelToDepartment::insert($data);
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Levels assigned to Department successfully'
            ]);

        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

}
