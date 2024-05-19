<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Term extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'term_name',
        'term_opening_date',
        'term_closing_date',
        'term_academic_year',
        'is_active',
        'school_id'
    ];

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class, 'term_academic_year', 'id');
    }
}
