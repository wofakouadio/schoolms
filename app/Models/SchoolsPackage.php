<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolsPackage extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'package_id',
        'package_name',
        'package_amount',
        'package_purchase_date',
        'package_duration',
        'is_active',
        'school_id'
    ];
}
