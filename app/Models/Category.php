<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model implements \Spatie\Onboard\Concerns\Onboardable
{
    use HasFactory, UUID, SoftDeletes, \Spatie\Onboard\Concerns\GetsOnboarded;

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
