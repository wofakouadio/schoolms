<?php

namespace App\Http\Controllers\Admin\Subjects;

use App\Http\Controllers\Controller;
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
}
