<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mock extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'mock_type',
        'school_id',
        'branch_id',
        'is_active'
    ];

}
