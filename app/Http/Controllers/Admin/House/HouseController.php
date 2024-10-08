<?php

namespace App\Http\Controllers\Admin\House;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;

class HouseController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.house.index', compact('schoolTerm'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'house_name' => 'required',
//            'house_type' => 'required',
            'branch' => 'required'
        ]);

        DB::beginTransaction();
        try {
            House::create([
                'house_name' => $request->house_name,
                'house_description' => $request->house_description ?? '',
                'house_type' => $request->house_type ?? '',
                'branch_id' => $request->branch,
                'school_id' => Auth::guard('admin')->user()->school_id //$request->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'House created successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //edit
    public function edit(Request $request)
    {
        $data = House::where('id', $request->house_id)->first();
        return response()->json($data);
    }

    //update
    public function update(Request $request)
    {
        $request->validate([
            'house_name' => 'required',
            'branch' => 'required'
        ]);

        DB::beginTransaction();
        try {
            House::where('id', $request->house_id)->update([
                'house_name' => $request->house_name,
                'house_description' => $request->house_description ?? 'null',
                'house_type' => $request->house_type ?? 'null',
                'is_active' => $request->house_is_active,
                'branch_id' => $request->branch
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'House updated successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //delete
    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            House::where('id', $request->house_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'House deleted successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //houses based on branch id
    public function getHousesByBranchId()
    {
        $output = [];
        $houses = House::with('branch')->where('school_id', Auth::guard('admin')->user()->school_id)->where
        ('is_active', 1)
                ->get();
        $output[] = "<option value=''>Choose</option>";
        foreach ($houses as $house){
            $output[] = "<option value='".$house->id."'>".$house->branch->branch_name . ' Branch -  '
                .$house->house_name."</option>";
        }
        return $output;
    }
}
