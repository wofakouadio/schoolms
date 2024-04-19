<?php

namespace App\Http\Controllers\Admin\Assessment;

use App\Http\Controllers\Controller;
use App\Models\AssignSubjectsToMock;
use App\Models\AssignSubjectToLevel;
use App\Models\Mock;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function App\Helpers\TermAndAcademicYear;

class StudentMockController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.assessment.mock.index', compact('schoolTerm'));
    }

    //setup new mock
    public function new_mock_setup(Request $request){
        $request->validate([
            'mock_type' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Mock::create([
                'mock_type' => strtoupper($request->mock_type),
                'school_id' => Auth::guard('admin')->user()->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Mock created successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //edit mock setup
    public function edit(Request $request){
        $data = Mock::where('id', $request->mock_id)->first();
        return response()->json($data);
    }

    //update mock setup
    public function update_mock_setup(Request $request){
        $request->validate([
            'mock_type' => 'required',
            'mock_is_active' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Mock::where('id', $request->mock_id)->update([
                'mock_type' => strtoupper($request->mock_type),
                'is_active' => $request->mock_is_active
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Mock updated successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //delete mock setup
    public function delete_mock_setup(Request $request){
        DB::beginTransaction();

        try {
            Mock::where('id', $request->mock_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Mock delete successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //get mock in select
    public function getMocksInSelectBasedOnSchool(){
        $output = [];
        $mocks = Mock::where('school_id', Auth::guard('admin')->user()->school_id)->get();
        $output[] .= '<option value="">Choose</option>';
        foreach ($mocks as $mock){
            $output[] .= '<option value="' . $mock->id . '">' . $mock->mock_type . '</option>';
        }
        return $output;
    }

//    public function getSubjectsBasedOnMock(Request $request){
//        $mock_id = $request->mock_id;
//        $output = [];
//        $firstChk = Subject::select('id', 'subject_name')->where('school_id', Auth::guard('admin')->user()->school_id)
//            ->get();
//        foreach($firstChk as $value){
//            $secondChk = AssignSubjectsToMock::with('AssignSubject')->where('subject_id', '=', $value->id)
//                ->where('school_id', '=', Auth::guard('admin')->user()->school_id)
//                ->where('mock_id', '=', $mock_id)
//                ->get();
//
//            if($secondChk->isEmpty()){
//                $output[] .= '<div class="col-xl-4 col-xxl-4 col-4">
//                            <div class="form-check custom-checkbox mb-3">
//                                <input type="checkbox" class="form-check-input" name="subject[]" value="'.$value->id.'">
//                                <label class="form-check-label">'.$value->subject_name.'</label>
//                            </div>
//                        </div>';
//            }else{
//                $output[] .= '<div class="col-xl-4 col-xxl-4 col-4">
//                            <div class="form-check custom-checkbox mb-3">
//                                <input type="checkbox" class="form-check-input" name="subject[]" value="'.$value->id.'" checked>
//                                <label class="form-check-label">'.$value->subject_name.'</label>
//                            </div>
//                        </div>';
//            }
//        }
//        return $output;
//    }

    public function getSubjectsBasedOnMock(Request $request){
        $mock_id = $request->mock_id;
        $level_id = $request->level_id;
        $output = [];
        $firstChk = AssignSubjectToLevel::with('subject')
            ->where('level_id', $level_id)
            ->where('school_id', Auth::guard
        ('admin')->user()->school_id)
            ->get();
//        dd($firstChk);
        foreach($firstChk as $value){
            $secondChk = AssignSubjectsToMock::with('AssignSubject')
                ->where('level_id', $level_id)
                ->where('subject_id', '=', $value->id)
                ->where('school_id', '=', Auth::guard('admin')->user()->school_id)
                ->where('mock_id', '=', $mock_id)
                ->get();
//dd($secondChk);
            if($secondChk->isEmpty()){
                $output[] .= '<div class="col-xl-4 col-xxl-4 col-4">
                            <div class="form-check custom-checkbox mb-3">
                                <input type="checkbox" class="form-check-input" name="subject[]" value="'.$value->id.'">
                                <label class="form-check-label">'.$value->subject->subject_name.'</label>
                            </div>
                        </div>';
            }else{
                $output[] .= '<div class="col-xl-4 col-xxl-4 col-4">
                            <div class="form-check custom-checkbox mb-3">
                                <input type="checkbox" class="form-check-input" name="subject[]" value="'.$value->id.'" checked>
                                <label class="form-check-label">'.$value->subject->subject_name.'</label>
                            </div>
                        </div>';
            }
        }
        return $output;
    }

    public function assignSubjectToMock(Request $request){

        DB::beginTransaction();
        try {
            $data = [];

            foreach($request->subject as $key => $value){
                $data[] = [
                    'id' => Str::uuid(),
                    'mock_id' => $request->mock_id,
                    'level_id' => $request->level,
                    'subject_id' => $value,
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
//        AssignLevelToDepartment::upsert($data);
            DB::table('assign_subjects_to_mocks')->insert($data);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Subjects assigned to Mock successfully'
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
