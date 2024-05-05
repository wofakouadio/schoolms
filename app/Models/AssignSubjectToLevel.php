<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignSubjectToLevel extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'subject_id',
        'level_id',
        'school_id',
        'branch_id',
        'is_active'
    ];

    public function level(){
        return $this->hasOne(Level::class, 'id', 'level_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
