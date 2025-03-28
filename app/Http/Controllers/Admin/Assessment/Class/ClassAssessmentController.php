<?php

namespace App\Http\Controllers\Admin\Assessment\Class;

use App\Http\Controllers\Controller;
use App\Models\AssessmentSettings;
use App\Models\AssignSubjectToLevel;
use App\Models\ClassAssessment;
use App\Models\ClassAssessmentSettings;
use App\Models\ClassAssessmentTotalScoreRecord;
use App\Models\Level;
use App\Models\StudentsAcademicRecordsSummary;
use App\Models\StudentsAcademicRecords;
use App\Models\StudentsAdmissions;
use App\Models\Subject;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolAssessmentPercentageSettings;

class ClassAssessmentController extends Controller
{
    //index
    public function index()
    {
        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $classAssessmentPercentage = $SchoolAssessmentPercentageSettings->getData()->class_percentage;
        $schoolTerm = TermAndAcademicYear();
        // dd($schoolTerm);
        // dd($schoolTerm->id);
        // dd($classAssessmentPercentage);
        // $AssessmentRecords = ClassAssessment::with('student', 'level', 'term', 'academicYear', 'subject')
        //     ->where('school_id', Auth::guard('admin')->user()->school_id)->orderBy('created_at', 'desc')->get();
        // $AssessmentRecords = ClassAssessmentTotalScoreRecord::with('student', 'level', 'term', 'academicYear', 'subject')
        //     ->where('school_id', Auth::guard('admin')->user()->school_id)->orderBy('created_at', 'desc')->get();
        // $AssessmentRecords = StudentsAcademicRecords::with('student', 'level', 'term', 'academic_year', 'subject')
        //     ->where([
        //         'school_id' => Auth::guard('admin')->user()->school_id,
        //         'term_id' => $schoolTerm->id,
        //         'academic_year_id' => $schoolTerm->term_academic_year
        //     ])->orderBy('created_at', 'desc')->get();
        $AssessmentRecords = StudentsAcademicRecordsSummary::with('student', 'level', 'term', 'academic_year')
            ->where([
                'school_id' => Auth::guard('admin')->user()->school_id,
                'term_id' => $schoolTerm->id,
                'academic_year_id' => $schoolTerm->term_academic_year
            ])->orderBy('created_at', 'desc')->get();
        // dd($AssessmentRecords);


        return view('admin.dashboard.assessment.level.index', compact('schoolTerm', 'AssessmentRecords', 'classAssessmentPercentage'));
    }

