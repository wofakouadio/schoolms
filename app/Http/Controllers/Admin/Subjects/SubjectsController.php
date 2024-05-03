<?php

namespace App\Http\Controllers\Admin\Subjects;

use App\Http\Controllers\Controller;
use App\Models\AssignSubjectToLevel;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\TermAndAcademicYear;

class SubjectsController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.subjects.index', compact('schoolTerm'));
    }

    public function store(Request $request){
        $request->validate([
            'subject_name' => 'required',
            'subject_type' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Subject::create([
                'subject_name' => strtoupper($request->subject_name),
                'description' => $request->subject_type,
                'school_id' => Auth::guard('admin')->user()->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Subject created successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    public function edit(Request $request){
        $data = Subject::where('id', $request->subject_id)->first();
        return response()->json($data);
    }

    public function update(Request $request){
        $request->validate([
            'subject_name' => 'required',
            'subject_type' => 'required',
            'subject_status' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Subject::where('id', $request->subject_id)->update([
                'subject_name' => strtoupper($request->subject_name),
                'description' => $request->subject_type,
                'is_active' => $request->subject_status
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Subject updated successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    public function delete(Request $request){
        DB::beginTransaction();
        try {
            Subject::where('id', $request->subject_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Subject deleted successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    public function get_subjects_in_checkboxes(Request $request){
        $school_id = Auth::guard('admin')->user()->school_id;
        $level_id = $request->level_id;
        $output = [];
        $stepOne = Subject::select('id', 'subject_name', 'description')
            ->where('school_id', $school_id)
            ->get();

        foreach($stepOne as $value){
            $stepTwo = AssignSubjectToLevel::with('subject')
                ->where('level_id', $level_id)
                ->where('subject_id', $value->id)
                ->where('school_id', $school_id)
                ->get();

            if($value->description == null){
                $value->description = '';
            }

            if($stepTwo->isEmpty()){
                $output[] .= '<div class="col-xl-4 col-xxl-6 col-6">
                                <div class="form-check custom-checkbox mb-3">
                                    <input type="checkbox" class="form-check-input" name="subject[]" value="'.$value->id
                    .'">
                                <label class="form-check-label">'.$value->subject_name.' '
                    .$value->description.'</label>
                            </div>
                        </div>';
            }else{
                foreach($stepTwo as $valueTwo){
                    $output[] .= '<div class="col-xl-4 col-xxl-6 col-6">
                                <div class="form-check custom-checkbox mb-3">
                                    <input type="checkbox" class="form-check-input" name="subject[]" value="'.$value->id
                        .'" checked>
                                <label class="form-check-label">'.$valueTwo->subject->subject_name.' '
                        .$value->description.'</label>
                            </div>
                        </div>';
                }
            }


        }
        return $output;
    }
}
