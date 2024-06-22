<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MidTerm extends Model
{
    use HasFactory, UUID, SoftDeletes;

    protected $fillable = [
        'student_id',
        'level_id',
        'mid_term',
        'term_id',
        'total_score',
        'total_percentage',
        'school_id',
        'branch_id',
    ];

    public function level(){
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function student(){
        return $this->belongsTo(StudentsAdmissions::class, 'student_id', 'id');
    }

    public function term(){
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