    public function getSubjectsBasedOnLevel(Request $request)
    {
        $data = AssignSubjectToLevel::with('subject')
            ->where(['level_id' => $request->level_id, 'school_id' => Auth::guard('admin')->user()->school_id])
            ->get();
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'term' => 'required',
            'level' => 'required',
            'student' => 'required',
            'subject' => 'required'
        ]);

        if ($request->student == "all") {
            $data = [
                'status' => 201,
                'msg' => 'Please select a student'
            ];
        } else {

            $school_id = Auth::guard('admin')->user()->school_id;

            $termData = Term::with('academic_year')
                ->where([
                    'id' => $request->term,
                    'school_id' => $school_id,
                    'is_active' => 1
                ])->first();

            $levelData = Level::where([
                'id' => $request->level,
                'school_id' => $school_id
            ])->first();

            $studentData = StudentsAdmissions::with('level')
                ->where([
                    'id' => $request->student,
                    "school_id" => Auth::guard('admin')->user()->school_id,
                    'admission_status' => 1
                ])->first();

            $subjectData = Subject::where([
                'id' => $request->subject,
                'school_id' => $school_id
            ])->first();

            $classAssessmentSettings = ClassAssessmentSettings::where([
                'school_id' => $school_id,
                'term_id' => $request->term,
                'academic_year_id' => $termData->term_academic_year
            ])->first();

            if (!empty($classAssessmentSettings)) {
                $classSize = $classAssessmentSettings->class_assessment_size;
            } else {
                $classSize = config('assessment-settings.class_assessment_size');
            }

            $data = [
                'term' => $termData,
                'level' => $levelData,
                'student' => $studentData,
                'subject' => $subjectData
            ];
        }
        return response()->json($data);
    }

    //store student class assessment
    public function store(Request $request)
    {
        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $classAssessmentPercentage = $SchoolAssessmentPercentageSettings->getData()->class_percentage;
        $request->validate([
            'score' => 'required|min:0|max:10|numeric'
        ]);
        $student_id = $request->studentId;
        $term_id = $request->term_id;
        $level_id = $request->level_id;
        $subject_id = $request->subject_id;
        $academic_year_id = $request->academic_year_id;
        $branch_id = $request->branch_id;
        $score = $request->score;
        $school_id = Auth::guard('admin')->user()->school_id;
        $total_score = 0.0;
        $total_percentage = 0.0;

        DB::beginTransaction();

        // put the whole process into try catch for error handling
        try {
            //get class assessment size
            $classAssessmentSettings = ClassAssessmentSettings::where([
                'school_id' => $school_id,
                'term_id' => $term_id,
                'academic_year_id' => $academic_year_id
            ])->first();

            //check if size was inputted. else use the default class assessment size from the env file
            if (!empty($classAssessmentSettings)) {
                $classSize = $classAssessmentSettings->class_assessment_size;
            } else {
                $classSize = config('assessment-settings.class_assessment_size');
            }

            //let get the total class assessment recorded
            $ClassAssessmentRecorded = ClassAssessment::where([
                'student_id' => $student_id,
                'term_id' => $term_id,
                'level_id' => $level_id,
                'academic_year_id' => $academic_year_id,
                'subject_id' => $subject_id,
                'school_id' => $school_id,
                'branch_id' => $branch_id
            ])->get();
            // dd($ClassAssessmentRecorded->count());

            // check if total count of class assessment recorded is less than or greater than class size
            if ($ClassAssessmentRecorded->count() != $classSize) {
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

                $data = [
                    'status' => 200,
                    'msg' => 'Class Assessment recorded successfully'
                ];

            } else {

                foreach ($ClassAssessmentRecorded as $record) {
                    $total_score += $record->score;
                }
                $total_percentage = ($total_score / ($classSize * 10)) * 100;
                $totalSubjectPercentage = ($total_score / ($classSize * 10)) * $classAssessmentPercentage;

                $classAssessmentTotalRecord = ClassAssessmentTotalScoreRecord::create([
                    'student_id' => $student_id,
                    'term_id' => $term_id,
                    'level_id' => $level_id,
                    'academic_year_id' => $academic_year_id,
                    'subject_id' => $subject_id,
                    'score' => $total_score,
                    'percentage' => $total_percentage,
                    'school_id' => $school_id,
                    'branch_id' => $branch_id
                ]);

                StudentsAcademicRecords::create([
                    'student_id' => $student_id,
                    'academic_year_id' => $academic_year_id,
                    'term_id' => $term_id,
                    'level_id' => $level_id,
                    'subject_id' => $subject_id,
                    'class_assessment_id' => $classAssessmentTotalRecord->id,
                    'class_assessment_raw_score' => $total_score,
                    'class_assessment_percentage' => $totalSubjectPercentage,
                    'total_raw_score' => $total_score,
                    'total_percentage_score' => $totalSubjectPercentage,
                    'school_id' => $school_id,
                    'branch_id' => $branch_id
                ]);

                // let get count of subjects assigned to level
                $AssignedSubjectsToLevel = AssignSubjectToLevel::with('subject')->where([
                    'level_id' => $level_id,
                    'school_id' => $school_id
                ])->get();

                // dd($AssignedSubjectsToLevel->count());

                $OverallTotalPercentage = ($total_score / ($classSize * $AssignedSubjectsToLevel->count() * 10)) * $classAssessmentPercentage;

                // check if record exists in the student academic records summary
                $chkStudentAcademicRecordsSummary = StudentsAcademicRecordsSummary::where([
                    'student_id' => $student_id,
                    'term_id' => $term_id,
                    'level_id' => $level_id,
                    'academic_year_id' => $academic_year_id,
                    'school_id' => $school_id,
                    'branch_id' => $branch_id
                ])->first();

                if (empty($chkStudentAcademicRecordsSummary)) {
                    StudentsAcademicRecordsSummary::create([
                        'student_id' => $student_id,
                        'academic_year_id' => $academic_year_id,
                        'term_id' => $term_id,
                        'level_id' => $level_id,
                        'class_total_score' => $total_score,
                        'class_total_score_percentage' => $OverallTotalPercentage,
                        'total_score' => $total_score,
                        'total_score_percentage' => $OverallTotalPercentage,
                        'school_id' => $school_id,
                        'branch_id' => $branch_id
                    ]);
                } else {
                    $old_cas = $chkStudentAcademicRecordsSummary->class_total_score;
                    $new_cas = $old_cas + $total_score;
                    $new_OverallTotalPercentage = ($new_cas / ($classSize * $AssignedSubjectsToLevel->count() * 10)) * $classAssessmentPercentage;

                    StudentsAcademicRecordsSummary::where([
                        'student_id' => $student_id,
                        'academic_year_id' => $academic_year_id,
                        'term_id' => $term_id,
                        'level_id' => $level_id,
                        'school_id' => $school_id,
                        'branch_id' => $branch_id
                    ])->update([
                        'class_total_score' => $new_cas,
                        'class_total_score_percentage' => $new_OverallTotalPercentage,
                        'total_score' => $new_cas,
                        'total_score_percentage' => $new_OverallTotalPercentage
                    ]);
                }

                $data = [
                    'status' => 201,
                    'msg' => 'You have reached the maximum Class Assessment Record for the selected student and subject.'
                ];
            }
            DB::commit();
        } catch (\Exception $th) {
            DB::rollBack();
            $data = [
                'status' => 201,
                'msg' => 'Something went wrong. Details: ' . $th->getMessage()
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
            flash()->addSuccess( 'Class Assessment updated successfully.');
            return redirect()->route('admin_assessment_level');
        } catch (\Exception $th) {
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
            flash()->addSuccess( 'Class Assessment deleted successfully.');
            return redirect()->route('admin_assessment_level');
        } catch (\Exception $th) {
            DB::rollBack();
            return back()->withErrors('Something went wrong. Details : ' . $th->getMessage());
        }
    }
}
