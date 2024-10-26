<?php

namespace App\Imports;

use App\Models\FeedingFeeCollection;
use App\Models\Level;
use App\Models\FeedingFeeCollectionSummary;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FeedingFeeCollectionImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public $school_id;
    public $term_id;
    public $academic_year_id;
    public $feeding_fee_id;
    public $week;
    public $date;

    public function __construct($school_id, $term_id, $academic_year_id, $feeding_fee_id, $week, $date){
        $this->school_id = $school_id;
        $this->term_id = $term_id;
        $this->academic_year_id = $academic_year_id;
        $this->feeding_fee_id = $feeding_fee_id;
        $this->week = $week;
        $this->date = $date;
    }

    public function headingRow(): int
    {
        return 7;
    }

    public function collection(Collection $collection)
    {
        $levels_in_id = [];
        foreach($collection as $key => $v){
            $levels_in_id[] = Level::select('id')->where(['level_name' => $v['level'], 'school_id' => $this->school_id])->first();
        }

        foreach($levels_in_id as $key => $value){
            $collection[$key]['level_id'] = $value->id;
        }

        // dd($collection);

        foreach($collection as $key => $value){

            // dd($value['number_of_presents']);
            // check if record has already been created
            $checkOne = FeedingFeeCollection::where([
                'feeding_fee_id' => $this->feeding_fee_id,
                'term_id' => $this->term_id,
                'academic_year_id' => $this->academic_year_id,
                'week' => $this->week,
                'level_id' => $value['level_id'],
                'date' => $this->date,
                'school_id' => $this->school_id
            ])->exists();

            if($checkOne){
                return false;
            }else{
                // check if data is created in collection summary
                $checkTwo = FeedingFeeCollectionSummary::where([
                    'feeding_fee_id' => $this->feeding_fee_id,
                    'term_id' => $this->term_id,
                    'academic_year_id' => $this->academic_year_id,
                    'week' => $this->week,
                    'date' => $this->date,
                    'school_id' => $this->school_id
                ])->exists();

                if(!$checkTwo){
                    // save collection
                    FeedingFeeCollection::create([
                        'feeding_fee_id' => $this->feeding_fee_id,
                        'term_id' => $this->term_id,
                        'academic_year_id' => $this->academic_year_id,
                        'week' => $this->week,
                        'level_id' => $value['level_id'],
                        'date' => $this->date,
                        'number_of_presents' => $value['number_of_presents'],
                        'number_of_who_do_not_pay' => $value['number_of_who_do_not_pay'],
                        'number_of_credits' => $value['number_of_credits'],
                        'arrears_clearance' => $value['arrears_clearance'],
                        'advance_payment' => $value['advance_payment'],
                        'amount_realized' => $value['amount_realized'],
                        'school_id' => $this->school_id
                    ]);

                    // save collection summary
                    FeedingFeeCollectionSummary::create([
                        'feeding_fee_id' => $this->feeding_fee_id,
                        'term_id' => $this->term_id,
                        'academic_year_id' => $this->academic_year_id,
                        'week' => $this->week,
                        'date' => $this->date,
                        'total_number_of_presents' => $value['number_of_presents'],
                        'total_number_of_who_do_not_pay' => $value['number_of_who_do_not_pay'],
                        'total_number_of_credits' => $value['number_of_credits'],
                        'total_arrears_clearance' => $value['arrears_clearance'],
                        'total_advance_payment' => $value['advance_payment'],
                        'total_amount_realized' => $value['amount_realized'],
                        'school_id' => $this->school_id
                    ]);
                }else{
                    // save collection
                    FeedingFeeCollection::create([
                        'feeding_fee_id' => $this->feeding_fee_id,
                        'term_id' => $this->term_id,
                        'academic_year_id' => $this->academic_year_id,
                        'week' => $this->week,
                        'level_id' => $value['level_id'],
                        'date' => $this->date,
                        'number_of_presents' => $value['number_of_presents'],
                        'number_of_who_do_not_pay' => $value['number_of_who_do_not_pay'],
                        'number_of_credits' => $value['number_of_credits'],
                        'arrears_clearance' => $value['arrears_clearance'],
                        'advance_payment' => $value['advance_payment'],
                        'amount_realized' => $value['amount_realized'],
                        'school_id' => $this->school_id
                    ]);
                    // get id of collection summary
                    $checkThree = FeedingFeeCollectionSummary::where([
                        'feeding_fee_id' => $this->feeding_fee_id,
                        'term_id' => $this->term_id,
                        'academic_year_id' => $this->academic_year_id,
                        'week' => $this->week,
                        'date' => $this->date,
                        'school_id' => $this->school_id
                    ])->first();
                    // add new values t
                    $a = $checkThree->total_number_of_presents + $value['number_of_presents'];
                    $b = $checkThree->total_number_of_who_do_not_pay + $value['number_of_who_do_not_pay'];
                    $c = $checkThree->total_number_of_credits + $value['number_of_credits'];
                    $d = $checkThree->total_arrears_clearance + $value['arrears_clearance'];
                    $e = $checkThree->total_advance_payment + $value['advance_payment'];
                    $f = $checkThree->total_amount_realized + $value['amount_realized'];

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
            }
        }
    }

}
