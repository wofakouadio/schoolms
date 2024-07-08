<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionFee extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'academic_year_id',
        'amount',
        'is_active',
        'branch_id',
        'school_id',
        'department_id'
    ];

    // public function school(){
    //     return $this->hasOne(School::class, 'id', 'school_id');
    // }

    // public function branch(){
    //     return $this->hasOne(Branch::class, 'id', 'branch_id');
    // }
}
