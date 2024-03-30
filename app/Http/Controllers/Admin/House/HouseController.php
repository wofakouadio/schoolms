<?php

namespace App\Http\Controllers\Admin\House;

use App\Http\Controllers\Controller;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HouseController extends Controller
{
    //index
    public function index(){
        return view('admin.dashboard.house.index');
    }

    //store
    public function store(Request $request){
        $request->validate([
            'house_name' => 'required',
            'house_type' => 'required',
            'branch' => 'required'
        ]);

        DB::beginTransaction();
        try {
            House::create([
                'house_name' => $request->house_name,
                'house_description' => $request->house_description,
                'house_type' => $request->house_type,
                'branch_id' => $request->branch,
                'school_id' => $request->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'House created successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //edit
    public function edit(Request $request){
        $data = House::where('id', $request->house_id)->first();
        return response()->json($data);
    }

    //update
    public function update(Request $request){
        $request->validate([
            'house_name' => 'required',
            'house_type' => 'required',
            'branch' => 'required'
        ]);

        DB::beginTransaction();
        try {
            House::where('id', $request->house_id)->update([
                'house_name' => $request->house_name,
                'house_description' => $request->house_description,
                'house_type' => $request->house_type,
                'branch_id' => $request->branch
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'House updated successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //delete
    public function delete(Request $request){
        DB::beginTransaction();
        try {
            House::where('id', $request->house_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'House deleted successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //houses based on branch id
    public function getHousesByBranchId(Request $request){
        $branch_id = $request->branch_id;
        $output = [];
        $houses = House::select('id', 'house_name')->where('branch_id', $branch_id)->where('is_active', 0)->get();
        $output[] .= "<option value=''>Choose</option>";
        foreach ($houses as $house){
            $output[] .= "<option value='".$house->id."'>".$house->house_name."</option>";
        }
        return $output;
    }
}
