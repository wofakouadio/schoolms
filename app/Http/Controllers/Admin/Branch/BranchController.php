<?php

namespace App\Http\Controllers\Admin\Branch;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    //index
    public function index(){
        return view('admin.dashboard.branch.index');
    }

    //store
    public function store(Request $request){
        $request->validate([
            'branch_name' => 'required',
            'branch_address' => 'required',
            'branch_email' => 'required|lowercase|email',
            'branch_contact' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Branch::create([
                'branch_name' => strtoupper($request->branch_name),
                'branch_description' => $request->branch_description,
                'branch_location' => $request->branch_address,
                'branch_email' => $request->branch_email,
                'branch_contact' => $request->branch_contact,
                'school_id' => $request->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Branch created successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //fetch branch data
    public function edit(Request $request){
        $data = Branch::where('id', $request->branch_id)->first();
        return response()->json($data);
    }

    //update branch data
    public function update(Request $request){
        $request->validate([
            'branch_name' => 'required',
            'branch_address' => 'required',
            'branch_email' => 'required|lowercase|email',
            'branch_contact' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Branch::where('id', $request->branch_id)->update([
                'branch_name' => strtoupper($request->branch_name),
                'branch_description' => $request->branch_description,
                'branch_location' => $request->branch_address,
                'branch_email' => $request->branch_email,
                'branch_contact' => $request->branch_contact,
                'is_active' => $request->branch_is_active
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Branch updated successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //delete branch data
    public function delete (Request $request){
        DB::beginTransaction();

        try {
            Branch::where('id', $request->branch_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Branch deleted successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //get branches based on school id
    public function getBranchesBySchoolId(Request $request){
        $school_id = $request->school_id;
        $output = [];
        $branches = Branch::select('id', 'branch_name')->where('school_id', $school_id)->where('is_active', 0)->get();
        $output[] .= "<option value=''>Choose</option>";
        foreach ($branches as $branch){
            $output[] .= "<option value='".$branch->id."'>".$branch->branch_name."</option>";
        }
        return $output;
    }
}
