<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model implements \Spatie\Onboard\Concerns\Onboardable
{
    use HasFactory;
    use UUID;
    use softDeletes;
    use \Spatie\Onboard\Concerns\GetsOnboarded;

    protected $fillable = [
        'academic_year_start',
        'academic_year_end',
        'is_active',
        'school_id'
    ];

    public function academic_years_count(){
        return $this->hasMany(AcademicYear::class, 'id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function term(){
        return $this->belongsTo(Term::class, 'academic_year_id', 'id')->where('is_active', 1);
    }
}
