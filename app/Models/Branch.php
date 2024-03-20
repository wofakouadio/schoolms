<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'branch_name',
        'branch_location',
        'is_active',
        'school_id'
    ];

    public function branches(){
        return $this->hasOne(School::class);
    }
}
