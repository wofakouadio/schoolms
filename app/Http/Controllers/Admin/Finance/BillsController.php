<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillsController extends Controller
{
    //store bill
    public function store(Request $request)
    {
        $request->validate([
            'term' => 'required',
            'academic_year' => 'required',
            'level' => 'required',
            'addMore.*.bill_amount' => 'required',
            'addMore.*.bill_description' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $bill_amount = 0;
            $bill_description = [];
            foreach ($request->addMore as $key => $value){

                $bill_amount += $value['bill_amount'];
                $bill_description[] = [
                    'description' => $value['bill_description'],
                    'amount' => $value['bill_amount']
                ];
            }
            Bill::create([
                'bill_amount' => $bill_amount,
                'bill_description' => $bill_description,
                'term_id' => $request->term,
                'academic_year' => $request->academic_year,
                'level_id' => $request->level,
                'school_id' => Auth::guard('admin')->user()->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Bill created successfully'
            ]);
        }catch(\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //edit
    public function edit(Request $request){
        $data = Bill::where('id', $request->bill_id)->first();
        return response()->json($data);
    }

    //update
    public function update(Request $request)
    {
        $request->validate([
            'term' => 'required',
            'academic_year' => 'required',
            'level' => 'required',
            'addMore.*.bill_amount' => 'required',
            'addMore.*.bill_description' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $bill_amount = 0;
            $bill_description = [];
            foreach ($request->addMore as $key => $value){

                $bill_amount += $value['bill_amount'];
                $bill_description[] = [
                    'description' => $value['bill_description'],
                    'amount' => $value['bill_amount']
                ];
            }
            Bill::where('id', $request->bill_id)->update([
                'bill_amount' => $bill_amount,
                'bill_description' => $bill_description,
                'term_id' => $request->term,
                'academic_year' => $request->academic_year,
                'level_id' => $request->level,
                'is_active' => $request->bill_is_active,
                'school_id' => Auth::guard('admin')->user()->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Bill updated successfully'
            ]);
        }catch(\Exception $th){
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
            Bill::where('id', $request->bill_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Bill deleted successfully'
            ]);
        }catch(\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }
}
