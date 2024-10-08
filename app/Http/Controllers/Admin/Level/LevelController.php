<?php

namespace App\Http\Controllers\Admin\Level;

use App\Models\AssignSubjectToLevel;
use App\Models\Department;
use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use function App\Helpers\TermAndAcademicYear;

class LevelController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.level.index', compact('schoolTerm'));
    }

    //store
    public function store(Request $request){
        $request->validate([
            'level_name' => 'required',
            'branch' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Level::create([
                'level_name'=> strtoupper($request->level_name),
                'level_description'=> $request->level_description,
                'school_id' => Auth::guard('admin')->user()->school_id,
                'branch_id' => $request->branch
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Level created successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //edit level
    public function edit(Request $request){
        $data = Level::where('id', $request->level_id)->first();
        return response()->json($data);
    }

    //update level
    public function update(Request $request){
        $request->validate([
            'level_name' => 'required',
            'branch' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Level::where('id', $request->level_id)->update([
                'level_name'=> strtoupper($request->level_name),
                'level_description'=> $request->level_description,
                'is_active' => $request->level_is_active ? 1 : 0
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Level updated successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //delete level
    public function delete(Request $request){
        DB::beginTransaction();

        try {
            Level::where('id', $request->level_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Level deleted successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //get levels based on branch id
    public function getLevelsByBranchId(){
        $output = [];
        $levels = Level::with('branch')->where('school_id', Auth::guard('admin')->user()->school_id)->where
        ('is_active', 1)->get();
        $output[] = "<option value=''>Choose</option>";
        foreach ($levels as $level){
            $output[] = "<option value='".$level->id."'>".$level->branch->branch_name . ' Branch - ' .
                $level->level_name
            ."</option>";
        }
        return $output;
    }

    //get levels based on school id
    public function getLevelsBySchoolId(){
        $output = [];
        if(Auth::guard("admin")->check()){
            $levels = Level::with('branch')
                    ->where(['school_id' => Auth::guard('admin')->user()->school_id, 'is_active' => 1])
                    ->get();
            $output[] = "<option value=''>Choose</option>";
            foreach ($levels as $level){
                $output[] = "<option value='".$level->id."'>".$level->level_name. " / " .$level->branch->branch_name." Branch</option>";
            }
        }else{
            // $levels = Level::with('branch')
            // ->where(['school_id' => Auth::guard('teacher')->user()->school_id, 'is_active' => 1])
            // ->get();
            // $output[] .= "<option value=''>Choose</option>";
            // foreach ($levels as $level){
            //     $output[] .= "<option value='".$level->id."'>".$level->level_name. " / " .$level->branch->branch_name." Branch</option>";
            // }
        }

        return $output;
    }

    public function getLevelsInCheckboxBySchoolId(){
        $output = [];
        $levels = Level::with('branch')->where('school_id', Auth::guard('admin')
            ->user()
            ->school_id)
            ->where
            ('is_active', 1)
            ->get();
        foreach ($levels as $level){
            $output[] = '<div class="col-xl-4 col-xxl-4 col-4">
                            <div class="form-check custom-checkbox mb-3">
                                <input type="checkbox" class="form-check-input" name="level[]" value="'
                        .$level->id.'">
                                <label class="form-check-label">'.$level->level_name.' / '
                        .$level->branch->branch_name.' Branch</label>
                            </div>
                        </div>';
        }
        return $output;
    }

    public function assign_subjects_to_level(Request $request){
        DB::beginTransaction();
        try {
            $data = [];
            foreach($request->subject as $key => $value){
                $data[] = [
                    'id' => Str::uuid(),
                    'subject_id' => $value,
                    'level_id' => $request->level_id,
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
//            AssignSubjectToLevel::upsert($data,
//                ['subject_id', 'level_id'],
//            ['subject_id', 'level_id']);
            DB::table('assign_subject_to_levels')->insert($data);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Subjects assigned to Level successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }
}
