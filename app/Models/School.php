<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'school_name',
        'school_location',
        'school_email',
        'school_phoneNumber',
        'school_logo'
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function branches(){
        return $this->hasMany(Branch::class);
    }

}
