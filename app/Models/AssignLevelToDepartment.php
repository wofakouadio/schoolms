<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignLevelToDepartment extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'department_id',
        'level_id',
        'school_id',
        'branch_id',
        'is_active'
    ];

    public function AssingBranch(){
        return $this->hasMany(Branch::class, 'branch_id', 'id');
    }

    public function AssignLevel()
    {
        return $this->hasMany(Level::class, 'id', 'level_id');
    }

    public function AssignDepartment(){
        return $this->hasMany(Department::class, 'id', 'department_id');
    }
}
