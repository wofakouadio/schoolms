<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentsHealthRecords extends Model
{
    use HasFactory,UUID, SoftDeletes;


    protected $fillable = [
        'student_id',
        'student_birth_type',
        'student_birth_type_other',
        'student_weight',
        'student_having_chronic_disease',
        'student_has_chronic_disease',
        'student_having_generic_disease',
        'student_has_generic_disease',
        'student_having_allergies',
        'student_has_allergies',
        'student_having_stitches',
        'student_has_stitches',
        'causes_for_student_has_stitches',
        'student_other_health_info',
        'school_id',
        'branch_id'
    ];

    public function school(){
        return $this->hasOne(School::class, 'id', 'school_id');
    }

    public function branch(){
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
}
