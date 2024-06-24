<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EndOfTermBreakdown extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'end_term_student_id',
        'student_id',
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

    public function end_term(){
        return $this->belongsTo(EndOfTerm::class, 'end_term_student_id', 'id');
    }

    public function student(){
        return $this->belongsTo(StudentsAdmissions::class, 'student_id', 'id');
    }

    public function term(){
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
