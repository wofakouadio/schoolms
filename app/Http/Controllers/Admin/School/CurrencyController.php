<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{
    //store new currency
    public function store(Request $request)
    {
        $request->validate([
            'currency_name' => 'required',
            'currency_symbol' => 'required'
        ]);

        $school_id = Auth::guard("admin")->user()->school_id;

        $checkCurrency = Currency::where(["name" => $request->currency_name, "school_id" => $school_id])->exists();

        if($checkCurrency) {
            $response = [
                'status' => 201,
                'msg' => 'Currency already exists'
            ];
        } else {
            try {
                Currency::create([
                    'name' => strtoupper($request->currency_name),
                    'symbol' => strtoupper($request->currency_symbol),
                    'school_id' => $school_id
                ]);
                $response = [
                    'status' => 200,
                    'msg' => 'Currency added successfully'
                ];
            } catch(\Exception $e) {
                $response = [
                    'status' => 201,
                    'msg' => 'Something went wrong. Error: ' . $e->getMessage()
                ];
            }
        }
        return response()->json($response);
    }

    public function edit(Request $request){
        $data = Currency::where('id', $request->currency_id)->first();
        return response()->json($data);
    }

    public function update(Request $request){
        $request->validate([
            'currency_name' => 'required',
            'currency_symbol' => 'required',
            'currency_is_active' => 'required'
        ]);


        try {
            Currency::where('id', $request->currency_id)->update([
                'name' => strtoupper($request->currency_name),
                'symbol' => strtoupper($request->currency_symbol),
                'is_active' => $request->currency_is_active
            ]);
            $response = [
                'status' => 200,
                'msg' => 'Currency updated successfully'
            ];
        } catch(\Exception $e) {
            $response = [
                'status' => 201,
                'msg' => 'Something went wrong. Error: ' . $e->getMessage()
            ];
            }

        return response()->json($response);
    }

    public function set_selected_currency_as_default(Request $request){
        if($request->is_default_currency == 1){

            $chk_if_there_is_currency_set_as_default = Currency::where(['is_default_currency' => 1, 'school_id' => Auth::guard('admin')->user()->school_id])->exists();

            if($chk_if_there_is_currency_set_as_default){
                $response = [
                    'status' => 201,
                    'msg' => 'Kindly disable the default currency before activating this as your default currency'
                ];
            }else{
                Currency::where('id', $request->currency_id)->update([
                    'is_default_currency' => $request->is_default_currency
                ]);
                $response = [
                    'status' => 200,
                    'msg' => 'Default currency set successfully'
                ];
            }
        }else{
            Currency::where('id', $request->currency_id)->update([
                'is_default_currency' => $request->is_default_currency
            ]);
            $response = [
                'status' => 200,
                'msg' => 'Currency disabled successfully'
            ];
        }
        return response()->json($response);
    }

    public function delete(Request $request){
        try{
            Currency::where('id', $request->currency_id)->delete();
            $response = [
                'status' => 200,
                'msg' => 'Currency disabled successfully'
            ];
        }catch(\Exception $th){
            $response = [
                'status' => 201,
                'msg' => 'Something went wrong. Error: ' . $th->getMessage()
            ];
        }
        return response()->json($response);
    }
}
