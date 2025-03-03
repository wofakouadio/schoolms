<?php

namespace App\Http\Controllers\Admin\Assessment\Settings;

use App\Http\Controllers\Controller;
use App\Models\AssessmentSettings;
use App\Models\Category;
use App\Models\Department;
use App\Models\GradingSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use function App\Helpers\TermAndAcademicYear;

class AssessmentSettingsController extends Controller
{
    //index for assessment page
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        // get assessment list
        $AssessmentSettings = AssessmentSettings::with('school_academic_year')->where('school_id', Auth::guard('admin')->user()
            ->school_id)
            ->orderBy('created_at', 'desc')
            ->get();
        // get grading systems list
        $GradingSystems = GradingSystem::with('school_academic_year', 'school_department')->where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            'academic_year' => $schoolTerm->term_academic_year
        ])->orderBy('created_at', 'desc')
            ->get();
        // get all departments
        $SchoolDepartments = Department::where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            'is_active' => 1
        ])->get();

        return view('admin.dashboard.assessment.settings.index', compact('schoolTerm', 'AssessmentSettings', 'GradingSystems', 'SchoolDepartments'));
    }

    // new assessment
    public function new_assessment_setup(Request $request){
        $request->validate([
            'class_percentage' => 'required|numeric',
            'mid_term_percentage' => 'required|numeric',
            'exam_percentage' => 'required|numeric',
        ]);

        $totalPercentage = $request->class_percentage + $request->mid_term_percentage + $request->exam_percentage;

        if($totalPercentage > 100){
            return back()->withErrors(['error' => 'Please make sure all percentages entered add up to 100%']);
        }else{

            DB::beginTransaction();
            try {
                //check if assessment exists for the current academic year and is active
                $chkClassAssessment = AssessmentSettings::where(['is_active' => 1, 'school_id' => Auth::guard('admin')
                    ->user()->school_id, 'academic_year' => $request->academic_year])->first();

                if(!$chkClassAssessment){
                    AssessmentSettings::create([
                        'academic_year' => $request->academic_year,
                        'class_percentage' => $request->class_percentage,
                        'mid_term_percentage' => $request->mid_term_percentage,
                        'exam_percentage' => $request->exam_percentage,
                        'school_id' => Auth::guard('admin')->user()->school_id
                    ]);
                    DB::commit();
                    flash()->option('timeout', 5000)->addSuccess('Percentage Assessment created successfully', 'Success');
                    // Alert::success('Success', 'Percentage Assessment created successfully');
                    return redirect()->route('admin_assessment_settings');
                }else{

                    return back()->withErrors(['error' => 'You cannot create two assessments for the same academic year']);
                }

            }catch(\Exception $th){
                DB::rollBack();
                return back()->withErrors(['error' => 'Something went wrong. Details : '.$th->getMessage()]);
            }

        }
    }

    //get assessment data
    public function edit_assessment_setup(Request $request){
        $data = AssessmentSettings::with('school_academic_year')->where('id', $request->assessment_id)->first();
        return response()->json($data);
    }

    //update assessment
    public function update_assessment_setup(Request $request){
        $request->validate([
            'assessment_status' => 'required',
        ]);
        DB::beginTransaction();
        try {
            AssessmentSettings::where('id', $request->assessment_id)->update([
                'is_active' => $request->assessment_status
            ]);
            DB::commit();
            flash()->option('timeout', 5000)->addSuccess('Percentage Assessment Status updated successfully', 'Success');
            return redirect()->route('admin_assessment_settings');

        }catch(\Exception $th){
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Details : '.$th->getMessage()]);
        }
    }

    // delete assessment
    public function delete_assessment_setup(Request $request){
        DB::beginTransaction();
        try {
            AssessmentSettings::where('id', $request->assessment_id)->delete();
            DB::commit();
            flash()->option('timeout', 5000)->addSuccess( 'Percentage Assessment Status deleted successfully', 'Success');
            return redirect()->route('admin_assessment_settings');

        }catch(\Exception $th){
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Details : '.$th->getMessage()]);
        }
    }

    // new grading system
    public function new_grading_system(Request $request){
        $request->validate([
            'score_from' => 'required|numeric|min:0|max:100',
            'score_to' => 'required|numeric|min:0|max:100',
            'grade' => 'required|uppercase|',
            'level_of_proficiency' => 'required|string'
        ]);
        DB::beginTransaction();
        try {
            $chkGradingSystem = GradingSystem::where([
                'school_id' => Auth::guard('admin')->user()->school_id,
                'score_from' => $request->score_from,
                'score_to' => $request->score_to,
                'grade' => $request->grade,
                'department_applicable_to' => $request->department_applicable_to,
                'is_active' => 1
            ])->first();
            if(!$chkGradingSystem){
                GradingSystem::create([
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'score_from' => $request->score_from,
                    'score_to' => $request->score_to,
                    'grade' => strtoupper($request->grade),
                    'academic_year' => $request->academic_year,
                    'department_applicable_to' => $request->department_applicable_to,
                    'level_of_proficiency' => strtoupper($request->level_of_proficiency)
                ]);
                DB::commit();
                flash()->option('timeout', 5000)->addSuccess( 'Grading System created successfully', 'Success');
                return redirect()->route('admin_assessment_settings');
            }else{
                return back()->withErrors(['error' => 'You cannot create two same grading systems for the same academic year']);
            }
        }catch(\Exception $th){
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Details : ' . $th->getMessage()]);
        }
    }

    public function edit_grading_system(Request $request){
        $data = GradingSystem::with('school_academic_year')->where('id', $request->grading_system_id)->first();
        return response()->json($data);
    }

    public function update_grading_system(Request $request){
        $request->validate([
            'score_from' => 'required|numeric|min:0|max:100',
            'score_to' => 'required|numeric|min:0|max:100',
            'grade' => 'required|uppercase|',
            'level_of_proficiency' => 'required|string'
        ]);
        DB::beginTransaction();
        try {
            GradingSystem::where('id', $request->grading_system_id)->update([
                'score_from' => $request->score_from,
                'score_to' => $request->score_to,
                'grade' => strtoupper($request->grade),
                'department_applicable_to' => $request->department_applicable_to,
                'level_of_proficiency' => strtoupper($request->level_of_proficiency),
                'is_active' => $request->grading_system_status
            ]);
            DB::commit();
            flash()->option('timeout', 5000)->addSuccess( 'Grading System updated successfully', 'Success');
            return redirect()->route('admin_assessment_settings');
        }catch(\Exception $th){
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Details : ' . $th->getMessage()]);
        }
    }

    public function delete_grading_system(Request $request){
        DB::beginTransaction();
        try {
            GradingSystem::where('id', $request->grading_system_id)->delete();
            DB::commit();
            flash()->option('timeout', 5000)->addSuccess('Grading System deleted successfully','Success');
            return redirect()->route('admin_assessment_settings');
        }catch(\Exception $th){
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Details : ' . $th->getMessage()]);
        }
    }
}
