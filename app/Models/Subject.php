<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'id',
        'subject_name',
        'level_id',
        'description',
        'school_id',
        'branch_id',
        'is_active'
    ];

    protected $table = 'subjects';

    protected $primaryKey = 'id';

    public function school(){
        return $this->hasOne(School::class, 'id', 'school_id');
    }

    public function branch(){
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function level(){
        return $this->hasOne(Level::class, 'id', 'level_id');
    }
}
