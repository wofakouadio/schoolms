<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentsAcademicRecords extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'term_id',
        'level_id',
        'subject_id',
        'class_assessment_id',
        'class_assessment_raw_score',
        'class_assessment_percentage',
        'mid_term_id',
        'mid_term_raw_score',
        'mid_term_percentage',
        'end_term_id',
        'end_term_raw_score',
        'end_term_percentage',
        'total_raw_score',
        'total_percentage_score',
        'grade_id',
        'grade_level',
        'grade_proficiency_level',
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

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function class_assessment(){
        return $this->belongsTo(ClassAssessmentTotalScoreRecord::class, 'class_assessment_id', 'id');
    }

    public function mid_term(){
        return $this->belongsTo(MidTermBreakdown::class, 'mid_term_id', 'id');
    }

    public function end_term(){
        return $this->belongsTo(EndOfTermBreakdown::class, 'end_term_id', 'id');
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
