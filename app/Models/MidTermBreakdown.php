<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MidTermBreakdown extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'mid_term_student_id',
        'student_id',
        'mid_term',
        'term_id',
        'subject_id',
        'score',
        'percentage',
        'school_id',
        'branch_id',
    ];

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    // public function level(){
    //     return $this->belongsTo(Level::class, 'level_id', 'id');
    // }

    public function student(){
        return $this->belongsTo(StudentsAdmissions::class, 'student_id', 'id');
    }

    public function term(){
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function midTerm(){
        return $this->belongsTo(MidTerm::class,'mid_term_student_id', 'id');
    }
}
