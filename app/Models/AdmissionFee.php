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

    public function school(){
        return $this->hasOne(School::class, 'school_id', 'id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class,'academic_year_id', 'id');
    }
}
