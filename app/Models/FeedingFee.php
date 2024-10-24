<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedingFee extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'fee',
        'academic_year_id',
        'currency_id',
        'school_id',
        'is_active'
    ];

    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function school_currency(){
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function school_academic_year(){
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id');
    }
}
