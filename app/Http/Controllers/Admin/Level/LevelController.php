<?php

namespace App\Http\Controllers\Admin\Level;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    //index
    public function index(){
        return view('admin.dashboard.level.index');
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
                'branch_id' => $request->branch,
                'school_id' => $request->school_id,
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
                'branch_id' => $request->branch,
                'is_active' => $request->level_is_active
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
}
