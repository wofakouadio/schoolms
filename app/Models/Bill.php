<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'bill_amount',
        'bill_description',
        'academic_year',
        'is_active',
        'term_id',
        'level_id',
        'school_id'
    ];

    protected $casts = [
        'bill_description' => 'array'
    ];

    public function school()
    {
        return $this->hasOne(School::class, 'id', 'school_id');
    }

    public function term(){
        return $this->hasOne(Term::class, 'id', 'term_id');
    }

    public function level(){
        return $this->hasOne(Level::class, 'id', 'level_id');
    }
}
