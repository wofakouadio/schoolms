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
}
