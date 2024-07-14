<?php

    namespace App\Helpers;

    use App\Models\Currency;
    use Illuminate\Support\Facades\Auth;

    if(!function_exists("SchoolCurrency")){
        function SchoolCurrency(){
            if(Auth::guard('admin')->check()) {
                $authUser = Auth::guard('admin')->user()->school_id;
            } elseif(Auth::guard('teacher')->check()) {
                $authUser = Auth::guard('teacher')->user()->school_id;
            } else {
                $authUser = '';
            }

            $check = Currency::where([
                'school_id' =>$authUser,
                'is_default_currency' => 1
                ])->first();

            if($check){
                return response()->json([
                    'default_currency_name' => $check->name,
                    'default_currency_symbol' => $check->symbol,
                ]);
            }else{
                return response()->json([
                    'default_currency_name' => config('assessment-settings.currency_name'),
                    'default_currency_symbol' => config('assessment-settings.currency_symbol')
                ]);
            }
        }

    }
