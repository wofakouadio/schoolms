<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPermission extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'user_id',
        'user_type',
        'status',
        'school_id'
    ];
    public function teacher(){
        return $this->belongsTo(Teacher::class, 'user_id', 'id');
    }
}
