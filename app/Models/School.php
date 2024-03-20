<?php

namespace App\Models;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'school_name',
        'school_location',
        'school_email',
        'school_phoneNumber',
        'school_logo',
        'admin_id'
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function branches(){
        return $this->hasMany(Branch::class);
    }

}
