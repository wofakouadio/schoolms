<?php

namespace App\Http\Controllers\Teacher\Level;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\ClassAssessmentTotalScoreRecord;
use App\Models\AssignSubjectToLevel;
use App\Models\ClassAssessment;
use App\Models\ClassAssessmentSettings;
use App\Models\ClassAssessmentTotalScoreRecord;
use App\Models\Level;
use App\Models\StudentsAdmissions;
use App\Models\Subject;
use App\Models\SubjectsToTeacher;
use App\Models\Term;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolAssessmentPercentageSettings;

class LevelAssessmentController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        $schoolAssessmentSettings = SchoolAssessmentPercentageSettings();
        $classAssessmentPercentage = $schoolAssessmentSettings->getData()->class_percentage;
        $AssessmentRecords = ClassAssessmentTotalScoreRecord::with('student', 'level', 'term', 'academicYear', 'subject')
            ->where('school_id', Auth::guard('teacher')->user()->school_id)->orderBy('created_at', 'desc')->get();
        $TeacherAssignedLevels = SubjectsToTeacher::with('level')->where([
            'school_id' => Auth::guard('teacher')->user()->school_id,
            'teacher_id' => Auth::guard('teacher')->user()->id,
            ])->distinct()->get('level_id');
        return view("teacher.dashboard.assessment.level.index", compact('schoolTerm', 'classAssessmentPercentage', 'AssessmentRecords', 'TeacherAssignedLevels'));
    }

    public function getSubjectsBasedOnLevel(Request $request)
    {
        $data = AssignSubjectToLevel::with('subject')
            ->where(['level_id' => $request->level_id, 'school_id' => Auth::guard('teacher')->user()->school_id])
            ->get();
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'teacher_term' => 'required',
            'teacher_level' => 'required',
            'teacher_student' => 'required',
            'teacher_subject' => 'required'
        ]);
        $school_id = Auth::guard('teacher')->user()->school_id;

        $termData = Term::with('academic_year')
            ->where(['id' => $request->teacher_term, 'school_id' => $school_id, 'is_active' => 1])
            ->first();

        $levelData = Level::where(['id' => $request->teacher_level, 'school_id' => $school_id])
            ->first();

        $studentData = StudentsAdmissions::with('level')
            ->where('id', $request->teacher_student)
            ->where("school_id", Auth::guard('teacher')->user()->school_id)
            ->where('admission_status', 1)
            ->first();

        $subjectData = Subject::where(['id' => $request->teacher_subject, 'school_id' => $school_id])
            ->first();

        $data = [
            'term' => $termData,
            'level' => $levelData,
            'student' => $studentData,
            'subject' => $subjectData
        ];

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $classAssessmentPercentage = $SchoolAssessmentPercentageSettings->getData()->class_percentage;
        $request->validate([
            'teacher_score' => 'required|min:0|max:10|numeric'
        ]);
        $student_id = $request->teacher_studentId;
        $term_id = $request->teacher_term_id;
        $level_id = $request->teacher_level_id;
        $subject_id = $request->teacher_subject_id;
        $academic_year_id = $request->teacher_academic_year_id;
        $branch_id = $request->teacher_branch_id;
        $score = $request->teacher_score;
        $school_id = Auth::guard('teacher')->user()->school_id;

        DB::beginTransaction();

        try {

            //get class assessment size
            $classAssessmentSettings = ClassAssessmentSettings::where(['school_id' => $school_id, 'term_id' =>
                $term_id, 'academic_year_id' => $academic_year_id])->first();

            //check if size was inputted. else use the default class assessment size from the env file
            if(!empty($classAssessmentSettings)) {
                $classSize = $classAssessmentSettings->class_assessment_size;
            } else {
                $classSize = config('assessment-settings.class_assessment_size');
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

            // dd($chkClassAssessmentRecorded);

            $overallTotalClassScore = $classSize * 10;
            $class_percentage = $classAssessmentPercentage;
            // dd($overallTotalClassScore, $class_percentage);

            // check if total count of class assessment recorded is less than or greater than class size
            // if($chkClassAssessmentRecorded - 1 <= $classSize){

             if($chkClassAssessmentRecorded == $classSize) {
                $data = [
                    'status' => 201,
                    'msg' => 'You have reached the maximum Class Assessment Record for the selected student and subject.'
                ];
            }else {
                // total count of class assessment recorded is less than class size
                // then check if total sum of class assessment records has value
                $chkClassAssessmentTotalRecords = ClassAssessmentTotalScoreRecord::where([
                    'student_id' => $student_id,
                    'term_id' => $term_id,
                    'level_id' => $level_id,
                    'academic_year_id' => $academic_year_id,
                    'subject_id' => $subject_id,
                    'school_id' => $school_id,
                    'branch_id' => $branch_id
                ])->first();
                // if total sum of class assessment records is no value
                // then create new record
                if(empty($chkClassAssessmentTotalRecords)) {
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

                    $percentageScore = ($score / $overallTotalClassScore) * $class_percentage;

                    ClassAssessmentTotalScoreRecord::create([
                        'student_id' => $student_id,
                        'term_id' => $term_id,
                        'level_id' => $level_id,
                        'academic_year_id' => $academic_year_id,
                        'subject_id' => $subject_id,
                        'score' => $score,
                        'percentage' => $percentageScore,
                        'school_id' => $school_id,
                        'branch_id' => $branch_id
                    ]);
                } else {
                    $lastScoreRecorded = $chkClassAssessmentTotalRecords->score;
                    $newScore = $lastScoreRecorded + $score;
                    $percentageScore = ($newScore / $overallTotalClassScore) * $class_percentage;

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
                    ClassAssessmentTotalScoreRecord::where([
//                        'id' => $newRecord->id,
                        'student_id' => $student_id,
                        'term_id' => $term_id,
                        'level_id' => $level_id,
                        'academic_year_id' => $academic_year_id,
                        'subject_id' => $subject_id,
                        'school_id' => $school_id,
                        'branch_id' => $branch_id
                    ])->update(['score' => $newScore, 'percentage' => $percentageScore]);
                }
                DB::commit();
                $data = [
                    'status' => 200,
                    'msg' => 'Class Assessment recorded successfully'
                ];
            }

        } catch(\Exception $th) {
            DB::rollBack();
            $data = [
                'status' => 201,
                'msg' => 'Something went wrong. Details: ' .$th->getMessage()
            ];
        }
        return response()->json($data);
    }

    public function edit(Request $request)
    {
        $data = ClassAssessment::with('student', 'level', 'term', 'academicYear', 'subject')
            ->where('id', $request->id)->first();
        return response()->json($data);
    }

    public function update(Request $request)
    {
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
            return redirect()->route('teacher_level_assessment');
        } catch(\Exception $th) {
            DB::rollBack();
            return back()->withErrors('Something went wrong. Details : ' . $th->getMessage());
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            ClassAssessment::where('id', $request->level_assessment_id)->delete();
            DB::commit();
            Alert::success('Success', 'Class Assessment deleted successfully.');
            return redirect()->route('teacher_level_assessment');
        } catch(\Exception $th) {
            DB::rollBack();
            return back()->withErrors('Something went wrong. Details : ' . $th->getMessage());
        }
    }

    // public function teacher_levels()
    // {
    //     // dd(true);
    //     $TeacherAssignedLevels = SubjectsToTeacher::with('level')->where([
    //         'school_id' => Auth::guard('teacher')->user()->school_id,
    //         'teacher_id' => Auth::guard('teacher')->user()->id,
    //         ])->distinct()->get('level_id');
    //     return response()->json($TeacherAssignedLevels);
    // }

    // get subjects based on level
    public function getTeacherLevelsBySchoolId(Request $request)
    {
        $data = AssignSubjectToLevel::with('subject')
            ->where(['level_id' => $request->level_id, 'school_id' => Auth::guard('teacher')->user()->school_id])
            ->get();
        return response()->json($data);
    }
}
