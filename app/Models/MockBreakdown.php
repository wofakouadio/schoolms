<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockBreakdown extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'mock_student_id',
        'student_id',
        'mock_id',
        'term_id',
        'subject_id',
        'score',
        'school_id',
        'branch_id',
    ];

    protected $table = 'mock_breakdowns';

    public function student_mock(){
        return $this->belongsTo(StudentMock::class, 'mock_student_id', 'id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
