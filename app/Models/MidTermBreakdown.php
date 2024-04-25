<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MidTermBreakdown extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'mid_term_student_id',
        'student_id',
        'mid_term',
        'term_id',
        'subject_id',
        'score',
        'school_id',
        'branch_id',
    ];
}
