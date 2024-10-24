<?php

namespace App\Models;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedingFeeCollection extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'feeding_fee_id',
        'week',
        'date',
        'level_id',
        'number_of_presents',
        'number_of_who_do_not_pay',
        'number_of_credits',
        'arrears_clearance',
        'advance_payment',
        'amount_realized',
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

    public function school_currency(){
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function school_academic_year(){
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id');
    }

    public function school_level(){
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
}
