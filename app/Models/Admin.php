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


    public function students(){
        return $this->hasMany(StudentsAdmissions::class, 'school_id', 'school_id');
    }

    public function student(){
        return $this->hasMany(StudentsAdmissions::class, 'school_id', 'school_id')->with('attendance'); //->whereDay
        //('student_attendances.created_at', now()->day)
            //->join('student_attendances','students_admissions.school_id','=','student_attendances.school_id');
    }

    public function school(){
        return $this->hasOne(School::class, 'admin_id', 'id');
    }

    public function attendance(){
        return $this->hasOne(StudentAttendance::class, 'school_id', 'school_id')->whereDay('student_attendances.created_at', now()->day);
            //->leftJoin('students_admissions','students_admissions.school_id','=','student_attendances.school_id');
    }

}
