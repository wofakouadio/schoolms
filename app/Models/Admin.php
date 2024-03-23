<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, UUID;

    protected $fillable = [
        'admin_firstName',
        'admin_lastName',
        'admin_phoneNumber',
        'admin_email',
        'admin_password',
        'is_active',
        'school_id',
        'branch_id'
    ];

    protected $hidden = [
        'admin_password'
    ];

    protected $guard = 'admin';

    public function getAuthPassword()
    {
        return $this->admin_password;
    }

    public function school(){
        return $this->hasOne(School::class);
    }

    public function branches(){
        return $this->hasMany(Branch::class);
    }
}
