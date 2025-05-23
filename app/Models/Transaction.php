<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\UUID;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use function App\Helpers\SchoolCurrency;
use OwenIt\Auditing\Contracts\Auditable;

class Transaction extends Model implements Auditable
{
    use HasFactory, UUID, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public $incrementing = false; // Disable auto-increment
    protected $keyType = 'string'; // UUID is stored as string

    protected $auditableEvents = ['created', 'updated', 'deleted', 'restored'];

    public function generateTags(): array
    {
        return ['user_id' => Auth::id()];
    }

    protected $fillable = [
        'invoice_id',
        'student_id',
        'term_id',
        'level_id',
        'academic_year_id',
        'description',
        'amount_due',
        'amount_paid',
        'transaction_type',
        'balance',
        'items',
        'payment_status',
        'paid_at',
        'reference',
        'branch_id',
        'school_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            $user = Auth::guard('admin')->user();
            $schoolCurrency = SchoolCurrency();
            //get current academic year
            $current_academic_year = AcademicYear::where(['school_id' => $model->school_id ?? $user->school_id, 'is_active' => 1])->first();

            //get current Term
            $current_term = Term::where(['school_id' => $model->school_id ?? $user->school_id, 'is_active' => 1])->first();

            $date_stamp = Carbon::now()->timestamp . '0'; //.Carbon::now()->format('dmYis').'0';
            $new_transaction = Transaction::all()->count() + 1;
            $invoice_sequence = sprintf("%'.06d", $new_transaction);
            $invoice_id = $date_stamp . $new_transaction . $invoice_sequence;

            $model->id = Str::uuid();
            $model->invoice_id = $invoice_id;
            $model->currency = $schoolCurrency->getData()->default_currency_symbol;
            $model->school_id = $model->school_id ?? $user->school_id;
            $model->branch_id = $model->branch_id ?? $user->branch_id;
            $model->term_id = $model->term_id ?? $current_term->id;
            $model->academic_year_id = $model->academic_year_id ?? $current_academic_year->id;
            // $model->transaction_type = "DR";
        });

        static::updating(function ($model) {
            $model->audit();
        });

        static::deleting(function ($model) {
            $model->audit();
        });

        static::restoring(function ($model) {
            $model->audit();
        });
    }

    public static function generate_invoice()
    {
        //generate invoice number
        $date_stamp = Carbon::now()->timestamp;
        $new_transaction = Transaction::all()->count() + 1;
        $invoice_sequence = sprintf("%'.06d", $new_transaction);
        $invoice_id = $date_stamp . $new_transaction . $invoice_sequence;
        return $invoice_id;
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(StudentsAdmissions::class, 'student_id', 'id');
    }

    public function academic_year()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function userId()
    {
        return Auth::id(); // Automatically gets the UUID of the logged-in user
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function total_outstanding_balance($student_id)
    {
        return Transaction::where('student_id', $student_id)->where('payment_status','awaiting_payment')->sum('amount_due');
    }
}
