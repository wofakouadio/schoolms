<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model implements \Spatie\Onboard\Concerns\Onboardable
{
    use HasFactory, UUID, SoftDeletes, \Spatie\Onboard\Concerns\GetsOnboarded;

    protected $fillable = [
        'bill_amount',
        'bill_description',
        'academic_year',
        'is_for_academic_year',
        'is_active',
        'term_id',
        'level_id',
        'school_id',
        'branch_id'
    ];

    protected $casts = [
        'bill_description' => 'array'
    ];

    public function school()
    {
        return $this->hasOne(School::class, 'id', 'school_id');
    }

    public function term(){
        return $this->hasOne(Term::class, 'id', 'term_id');
    }

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class, 'academic_year', 'id');
    }

    public function level(){
        return $this->hasOne(Level::class, 'id', 'level_id');
    }

    public function billsbreakdown(){
        return $this->hasMany(BillsBreakdown::class, 'bill_id', 'id');
    }
}
