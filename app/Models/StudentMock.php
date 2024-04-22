<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMock extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'student_id',
        'level_id',
        'mock_id',
        'term_id',
        'total_score',
        'conduct',
        'attitude',
        'interest',
        'general_remarks',
        'school_id',
        'branch_id',
    ];
}
