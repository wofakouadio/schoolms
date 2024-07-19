<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'name',
        'symbol',
        'school_id',
        'is_default_currency',
        'is_active'
    ];

    public function school(){
        return $this->belongsTo(School::class, 'school_id', 'id');
    }
}
