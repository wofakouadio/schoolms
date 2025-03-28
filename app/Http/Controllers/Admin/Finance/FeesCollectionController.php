<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\StudentsAdmissions;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolCurrency;

class FeesCollectionController extends Controller
{
    //index()
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        $transactions = [] ?? null;
        $studentsList = StudentsAdmissions::with('level', 'house', 'category')
        ->where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            'admission_status' => 1
            ])->orderBy('student_id', 'asc')
        ->get()->groupBy('category.category_name');
        return view("admin.dashboard.finance.transactions.index", compact("schoolTerm", "transactions", "studentsList"));
    }

    public function create(Request $request)
    {
        $schoolTerm = TermAndAcademicYear();
        $student_id = $request->student_id;
        $schoolCurrency = SchoolCurrency();
        // dd($schoolCurrency);
        $getStudent = StudentsAdmissions::with('level')->where("id", $student_id)->first();

        // get student transactions based on student id
        $transactions = Transaction::where([
            'student_id' => $getStudent->id,
            'payment_status' => 'awaiting_payment',
            'school_id' => Auth::guard('admin')->user()->school_id
        ])->get();

        $studentData = [
            'student_uuid' => $student_id,
            'student_id' => $getStudent->student_id,
            'student_name' => $getStudent->student_firstname . ' ' . $getStudent->student_othername . ' ' . $getStudent->lastname,
            'student_level' => $getStudent->level->level_name,
            'wallet' => money($getStudent->wallet),
        ];
        $studentsList = StudentsAdmissions::with('level', 'house', 'category')
        ->where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            'admission_status' => 1
            ])->orderBy('student_id', 'asc')
        ->get()->groupBy('category.category_name');
        // dd($transactions);
        return view("admin.dashboard.finance.transactions.index", compact("schoolTerm", "transactions", "studentData", "schoolCurrency", "studentsList"));
        // $transactions = [
        //     'studentTransactions' =>
        // ];
    }

    //collect fee from students
    public function store(Request $request)
    {
        // dd($request->all());
        $amount_paid = 0;
        if ($request->transaction_allocations) {
            foreach ($request->transaction_allocations as $k => $item) {
                $amount_paid = $item['amount_to_pay'] + $amount_paid;
            }
        }
        // dd($request->all());

        if ($request->payment_method == 'Choose') {
            // toastr()->error('Select a payment option.');
            flash()->option('timeout', 5000)->addWarning('Select a payment option', 'Notice');
            // Alert::alert('Notification', 'Select a payment option');
            // return redirect()->back();
            // return back()->withErrors(['error' => 'Select a payment option']);
            return redirect()->route('admin_finance_fee_collection');
        }

        if ($amount_paid != $request->amount_paid) {
            flash()->option('timeout', 5000)->addError('Total Amount paid is not equal to the total allocation.');
            // return redirect()->back();
            return redirect()->route('admin_finance_fee_collection');
        }

        DB::beginTransaction();

        try {
            $schoolTerm = TermAndAcademicYear();
            $student = StudentsAdmissions::where('id', $request->student_id)->first();

            if ($request->payment_method == "Wallet") {
                if ($amount_paid != $student->wallet) {
                    flash()->option('timeout', 5000)->addError('Total Amount paid is not equal to the total allocation.');
                    // return redirect()->back();
                    return redirect()->route('admin_finance_fee_collection');
                }
            }
            // $transaction = [];
            foreach ($request->transaction_allocations as $k => $item) {

                // $transaction[] = Transaction::where('id', $item['id'])->first();
                $transaction = Transaction::where('id', $item['id'])->first();

                //if student pays exact amount
                if ($item['amount_due'] == $item['amount_to_pay']) {
                    $balance = $item['amount_due'] - $item['amount_to_pay'];

                    $transaction->update([
                        'amount_paid' => $item['amount_to_pay'],
                        'balance' => $balance,
                        'payment_status' => 'paid',
                        'paid_at' => Carbon::now(),
                        'transaction_type' => $request->payment_method,
                        'reference' => $item['transaction_number']
                    ]);
                }

                //if student under pays
                if ($item['amount_due'] > $item['amount_to_pay']) {
                    $balance = $item['amount_due'] - $item['amount_to_pay'];

                    $transaction->update([
                        'amount_paid' => $item['amount_to_pay'],
                        'balance' => $balance,
                        'payment_status' => 'partial_payment',
                        'paid_at' => Carbon::now(),
                        'transaction_type' => $request->payment_method,
                        'reference' => $item['transaction_number']
                    ]);

                    if ($balance > 0) {
                        Transaction::create([
                            "academic_year_id" => $schoolTerm->term_academic_year,
                            "amount_due" => $balance,
                            'payment_status' => 'awaiting_payment',
                            "student_id" => $request->student_id,
                            "level_id" => $student->student_level,
                            "description" => 'New Balance for ' . $transaction->items,
                            "items" => $transaction->items
                        ]);
                    }
                }

                //if student over pays
                if ($item['amount_due'] < $item['amount_to_pay']) {
                    $balance = $item['amount_due'] - $item['amount_to_pay'];

                    $transaction->update([
                        'amount_paid' => $item['amount_to_pay'],
                        'balance' => $balance,
                        'payment_status' => 'over_payment',
                        'paid_at' => Carbon::now(),
                        'transaction_type' => $request->payment_method,
                        'reference' => $item['transaction_number']
                    ]);

                    if ($balance < 0) {
                        $student->update([
                            'wallet' => $student->wallet + $balance
                        ]);
                    }
                }
            }

            // dd($transaction);

            //update student admission with current balances
            $student->update([
                'total_bill_amount' => $student->total_bill_amount - $request->amount_paid,
                'current_bill_amount' => $student->current_bill_amount - $request->amount_paid
            ]);

            //if mode of payment is wallet deduct from wallet. Note that wallet is a negative value signifying overpayment
            if ($request->payment_method == "Wallet") {
                $student->update([
                    'wallet' => $student->wallet + $request->amount_paid
                ]);
            }

            DB::commit();

            flash()->option('timeout', 5000)->addSuccess('Fee collection done successful!');
            return redirect()->route('admin_finance_fee_collection');
        } catch (\Exception $th) {
            DB::rollBack();

            // toastr()->error('Error!');
            return back()->withErrors(['error' => 'Something went wrong. Details : '.$th->getMessage()]);
            // return redirect()->back();
        }
    }

    // view student fee collected
    public function view_student_transactions()
    {
        $schoolTerm = TermAndAcademicYear();
        $schoolCurrency = SchoolCurrency();
        $studentsList = StudentsAdmissions::with('level', 'house', 'category')
        ->where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            'admission_status' => 1
            ])->orderBy('student_id', 'asc')
        ->get()->groupBy('category.category_name');
        return view("admin.dashboard.finance.student-transactions.index", compact("schoolTerm", "schoolCurrency", "studentsList"));
    }

    public function get_student_transactions(Request $request)
    {
        $request->validate([
            'student_id' => 'required'
        ]);
        $student_id = $request->student_id;
        $getStudent = StudentsAdmissions::with('level', 'house')->where("id", $student_id)->first();
        $schoolCurrency = SchoolCurrency();
        // get student transactions based on student id
        $transactions = Transaction::where([
            'student_id' => $getStudent->id,
            'payment_status' => 'awaiting_payment',
            'school_id' => Auth::guard('admin')->user()->school_id
        ])->get();

        $data = [
            'studentData' => $getStudent,
            'transactions' => $transactions,
            'currency_symbol' => $schoolCurrency->getData()->default_currency_symbol
        ];

        return response()->json($data);
    }

    // update transaction data
    public function update_transaction_data(Request $request)
    {
        $student_uuid = $request->student_uuid;
        $transaction_id = $request->transaction_id;
        // $item = $request->item;
        // $invoice_id = $request->invoice_id;
        $new_amount_due = $request->amount_due;
        DB::beginTransaction();
        try {
            // get amount due already in the system
            $old_amount_due = Transaction::where('id', $transaction_id)->first()->amount_due;

            $amount_difference = $old_amount_due - $new_amount_due;

            $student = StudentsAdmissions::where('id', $student_uuid)->first();

            $student->update([
                'total_bill_amount' => $student->total_bill_amount - $amount_difference,
                'current_bill_amount' => $student->current_bill_amount - $amount_difference
            ]);

            Transaction::where('id', $transaction_id)->update([
                "amount_due" => $new_amount_due
            ]);

            DB::commit();
            flash()->option('timeout', 5000)->addSuccess('Transaction Updated successfully!');
            return redirect()->route('admin_student_transactions');

        } catch (\Exception $th) {
            DB::rollBack();
            flash()->option('timeout', 10000)->addError('Error!' . $th->getMessage());
            return redirect()->back();
        }
    }

    // delete transaction data
    public function delete_transaction_data(Request $request)
    {
        $student_uuid = $request->student_uuid;
        $transaction_id = $request->transaction_id;

        DB::beginTransaction();
        try {
            // get amount due already in the system
            $old_amount_due = Transaction::where('id', $transaction_id)->first()->amount_due;

            $student = StudentsAdmissions::where('id', $student_uuid)->first();

            $student->update([
                'total_bill_amount' => $student->total_bill_amount - $old_amount_due,
                'current_bill_amount' => $student->current_bill_amount - $old_amount_due
            ]);

            Transaction::where('id', $transaction_id)->delete();

            DB::commit();
            flash()->option('timeout', 5000)->success('Transaction Deleted successfully!');
            return redirect()->route('admin_student_transactions');
        } catch (\Exception $th) {
            DB::rollBack();
            flash()->option('timeout', 5000)->addError('Error!' . $th->getMessage());
            return redirect()->back();
        }
    }

}
