<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use OwenIt\Auditing\Contracts\Auditable;

class Student extends Model implements HasMedia , Auditable
{
    use HasFactory, UUID, InteractsWithMedia, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'student_id',
        'student_password',
        'student_status',
        'is_active',
        'school_id',
        'admission_id'
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

    public function house(){
        return $this->hasOne(House::class, 'id','student_house');
    }

    public function category(){
        return $this->hasOne(Category::class,'id','student_category');
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
