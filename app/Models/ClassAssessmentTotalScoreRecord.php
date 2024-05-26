<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassAssessmentTotalScoreRecord extends Model
{
    use HasFactory, UUID, softDeletes;

    protected $fillable = [
        'student_id',
        'term_id',
        'academic_year_id',
        'level_id',
        'subject_id',
        'score',
        'school_id',
        'branch_id'
    ];

    public function student(){
        return $this->belongsTo(StudentsAdmissions::class, 'student_id', 'id');
    }

    public function level(){
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function term(){
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function academicYear(){
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
