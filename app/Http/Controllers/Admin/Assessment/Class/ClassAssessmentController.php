<?php

namespace App\Http\Controllers\Admin\Assessment\Class;

use App\Http\Controllers\Controller;
use App\Models\AssessmentSettings;
use App\Models\AssignSubjectToLevel;
use App\Models\ClassAssessment;
use App\Models\ClassAssessmentSettings;
use App\Models\ClassAssessmentTotalScoreRecord;
use App\Models\Level;
use App\Models\StudentsAdmissions;
use App\Models\Subject;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use function App\Helpers\TermAndAcademicYear;

class ClassAssessmentController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        // $AssessmentRecords = ClassAssessment::with('student', 'level', 'term', 'academicYear', 'subject')
        //     ->where('school_id', Auth::guard('admin')->user()->school_id)->orderBy('created_at', 'desc')->get();
        $AssessmentRecords = ClassAssessmentTotalScoreRecord::with('student', 'level', 'term', 'academicYear', 'subject')
            ->where('school_id', Auth::guard('admin')->user()->school_id)->orderBy('created_at', 'desc')->get();

        return view('admin.dashboard.assessment.level.index', compact('schoolTerm', 'AssessmentRecords'));
    }

    public function getSubjectsBasedOnLevel(Request $request){
        $data = AssignSubjectToLevel::with('subject')
            ->where(['level_id'=>$request->level_id, 'school_id'=>Auth::guard('admin')->user()->school_id])
            ->get();
        return response()->json($data);
    }

    public function create(Request $request){
        $request->validate([
            'term' => 'required',
            'level' => 'required',
            'student' => 'required',
            'subject' => 'required'
        ]);
        $school_id = Auth::guard('admin')->user()->school_id;

        $termData = Term::with('academic_year')
            ->where(['id' => $request->term, 'school_id'=>$school_id, 'is_active' => 1])
            ->first();

        $levelData = Level::where(['id' => $request->level, 'school_id'=>$school_id])
            ->first();

        $studentData = StudentsAdmissions::with('level')
            ->where('id', $request->student)
            ->where("school_id", Auth::guard('admin')->user()->school_id)
            ->where('admission_status', 1)
            ->first();

        $subjectData = Subject::where(['id' => $request->subject, 'school_id'=>$school_id])
            ->first();

//        $classAssessmentSettings = ClassAssessmentSettings::where(['school_id'=>$school_id, 'term_id' =>
//            $request->term, 'academic_year_id' => $termData->term_academic_year])->first();
//
//        if(!empty($classAssessmentSettings)){
//            $classSize = $classAssessmentSettings->class_assessment_size;
//        }else{
//            $classSize = config('assessment-settings.class_assessment_size');
//        }

        $data = [
            'term' => $termData,
            'level' => $levelData,
            'student' => $studentData,
            'subject' => $subjectData,
//            'classSize' => $classSize,
//            'add_mid_term' => $classAssessmentSettings->add_mid_term,
        ];

        return response()->json($data);
    }

    public function store(Request $request){
        $request->validate([
            'score' => 'required|min:0|numeric'
        ]);
        $student_id = $request->studentId;
        $term_id = $request->term_id;
        $level_id = $request->level_id;
        $subject_id = $request->subject_id;
        $academic_year_id = $request->academic_year_id;
        $branch_id = $request->branch_id;
        $score = $request->score;
        $school_id = Auth::guard('admin')->user()->school_id;

        DB::beginTransaction();

        try {

            //get class assessment size
            $classAssessmentSettings = ClassAssessmentSettings::where(['school_id'=>$school_id, 'term_id' =>
                $term_id, 'academic_year_id' => $academic_year_id])->first();

            //check if size was inputted. else use the default class assessment size from the env file
            if(!empty($classAssessmentSettings)){
                if($classAssessmentSettings->add_mid_term == 'on'){
                    $classSize = $classAssessmentSettings->class_assessment_size - 1;
                }else{
                    $classSize = $classAssessmentSettings->class_assessment_size;
                }
            }else{
                if($classAssessmentSettings->add_mid_term == 'on'){
                    $classSize = config('assessment-settings.class_assessment_size') - 1;
                }else{
                    $classSize = config('assessment-settings.class_assessment_size');
                }
            }

            //let check if class assessment has been recorded
            $chkClassAssessmentRecorded = ClassAssessment::where([
                'student_id' => $student_id,
                'term_id' => $term_id,
                'level_id' => $level_id,
                'academic_year_id' => $academic_year_id,
                'subject_id' => $subject_id,
                'school_id' => $school_id,
                'branch_id' => $branch_id
            ])->count();

//            dd($classSize);

            if($chkClassAssessmentRecorded <= $classSize){
                $chkClassAssessmentTotalRecords = ClassAssessmentTotalScoreRecord::where([
                    'student_id' => $student_id,
                    'term_id' => $term_id,
                    'level_id' => $level_id,
                    'academic_year_id' => $academic_year_id,
                    'subject_id' => $subject_id,
                    'school_id' => $school_id,
                    'branch_id' => $branch_id
                ])->first();

                if(empty($chkClassAssessmentTotalRecords)){
                    ClassAssessment::create([
                        'student_id' => $student_id,
                        'term_id' => $term_id,
                        'level_id' => $level_id,
                        'academic_year_id' => $academic_year_id,
                        'subject_id' => $subject_id,
                        'score' => $score,
                        'school_id' => $school_id,
                        'branch_id' => $branch_id
                    ]);

                    ClassAssessmentTotalScoreRecord::create([
                        'student_id' => $student_id,
                        'term_id' => $term_id,
                        'level_id' => $level_id,
                        'academic_year_id' => $academic_year_id,
                        'subject_id' => $subject_id,
                        'score' => $score,
                        'school_id' => $school_id,
                        'branch_id' => $branch_id
                    ]);
                }else{
                    $lastScoreRecorded = $chkClassAssessmentTotalRecords->score;
                    $newScore = $lastScoreRecorded + $score;

                    $newRecord = ClassAssessment::create([
                        'student_id' => $student_id,
                        'term_id' => $term_id,
                        'level_id' => $level_id,
                        'academic_year_id' => $academic_year_id,
                        'subject_id' => $subject_id,
                        'score' => $score,
                        'school_id' => $school_id,
                        'branch_id' => $branch_id
                    ]);
                    ClassAssessmentTotalScoreRecord::where([
//                        'id' => $newRecord->id,
                        'student_id' => $student_id,
                        'term_id' => $term_id,
                        'level_id' => $level_id,
                        'academic_year_id' => $academic_year_id,
                        'subject_id' => $subject_id,
                        'school_id' => $school_id,
                        'branch_id' => $branch_id
                    ])->update(['score' => $newScore]);
                }
                DB::commit();
                $data = [
                    'status' => 200,
                    'msg' => 'Class Assessment recorded successfully'
                ];
            }else{
                $data = [
                    'status' => 201,
                    'msg' => 'You have reached the maximum Class Assessment Record for the selected student and subject.'
                ];
            }

        }catch(\Exception $th){
            DB::rollBack();
            $data = [
                'status' => 201,
                'msg' => 'Something went wrong. Details: ' .$th->getMessage()
            ];
        }
        return response()->json($data);
    }

    public function edit(Request $request){
        $data = ClassAssessment::with('student', 'level', 'term', 'academicYear', 'subject')
            ->where('id', $request->id)->first();
        return response()->json($data);
    }

    public function update(Request $request){
        $request->validate([
            'score' => 'required|min:0|numeric'
        ]);
        DB::beginTransaction();
        try {
            ClassAssessment::where('id', $request->level_assessment_id)->update([
                'score' => $request->score
            ]);
            DB::commit();
            Alert::success('Success', 'Class Assessment updated successfully.');
            return redirect()->route('admin_assessment_level');
        }catch(\Exception $th){
            DB::rollBack();
            return back()->withErrors('Something went wrong. Details : ' . $th->getMessage());
        }
    }

    public function delete(Request $request){
        DB::beginTransaction();
        try {
            ClassAssessment::where('id', $request->level_assessment_id)->delete();
            DB::commit();
            Alert::success('Success', 'Class Assessment deleted successfully.');
            return redirect()->route('admin_assessment_level');
        }catch(\Exception $th){
            DB::rollBack();
            return back()->withErrors('Something went wrong. Details : ' . $th->getMessage());
        }
    }
}
