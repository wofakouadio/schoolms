<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'id',
        'subject_name',
        'department_id',
        'description',
        'school_id',
        'branch_id',
        'is_active'
    ];

    protected $table = 'subjects';

    protected $primaryKey = 'id';

    public function school(){
        return $this->hasOne(School::class, 'id', 'school_id');
    }

    public function branch(){
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function department(){
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
}
