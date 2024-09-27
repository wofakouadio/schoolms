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
        ('is_active', 1)->get();
        $output[] = "<option value=''>Choose</option>";
        foreach ($departments as $department){
            $output[] = "<option value='".$department->id."'>".$department->name . ' - ' .
                $department->branch->branch_name . ' Branch'
                ."</option>";
        }
        return $output;
    }

    //get levels based on department and branch
    public function getLevelsBasedOnDepartmentAndBranch(Request $request){
        $branch_id = $request->branch_id;
        $department_id = $request->department_id;
        $output = [];
        //select all levels from table based on branch and school
        $s1 = Level::select('id', 'level_name')->where('branch_id', $branch_id)->where('school_id', Auth::guard
        ('admin')->user()->school_id)->get();
        foreach($s1 as $value){
            $s2 = AssignLevelToDepartment::with('AssignLevel')
                ->where
                ('level_id',
                    $value->id)->where('branch_id',
                    $branch_id)
                ->where
                ('school_id', Auth::guard('admin')->user()->school_id)->where('department_id', $department_id)->get();

            if($s2->isEmpty()){
                $output[] = '<div class="col-xl-4 col-xxl-6 col-6">
                                <div class="form-check custom-checkbox mb-3">
                                    <input type="checkbox" class="form-check-input" name="level[]" value="'.$value->id.'">
                                <label class="form-check-label">'.$value->level_name.'</label>
                            </div>
                        </div>';
            }else{
                foreach ($s2 as $value){

                }
                $output[] = '<div class="col-xl-4 col-xxl-6 col-6">
                                <div class="form-check custom-checkbox mb-3">
                                    <input type="checkbox" class="form-check-input" name="level[]" value="'.$value->id.'" checked>
                                <label class="form-check-label">'.$value->AssignLevel->level_name.'</label>
                            </div>
                        </div>';
            }

        }
        return $output;

    }

    public function newassignleveltodepartment(Request $request){

//        dd($request->all());
        DB::beginTransaction();
        try {
            $data = [];

            foreach($request->level as $key => $value){
                $data[] = [
                    'id' => Str::uuid(),
                    'department_id' => $request->department_id,
                    'branch_id' => $request->branch_id,
                    'level_id' => $value,
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
//        AssignLevelToDepartment::upsert($data);
            DB::table('assign_level_to_departments')->insert($data);
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


//        dd($data);
    }

}
