<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Models\Bill;
use App\Models\Term;
use App\Models\Level;
use App\Models\School;
use App\Models\BillingLog;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\BillsBreakdown;
use App\Models\StudentsAdmissions;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\SchoolCurrency;
use function App\Helpers\TermAndAcademicYear;

class BillsController extends Controller
{
    //store bill
    public function store(Request $request)
    {
        $request->validate([
            'term' => 'required',
            'level' => 'required',
            'addMore.*.bill_amount' => 'required',
            'addMore.*.bill_description' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $bill_amount = 0;
            $bill_description = [];
            foreach ($request->addMore as $key => $value) {

                $bill_amount += $value['bill_amount'];
                $bill_description[] = [
                    'description' => $value['bill_description'],
                    'amount' => $value['bill_amount']
                ];
            }
            $academicYear = Term::select('term_academic_year')->where('id', $request->term)->first();
            $branch = Level::select('branch_id')->where('id', $request->level)->first();
            if ($request->is_for_academic_year == 1 ?? 0) {
                $is_for_academic_year = 1;
            } else {
                $is_for_academic_year = 0;
            }
            $bill = Bill::create([
                'bill_amount' => $bill_amount,
                //                'bill_description' => $bill_description,
                'term_id' => $request->term,
                'academic_year' => $academicYear->term_academic_year,
                'is_for_academic_year' => $is_for_academic_year,
                'level_id' => $request->level,
                'school_id' => Auth::guard('admin')->user()->school_id,
                'branch_id' => $branch->branch_id
            ]);
            foreach ($bill_description as $key => $value) {
                BillsBreakdown::create([
                    'item' => $value['description'],
                    'amount' => $value['amount'],
                    'bill_id' => $bill->id,
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'branch_id' => $branch->branch_id
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Bill created successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //edit
    public function edit(Request $request)
    {
        $data = Bill::with('billsbreakdown')->where('id', $request->bill_id)->first();
        return response()->json($data);
    }

    //update
    public function update(Request $request)
    {
        $request->validate([
            'term' => 'required',
            'level' => 'required',
            'addMore.*.bill_amount' => 'required',
            'addMore.*.bill_description' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $bill_amount = 0;
            $bill_description = [];
            foreach ($request->addMore as $key => $value) {

                $bill_amount += $value['bill_amount'];
                $bill_description[] = [
                    'id' => $value['billbreakdown_id'],
                    'description' => $value['bill_description'],
                    'amount' => $value['bill_amount']
                ];
            }
            Bill::where('id', $request->bill_id)->update([
                'bill_amount' => $bill_amount,
                //                'bill_description' => $bill_description,
                'term_id' => $request->term,
                'level_id' => $request->level,
                'is_active' => $request->bill_is_active,
            ]);
            foreach ($bill_description as $key => $value) {
                if (empty($value['id'])) {
                    BillsBreakdown::create([
                        'item' => $value['description'],
                        'amount' => $value['amount'],
                        'bill_id' => $request->bill_id,
                        'school_id' => Auth::guard('admin')->user()->school_id,
                        'branch_id' => $request->branch_id
                    ]);
                } else {
                    BillsBreakdown::where('id', $value['id'])->update([
                        'item' => $value['description'],
                        'amount' => $value['amount'],
                        'bill_id' => $request->bill_id,
                        'school_id' => Auth::guard('admin')->user()->school_id,
                        'branch_id' => $request->branch_id
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Bill updated successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //delete
    public function delete(Request $request)
    {

        DB::beginTransaction();
        try {
            Bill::where('id', $request->bill_id)->delete();
            BillsBreakdown::where('bill_id', $request->bill_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Bill deleted successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    // student bill
    // get student data for new billing
    public function get_student_data(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'student_id' => 'required'
        ]);
        $schoolTerm = TermAndAcademicYear();
        $schoolCurrency = SchoolCurrency();
        $studentData = null;

        $student_id = $request->student_id;

        $school_id = Auth::guard('admin')->user()->school_id;

        $studentData = StudentsAdmissions::with('level', 'house', 'category')->where(['id' => $student_id, 'school_id' => $school_id])->first();

        $studentsList = StudentsAdmissions::with('level', 'house', 'category')
        ->where([
            'school_id' => $school_id,
            'admission_status' => 1
            ])->orderBy('student_id', 'asc')
        ->get()->groupBy('category.category_name');

        // dd($studentData);

        return view('admin.dashboard.finance.student-bill.index', compact('schoolTerm', 'schoolCurrency', 'studentData', 'studentsList'));
    }

    public function new_student_bill(Request $request)
    {
        $request->validate([
            'bill_description' => 'required',
            'bill_amount' => 'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $student = StudentsAdmissions::where('id', $request->student_id)->first();
            Transaction::create([
                "academic_year_id" => $request->academic_year_id,
                "amount_due" => $request->bill_amount,
                "payment_status" => 'awaiting_payment',
                "student_id" => $request->student_id,
                "level_id" => $request->level_id,
                "description" => ucfirst($request->bill_description),
                "items" => ucfirst($request->bill_description)
            ]);
            $student->update([
                'total_bill_amount' => $student->total_bill_amount + $request->bill_amount,
                'current_bill_amount' => $student->current_bill_amount + $request->bill_amount
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Bill added successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $e->getMessage()
            ]);
        }
    }
}
