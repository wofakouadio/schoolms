<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingLog extends Model
{
    use HasFactory, UUID; //, SoftDeletes;

    protected $fillable = [
        'student_id',
        'level_id',
        'term_id',
        'academic_year_id',
        'amount_billed',
        'school_id',
        'branch_id'
    ];

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class, 'term_academic_year', 'id');
    }

    public function student()
    {
        return $this->belongsTo(StudentsAdmissions::class, 'student_id');
    }

    public function studentAdmission()
    {
        return $this->belongsTo(StudentsAdmissions::class,'id','student_id');
    }
}
