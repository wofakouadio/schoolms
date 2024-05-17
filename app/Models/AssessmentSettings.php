<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentSettings extends Model
{
    use HasFactory, UUID, softDeletes;

    protected $fillable = [
        'academic_year',
        'class_percentage',
        'exam_percentage',
        'is_active',
        'school_id'
    ];
}
