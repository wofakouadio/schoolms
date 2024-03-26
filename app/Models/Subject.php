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
        'department',
        'description',
        'school_id',
        'branch_id'
    ];

    protected $table = 'subjects';

    protected $primaryKey = 'id';
}
