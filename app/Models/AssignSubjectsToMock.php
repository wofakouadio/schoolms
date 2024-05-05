<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignSubjectsToMock extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'mock_id',
        'level_id',
        'subject_id',
        'school_id',
        'branch_id'
    ];

    protected $table = 'assign_subjects_to_mocks';

    public function AssignSubject(){
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }

    public function subject()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }
}
