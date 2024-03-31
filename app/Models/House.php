<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'house_name',
        'house_description',
        'house_type',
        'is_active',
        'branch_id',
        'school_id'
    ];

    public function school(){
        return $this->hasOne(School::class, 'id', 'school_id');
    }

    public function branch(){
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
}
