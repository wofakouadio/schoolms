<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\AcademicYear;
use App\Models\FeedingFee;
use App\Models\FeedingFeeCollection;
use App\Models\FeedingFeeCollectionSummary;
use App\Models\Term;
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
        $term = Term::where(['school_id' => Auth::guard('admin')->user()->school_id, 'is_active' => 1])->first();
        $academicYear = AcademicYear::where(['school_id' => Auth::guard('admin')->user()->school_id, 'is_active' => 1])->first();
        $currency = Currency::where(['school_id' => Auth::guard('admin')->user()->school_id, 'is_active' => 1])->first();
        $feeding_fee = FeedingFee::where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            'currency_id' => $currency->id,
            'academic_year_id' => $academicYear->id,
            'is_active' => 1
            ])->first();
        // $records
        $records = FeedingFee::with('school_currency', 'school_academic_year')->where(['school_id' => Auth::guard('admin')->user()->school_id])->get();
        // collection summary
        $collectionSummary = FeedingFeeCollectionSummary::with('school_term', 'school_academic_year', 'school_feeding_fee')->where(['school_id' => Auth::guard('admin')->user()->school_id])->get();
        // dd($records);
        return view('admin.dashboard.finance.feeding-fee.index', compact('schoolTerm', 'schoolCurrency', 'term', 'academicYear', 'currency', 'feeding_fee', 'records', 'collectionSummary'));
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

    // new feeding fee collection and summary
    public function feeding_fee_new_collection(Request $request){
        // check if record has already been created
        $checkOne = FeedingFeeCollection::where([
            'feeding_fee_id' => $request->feeding_fee_id,
            'term_id' => $request->term_id,
            'academic_year_id' => $request->academic_year_id,
            'week' => $request->week,
            'level_id' => $request->level_id,
            'date' => $request->date,
            'school_id' => Auth::guard('admin')->user()->school_id
        ])->exists();

        if($checkOne){
            return redirect()->route('admin_finance_feeding_fee')->with('info', 'Feeding Fee collection record already saved');
        }else{
            DB::beginTransaction();
            try{
                // check if data is created in collection summary
                $checkTwo = FeedingFeeCollectionSummary::where([
                    'feeding_fee_id' => $request->feeding_fee_id,
                    'term_id' => $request->term_id,
                    'academic_year_id' => $request->academic_year_id,
                    'week' => $request->week,
                    'date' => $request->date,
                    'school_id' => Auth::guard('admin')->user()->school_id
                ])->exists();

                if(!$checkTwo){
                    // save collection
                    FeedingFeeCollection::create([
                        'feeding_fee_id' => $request->feeding_fee_id,
                        'term_id' => $request->term_id,
                        'academic_year_id' => $request->academic_year_id,
                        'week' => $request->week,
                        'level_id' => $request->level_id,
                        'date' => $request->date,
                        'number_of_presents' => $request->number_of_presents,
                        'number_of_who_do_not_pay' => $request-> number_of_do_not_pay,
                        'number_of_credits' => $request->number_of_credits,
                        'arrears_clearance' => $request->arrears_clearance,
                        'advance_payment' => $request->advance_payment,
                        'amount_realized' => $request->amount_realized,
                        'school_id' => Auth::guard('admin')->user()->school_id
                    ]);

                    // save collection summary
                    FeedingFeeCollectionSummary::create([
                        'feeding_fee_id' => $request->feeding_fee_id,
                        'term_id' => $request->term_id,
                        'academic_year_id' => $request->academic_year_id,
                        'week' => $request->week,
                        'date' => $request->date,
                        'total_number_of_presents' => $request->number_of_presents,
                        'total_number_of_who_do_not_pay' => $request-> number_of_do_not_pay,
                        'total_number_of_credits' => $request->number_of_credits,
                        'total_arrears_clearance' => $request->arrears_clearance,
                        'total_advance_payment' => $request->advance_payment,
                        'total_amount_realized' => $request->amount_realized,
                        'school_id' => Auth::guard('admin')->user()->school_id
                    ]);
                }else{
                    // save collection
                    FeedingFeeCollection::create([
                        'feeding_fee_id' => $request->feeding_fee_id,
                        'term_id' => $request->term_id,
                        'academic_year_id' => $request->academic_year_id,
                        'week' => $request->week,
                        'level_id' => $request->level_id,
                        'date' => $request->date,
                        'number_of_presents' => $request->number_of_presents,
                        'number_of_who_do_not_pay' => $request-> number_of_do_not_pay,
                        'number_of_credits' => $request->number_of_credits,
                        'arrears_clearance' => $request->arrears_clearance,
                        'advance_payment' => $request->advance_payment,
                        'amount_realized' => $request->amount_realized,
                        'school_id' => Auth::guard('admin')->user()->school_id
                    ]);
                    // get id of collection summary
                    $checkThree = FeedingFeeCollectionSummary::where([
                        'feeding_fee_id' => $request->feeding_fee_id,
                        'term_id' => $request->term_id,
                        'academic_year_id' => $request->academic_year_id,
                        'week' => $request->week,
                        'date' => $request->date,
                        'school_id' => Auth::guard('admin')->user()->school_id
                    ])->first();
                    // add new values t
                    $a = $checkThree->total_number_of_presents + $request->number_of_presents;
                    $b = $checkThree->total_number_of_who_do_not_pay + $request-> number_of_do_not_pay;
                    $c = $checkThree->total_number_of_credits + $request->number_of_credits;
                    $d = $checkThree->total_arrears_clearance + $request->arrears_clearance;
                    $e = $checkThree->total_advance_payment + $request->advance_payment;
                    $f = $checkThree->total_amount_realized + $request->amount_realized;

                    // update collection summary
                    FeedingFeeCollectionSummary::where('id' ,'=' ,$checkThree->id)->update([
                        'total_number_of_presents' => $a,
                        'total_number_of_who_do_not_pay' => $b,
                        'total_number_of_credits' => $c,
                        'total_arrears_clearance' => $d,
                        'total_advance_payment' => $e,
                        'total_amount_realized' => $f
                    ]);
                }
                DB::commit();
                return redirect()->route('admin_finance_feeding_fee')->with('success', 'Feeding Fee collection recorded successfully');
            }catch(\Exception $th){
                DB::rollBack();
                return redirect()->route('admin_finance_feeding_fee')->with('warning', 'Something went wrong: Details :'.$th->getMessage());
            }
        }
    }
}
