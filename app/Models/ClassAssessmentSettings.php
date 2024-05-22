<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassAssessmentSettings extends Model
{
    use HasFactory, UUID, softDeletes;

    protected $fillable = [
        'term_id',
        'academic_year_id',
        'class_assessment_size',
        'add_mid_term',
        'is_active',
        'school_id'
    ];

    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function schoolAcademicYear(){
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id');
    }

    public function schoolTerm(){
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }
}
