<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'branch_name',
        'branch_description',
        'branch_location',
        'branch_email',
        'branch_contact',
        'is_active',
        'school_id'
    ];

    protected $table = 'branches';

    public function school(){
        return $this->belongsTo(School::class, "school_id", "id");
    }
}
