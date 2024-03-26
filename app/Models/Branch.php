<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'branch_name',
        'branch_description',
        'branch_location',
        'branch_email',
        'branch_contact',
        'is_active',
        'school_id'
    ];

    protected $table = 'branches';

//    public function branches(){
//        return $this->hasOne(School::class);
//    }
}
