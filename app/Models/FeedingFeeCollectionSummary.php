<?php

namespace App\Models;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedingFeeCollectionSummary extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'feeding_fee_id',
        'week',
        'date',
        'total_number_of_presents',
        'total_number_of_who_do_not_pay',
        'total_number_of_credits',
        'total_arrears_clearance',
        'total_advance_payment',
        'total_amount_realized',
        'term_id',
        'academic_year_id',
        'school_id'
    ];

    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function school_term(){
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function school_academic_year(){
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id');
    }

    public function school_feeding_fee(){
        return $this->belongsTo(FeedingFee::class, 'feeding_fee_id', 'id');
    }
}
