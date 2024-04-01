<?php

namespace App\Models;
use App\Traits\UUID;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model implements HasMedia
{
    use HasFactory, UUID;
    use InteractsWithMedia;

    protected $fillable = [
        'school_name',
        'school_location',
        'school_email',
        'school_phoneNumber',
        'school_logo',
        'admin_id'
    ];

    public function admin(){
        return $this->belongsTo(Admin::class, 'school_id', 'id');
    }

    public function branches(){
        return $this->hasMany(Branch::class, 'school_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('school_logo')
            ->useDisk('media');
    }
}
