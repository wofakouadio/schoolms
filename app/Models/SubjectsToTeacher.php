<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectsToTeacher extends Model implements \Spatie\Onboard\Concerns\Onboardable
{
    use HasFactory, UUID, \Spatie\Onboard\Concerns\GetsOnboarded;

    protected $fillable = [
        'teacher_id',
        'level_id',
        'subject_id',
        'school_id',
        'branch_id'
    ];

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function level(){
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
}
