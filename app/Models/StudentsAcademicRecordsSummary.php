<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentsAcademicRecordsSummary extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'term_id',
        'level_id',
        'class_total_score',
        'class_total_score_percentage',
        'mid_term_total_score',
        'mid_term_total_score_percentage',
        'end_term_total_score',
        'end_term_total_score_percentage',
        'total_score',
        'total_score_percentage',
        'grade_id',
        'grade_level',
        'grade_proficiency_level',
        'promotion',
        'conduct',
        'attitude',
        'interest',
        'general_remarks',
        'recommendations',
        'school_id',
        'branch_id'
    ];

    public function student(){
        return $this->belongsTo(StudentsAdmissions::class, 'student_id', 'id');
    }

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id');
    }

    public function term(){
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function level(){
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function grade(){
        return $this->belongsTo(GradingSystem::class, 'grade_id', 'id');
    }

    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

}
