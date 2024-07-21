<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class StudentsAdmissions extends Model implements HasMedia
{
    use HasFactory, UUID, SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'student_id',
        'student_firstname',
        'student_othername',
        'student_lastname',
        'student_gender',
        'student_dob',
        'student_pob',
        'student_branch',
        'student_level',
        'student_house',
        'student_category',
        'student_residency_type',
        'student_guardian_name',
        'student_guardian_contact',
        'student_guardian_address',
        'student_guardian_email',
        'student_guardian_occupation',
        'student_password',
        'admission_status',
        'student_status',
        'is_active',
        'school_id',
        'previous_arrears',
        'current_bill_amount',
        'total_bill_amount',
        'wallet',
    ];

    public function school(){
        return $this->hasOne(School::class,  'id','school_id');
    }

    public function branch(){
        return $this->hasOne(Branch::class,  'id','student_branch');
    }

    public function level(){
        return $this->hasOne(Level::class, 'id','student_level');
    }

    public function teacher_level(){
        return $this->hasMany(Level::class, 'id','student_level');
    }

    public function house(){
        return $this->hasOne(House::class, 'id','student_house');
    }

    public function category(){
        return $this->hasOne(Category::class,'id','student_category');
    }

    public function attendance(){
        return $this->hasOne(StudentAttendance::class, 'student_id', 'student_id')->whereDay('created_at', now()->day);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('student_profile')
            ->singleFile()
            ->useDisk('media');

        $this
            ->addMediaCollection('student_guardian_id_card')
            ->singleFile()
            ->useDisk('media');
    }
}
