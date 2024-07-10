<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
Use App\Models\AdmissionFee;
use App\Models\Branch;
use App\Models\Department;
use RealRashid\SweetAlert\Facades\Alert;

use function App\Helpers\TermAndAcademicYear;

class AdmissionFeeController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        $admissionFees = AdmissionFee::with('academic_year', 'department', 'branch')->where(['school_id' => Auth::guard('admin')->user()->school_id,  'is_active' => 1])->get();
        $academicYears = AcademicYear::where(['school_id' => Auth::guard('admin')->user()->school_id])->get();
        $departments = Department::where(['school_id' => Auth::guard('admin')->user()->school_id,  'is_active' => 1])->orderBy('name', 'asc')->get();
        $branches = Branch::where(['school_id' => Auth::guard('admin')->user()->school_id,  'is_active' => 1])->get();
        return view("admin.dashboard.finance.admission-fees.index", compact("schoolTerm", "admissionFees", "academicYears", "departments", "branches"));
    }

    public function store(Request $request){
        $request->validate([
            'academic_year' => 'required',
            'branch' => 'required',
            'department' => 'required',
            'amount' => 'required|numeric'
        ]);

        $school_id = Auth::guard('admin')->user()->school_id;

        $checkAdmissionFee = AdmissionFee::where([
            'school_id' => $school_id,
            'academic_year_id' => $request->academic_year,
            'branch_id' => $request->branch,
            'department_id' => $request->department,
            'amount' => $request->amount
        ])->exists();

        if($checkAdmissionFee){
            $response = [
                'status' => 201,
                'msg' => 'Admission Fee already exists'
            ];
        }else{
            try{
                AdmissionFee::create([
                    'school_id' => $school_id,
                    'academic_year_id' => $request->academic_year,
                    'branch_id' => $request->branch,
                    'department_id' => $request->department,
                    'amount' => $request->amount
                ]);
                $response = [
                    'status' => 200,
                    'msg' => 'Admission Fee created successfully'
                ];
            }catch(\Exception $e){
                $response = [
                    'status' => 201,
                    'msg' => 'Something went wrong. Error: ' . $e->getMessage()
                ];
            }
        }
        return response()->json($response);
    }

    public function edit(Request $request){
        $data = AdmissionFee::where('id', $request->id)->first();
        return response()->json($data);
    }

    public function update(Request $request){
        $request->validate([
            'academic_year' => 'required',
            'branch' => 'required',
            'department' => 'required',
            'amount' => 'required|numeric',
            'status' => 'required'
        ]);
        try{
            AdmissionFee::where('id', $request->admission_fee_id)->update([
                'academic_year_id' => $request->academic_year,
                'branch_id' => $request->branch,
                'department_id' => $request->department,
                'amount' => $request->amount,
                'is_active' => $request->status
            ]);
            $response = [
                'status' => 200,
                'msg' => 'Admission Fee updated successfully'
            ];
        }catch(\Exception $e){
            $response = [
                'status' => 201,
                'msg' => 'Something went wrong. Error: ' . $e->getMessage()
            ];
        }
        return response()->json($response);
    }

    public function delete(Request $request){
        try{
            AdmissionFee::where('id', $request->admission_fee_id)->delete();
            $response = [
                'status' => 200,
                'msg' => 'Admission Fee deleted successfully'
            ];
        }catch(\Exception $e){
            $response = [
                'status' => 201,
                'msg' => 'Something went wrong. Error: ' . $e->getMessage()
            ];
        }
        return response()->json($response);
    }
}
