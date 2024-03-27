<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'level_name',
        'level_description',
        'is_active',
        'school_id',
        'branch_id'
    ];
}
