<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentSettings extends Model implements \Spatie\Onboard\Concerns\Onboardable
{
    use HasFactory, UUID, softDeletes,  \Spatie\Onboard\Concerns\GetsOnboarded;

    protected $fillable = [
        'academic_year',
        'class_percentage',
        'exam_percentage',
        'mid_term_percentage',
        'is_active',
        'school_id'
    ];

    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function school_academic_year(){
        return $this->belongsTo(AcademicYear::class, 'academic_year', 'id');
    }
}
