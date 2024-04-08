<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillsBreakdown extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'item',
        'amount',
        'bill_id',
        'school_id',
        'branch_id',
    ];

}
