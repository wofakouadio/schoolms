<?php

namespace App\Models;

use App\Traits\UUID;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model implements HasMedia
{
    use HasFactory, UUID;
    use InteractsWithMedia;

    protected $fillable = [
        'teacher_staff_id',
        'teacher_title',
        'teacher_firstname',
        'teacher_othername',
        'teacher_lastname',
        'teacher_gender',
        'teacher_dob',
        'teacher_pob',
        'teacher_nationality',
        'teacher_address',
        'teacher_email',
        'teacher_contact',
        'teacher_profile',
        'teacher_school_attended',
        'teacher_admission_year',
        'teacher_completion_year',
        'teacher_country',
        'teacher_region',
        'teacher_district',
        'teacher_first_app',
        'teacher_present_school',
        'teacher_qualification',
        'teacher_professional',
        'teacher_rank',
        'teacher_circuit',
        'teacher_reg_number',
        'teacher_district_file_number',
        'teacher_bank_name',
        'teacher_account_number',
        'teacher_bank_branch',
        'teacher_ssnit',
        'teacher_ntc',
        'teacher_ghana_card',
        'teacher_password',
        'is_active',
        'school_id',
        'branch_id',
    ];

    public function school()
    {
        return $this->hasOne(School::class, 'id', 'school_id');
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('teacher_profile')
            ->useDisk('media');
    }
}
