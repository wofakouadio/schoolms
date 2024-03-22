<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'id',
        'name',
        'description',
        'school_id',
        'branch_id'
    ];

    protected $table = 'departments';
}
