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

    protected $table = 'student_mocks';

    public function level(){
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function student(){
        return $this->belongsTo(StudentsAdmissions::class, 'student_id', 'id');
    }

    public function mock(){
        return $this->belongsTo(Mock::class, 'mock_id', 'id');
    }

    public function term(){
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
