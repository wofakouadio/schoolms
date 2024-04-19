<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignSubjectsToMock extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'mock_id',
        'subject_id',
        'school_id',
        'branch_id'
    ];

    protected $table = 'assign_subjects_to_mocks';

    public function AssignSubject(){
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }
}
