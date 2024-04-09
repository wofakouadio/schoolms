<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'name',
        'description',
        'school_id',
        'branch_id',
        'is_active'
    ];

    public function school(){
        return $this->hasOne(School::class, 'id', 'school_id');
    }

    public function branch(){
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
}
