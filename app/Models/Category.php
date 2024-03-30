<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'category_name',
        'category_description',
        'is_active',
        'school_id'
    ];

    public function school(){
        return $this->hasMany(School::class, 'school_id', 'id');
    }
}
