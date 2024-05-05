<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'level_name',
        'level_description',
        'is_active',
        'school_id',
        'branch_id'
    ];

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
