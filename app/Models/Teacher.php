<?php

namespace App\Models;

use App\Traits\UUID;
//use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;

class Teacher extends Authenticatable implements HasMedia, \Spatie\Onboard\Concerns\Onboardable, Auditable
{
    use HasFactory, UUID, SoftDeletes;
    use InteractsWithMedia;
    use \Spatie\Onboard\Concerns\GetsOnboarded;
    use \OwenIt\Auditing\Auditable;

    
    protected $keyType = 'string';  // Ensure Eloquent treats UUIDs as strings
    public $incrementing = false;   // Disable auto-incrementing IDs




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

    protected $hidden = [
        'admin_password'
    ];

    protected $guard = 'teacher';

    public function getAuthPassword()
    {
        return $this->teacher_password;
    }

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

    public function userId()
    {
        return Auth::id(); // Automatically gets the UUID of the logged-in user
    }
}
