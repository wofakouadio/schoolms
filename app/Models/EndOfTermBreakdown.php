<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndOfTermBreakdown extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'end_term_student_id',
        'student_id',
        'term_id',
        'subject_id',
        'class_score',
        'exam_score',
        'school_id',
        'branch_id',
    ];

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
