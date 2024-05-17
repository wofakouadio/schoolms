<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradingSystem extends Model
{
    use HasFactory, UUID, softDeletes;

    protected $fillable = [
        'academic_year',
        'score_from',
        'score_to',
        'grade',
        'level_of_proficiency',
        'is_active',
        'school_id'
    ];

    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
    }
}
