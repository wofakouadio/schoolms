<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use HasFactory, UUID, softDeletes;

    protected $fillable = [
        'academic_year_start',
        'academic_year_end',
        'is_active',
        'school_id'
    ];

    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
    }
}
