<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Term extends Model implements \Spatie\Onboard\Concerns\Onboardable
{
    use HasFactory, UUID, SoftDeletes, \Spatie\Onboard\Concerns\GetsOnboarded;

    protected $fillable = [
        'term_name',
        'term_opening_date',
        'term_closing_date',
        'term_academic_year',
        'is_active',
        'school_id'
    ];

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class, 'term_academic_year', 'id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
