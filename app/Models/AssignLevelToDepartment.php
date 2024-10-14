<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignLevelToDepartment extends Model implements \Spatie\Onboard\Concerns\Onboardable
{
    use HasFactory, UUID, SoftDeletes, \Spatie\Onboard\Concerns\GetsOnboarded;

    protected $fillable = [
        'department_id',
        'level_id',
        'school_id',
        'branch_id',
        'is_active'
    ];

    public function AssignBranch(){
        return $this->hasMany(Branch::class, 'branch_id', 'id');
    }

    public function AssignLevel()
    {
        return $this->hasOne(Level::class, 'id', 'level_id');
    }

    public function AssignDepartment(){
        return $this->hasMany(Department::class, 'id', 'department_id');
    }
}
