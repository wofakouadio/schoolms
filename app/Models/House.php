<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model implements \Spatie\Onboard\Concerns\Onboardable
{
    use HasFactory, UUID, SoftDeletes, \Spatie\Onboard\Concerns\GetsOnboarded;

    protected $fillable = [
        'house_name',
        'house_description',
        'house_type',
        'is_active',
        'branch_id',
        'school_id'
    ];

    public function school(){
        return $this->hasOne(School::class, 'id', 'school_id');
    }

    public function branch(){
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
}
