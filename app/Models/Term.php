<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'term_name',
        'term_opening_date',
        'term_closing_date',
        'term_academic_year',
        'is_active',
        'school_id'
    ];
}
