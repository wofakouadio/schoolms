<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAttendance extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'student_id',
        'level_id',
        'subject_id',
        'status',
        'school_id',
        'branch_id',
        'department_id'
    ];

    public function students(){
        return $this->belongsTo(StudentsAdmissions::class, 'student_id', 'student_id');
    }

    public function level(){
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
    }
}
