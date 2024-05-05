<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillsBreakdown extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'item',
        'amount',
        'bill_id',
        'school_id',
        'branch_id',
    ];

}
