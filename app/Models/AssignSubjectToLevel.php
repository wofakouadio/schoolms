<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignSubjectToLevel extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'subject_id',
        'level_id',
        'school_id',
        'branch_id',
        'is_active'
    ];
}
