<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\AcademicYear;
use App\Models\FeedingFee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolCurrency;

class FeedingFeeController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $schoolCurrency = SchoolCurrency();
        // dd($schoolCurrency);
        $academicYear = AcademicYear::where(['school_id' => Auth::guard('admin')->user()->school_id, 'is_active' => 1])->first();
        $currency = Currency::where(['school_id' => Auth::guard('admin')->user()->school_id, 'is_active' => 1])->first();
        // $records = [] ?? null;
        $records = FeedingFee::with('school_currency', 'school_academic_year')->where(['school_id' => Auth::guard('admin')->user()->school_id])->get();
        // dd($records);
        return view('admin.dashboard.finance.feeding-fee.index', compact('schoolTerm', 'schoolCurrency', 'academicYear', 'currency', 'records'));
    }

    // new feeding fee setup
    public function new_feeding_fee_setup(Request $request){
        $request->validate([
            'amount' => 'required'
        ]);
        DB::beginTransaction();
        try{
            // check if feeding fee has already been saved with the current academic year
            $check = FeedingFee::where([
                'academic_year_id' => $request->academic_year_id,
                'school_id' => Auth::guard('admin')->user()->school_id
            ])->exists();
            if($check){
                return redirect()->route('admin_finance_feeding_fee')->with('error', 'Feeding Fee already setup for this academic year');
            }
            FeedingFee::create([
                'fee' => $request->amount,
                'currency_id' => $request->currency_id,
                'academic_year_id' => $request->academic_year_id,
                'school_id' => Auth::guard('admin')->user()->school_id
            ]);
            DB::commit();
            return redirect()->route('admin_finance_feeding_fee')->with('success', 'New Feeding Fee Setup created');
        }catch(\Exception $th){
            DB::rollBack();
            return redirect()->route('admin_finance_feeding_fee')->with('error', 'Something went wrong. Detail: ' . $th->getMessage());
        }
    }

    // get feeding fee data
    public function get_feeding_fee_data(Request $request){
        $data = FeedingFee::with('school_academic_year', 'school_currency')->where('id', $request->id)->first();
        return response()->json($data);
    }

    // update feeding fee data
    public function update_feeding_fee_data(Request $request){
        $request->validate([
            'amount' => 'required',
            'is_active' => 'required'
        ]);
        DB::beginTransaction();
        try{
            FeedingFee::where([
                'id' => $request->feeding_fee_id
            ])->update([
                'fee' => $request->amount,
                'is_active' => $request->is_active
            ]);
            DB::commit();
            return redirect()->route('admin_finance_feeding_fee')->with('success', 'Feeding Fee Setup updated successfully');
        }catch(\Exception $th){
            DB::rollBack();
            return redirect()->route('admin_finance_feeding_fee')->with('error', 'Something went wrong. Detail: ' . $th->getMessage());
        }
    }

    // delete feeding fee data
    public function delete_feeding_fee_data(Request $request){
        DB::beginTransaction();
        try{
            FeedingFee::where([
                'id' => $request->feeding_fee_id
            ])->delete();
            DB::commit();
            return redirect()->route('admin_finance_feeding_fee')->with('success', 'Feeding Fee Setup deleted successfully');
        }catch(\Exception $th){
            DB::rollBack();
            return redirect()->route('admin_finance_feeding_fee')->with('error', 'Something went wrong. Detail: ' . $th->getMessage());
        }
    }
}
