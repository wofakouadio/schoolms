<?php

namespace App\Http\Controllers\Admin\Assessment\Settings;

use App\Http\Controllers\Controller;
use App\Models\ClassAssessmentSettings;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

use function App\Helpers\TermAndAcademicYear;

class ClassAssessmentSizeController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        $ClassAssessmentSettings = ClassAssessmentSettings::with('schoolTerm', 'schoolAcademicYear')
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.dashboard.class-assessment-size.index', compact('schoolTerm', 'ClassAssessmentSettings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'term' => 'required'
        ]);
        DB::beginTransaction();
        try {
            //get academic year based on term id
            $getAcademicYear = Term::where([
                'id' => $request->term,
                'school_id' => Auth::guard('admin')->user()->school_id
            ])->first();

            //check if data already exists
            $chkData = ClassAssessmentSettings::where([
                'term_id' => $request->term,
                'school_id' => Auth::guard('admin')->user()->school_id
            ])->get();

            if($chkData->count() == 0) {
                ClassAssessmentSettings::create([
                    'term_id' => $request->term,
                    'academic_year_id' => $getAcademicYear->term_academic_year,
                    'class_assessment_size' => $request->assessment_size,
                    'is_active' => 0,
                    'school_id' => Auth::guard('admin')->user()->school_id
                ]);
                DB::commit();
                Alert::success('Success', 'Class Assessment Size created successfully');
                return redirect()->route('admin_class_assessment_size');
            } else {
                return back()->withErrors('Class Assessment Settings Already Exist');
            }
        } catch (\Exception $th) {
            DB::rollBack();
            return back()->withErrors('Something went wrong. Details: '.$th->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $data = ClassAssessmentSettings::with('schoolTerm', 'schoolAcademicYear')
            ->where(['school_id' => Auth::guard('admin')->user()->school_id, 'id' => $request->id])
            ->first();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'term' => 'required'
        ]);
        DB::beginTransaction();
        try {
            //get academic year based on term id
            $getAcademicYear = Term::where([
                'id' => $request->term,
                'school_id' => Auth::guard('admin')->user()->school_id
            ])->first();

            ClassAssessmentSettings::where('id', $request->id)->update([
                'term_id' => $request->term,
                'academic_year_id' => $getAcademicYear->term_academic_year,
                'class_assessment_size' => $request->assessment_size
            ]);
            DB::commit();
            Alert::success('Success', 'Class Assessment Size updated successfully');
            return redirect()->route('admin_class_assessment_size');
        } catch (\Exception $th) {
            DB::rollBack();
            return back()->withErrors('Something went wrong. Details: '.$th->getMessage());
        }
    }

    public function update_status(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->is_active == 0) {
                ClassAssessmentSettings::where('id', $request->id)->update([
                    'is_active' => $request->is_active
                ]);
                DB::commit();
                Alert::success('Success', 'Class Assessment Size Status updated successfully');
                return redirect()->route('admin_class_assessment_size');
            }
            //check if class is already active
            $chkActive = ClassAssessmentSettings::where([
                'school_id' => Auth::guard('admin')->user()->school_id,
                'is_active' => 1
            ])->get();

            if($chkActive->count() > 0) {
                return back()->withErrors('Disable the active Class Assessment Size before activating another one');
            } else {
                ClassAssessmentSettings::where('id', $request->id)->update([
                    'is_active' => $request->is_active
                ]);
                DB::commit();
                Alert::success('Success', 'Class Assessment Size Status updated successfully');
                return redirect()->route('admin_class_assessment_size');
            }
        } catch (\Exception $th) {
            DB::rollBack();
            return back()->withErrors('Something went wrong. Details: '.$th->getMessage());
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {

            ClassAssessmentSettings::where('id', $request->id)->delete();
            DB::commit();
            Alert::success('Success', 'Class Assessment Size deleted successfully');
            return redirect()->route('admin_class_assessment_size');
        } catch (\Exception $th) {
            DB::rollBack();
            return back()->withErrors('Something went wrong. Details: '.$th->getMessage());
        }
    }
}
