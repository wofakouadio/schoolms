<?php

namespace App\Http\Controllers\Admin\Assessment\EndTerm;

use App\Http\Controllers\Controller;
use App\Models\AssignSubjectToLevel;
use App\Models\ClassAssessment;
use App\Models\ClassAssessmentSettings;
use App\Models\ClassAssessmentTotalScoreRecord;
use App\Models\EndOfTerm;
use App\Models\EndOfTermBreakdown;
use App\Models\MidTermBreakdown;
use App\Models\MockBreakdown;
use App\Models\StudentsAdmissions;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolAssessmentPercentageSettings;

class EndOfTermController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $exam_percentage = $SchoolAssessmentPercentageSettings->getData()->exam_percentage;
        $EndTermRecords = EndOfTermBreakdown::with('end_term', 'student', 'branch', 'term')
        ->where('school_id', Auth::guard('admin')->user()->school_id)
        ->orderBy('created_at', 'DESC')
        ->get();
        return view('admin.dashboard.assessment.end-of-term.index', compact('schoolTerm', 'exam_percentage', 'EndTermRecords'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'student' => 'required'
        ]);

        // $schoolTerm = TermAndAcademicYear();

        //let get student data
        $studentData = StudentsAdmissions::with('level')
            ->where(["school_id" => Auth::guard('admin')->user()->school_id, 'admission_status' => 1, 'id' => $request->student])
            ->first();

        //let get student subjects level assigned to mock
        $studentSubjectsLevel = AssignSubjectToLevel::with('subject')
            ->where(['level_id' => $request->level, "school_id" => Auth::guard('admin')->user()->school_id])
            ->get();

        //let get academic year
        $academicYearSession = Term::with('academic_year')
            ->where(["school_id" => Auth::guard('admin')->user()->school_id, "is_active" => 1])
            ->first();

        //let get student class records
        // $studentClassAssessment = ClassAssessmentTotalScoreRecord::with(['subject', 'mid_term'])->where([
        //     'student_id' => $request->student,
        //     'term_id' => $academicYearSession->id,
        //     'level_id' => $request->level,
        //     'academic_year_id' => $academicYearSession->term_academic_year,
        //     'school_id' => Auth::guard('admin')->user()->school_id
        // ])->get();

        //get school Assessment set
        // $schoolAssessmentSettings = ClassAssessmentSettings::where([
        //     'school_id' => Auth::guard('admin')->user()->school_id,
        //     'academic_year_id' => $academicYearSession->term_academic_year,
        // ])->first();

        // if(empty($schoolAssessmentSettings)) {
        //     $classPercentage = config('assessment-settings.class_percentage');
        //     $examPercentage = config('assessment-settings.exam_percentage');
        // } else {
        //     $classPercentage = $schoolAssessmentSettings->class_percentage;
        //     $examPercentage = $schoolAssessmentSettings->exam_percentage;
        // }

        $data = [
            "StudentData" => $studentData,
            "Subjects" => $studentSubjectsLevel,
            "Term" => $academicYearSession
        ];

        return response()->json($data);

        // return view('admin.dashboard.assessment.end-of-term.EndTermForm',
        //     compact('studentData',
        //         'studentSubjectsLevel',
        //         'academicYearSession',
        //         'studentClassAssessment',
        //         'schoolTerm',
        //         'classPercentage',
        //         'examPercentage',
        //     ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'end_term.*.score' => 'required|numeric|min:0|max:100'
        ]);
        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $exam_percentage = $SchoolAssessmentPercentageSettings->getData()->exam_percentage;

        DB::beginTransaction();
        try {
            $total_score = 0;
            $endTermEntry = [];
            foreach($request->end_term as $key => $value) {
                $total_score += $value['score'];
                $endTermEntry[] = [
                    'subject_id' => $value['subject_id'],
                    'score' => $value['score'],
                    'percentage' => ($value['score']/100) * $exam_percentage
                ];
            }

            // get the total count of the end of term recorded based on the number of subjects
            // by default the end of term is over 100
            $totalEndTermOverScore = count($endTermEntry) * 100;
            // get the total strike percentage value by the count of available score to be recorded
            $totalStrikePercentage = $exam_percentage * count($endTermEntry);
            // after getting the above we use the computation to get the total percentage end of term percentage dynamically
            $endTermTotalPercentage = ($total_score/$totalEndTermOverScore) * $totalStrikePercentage;

            $EndTerm = EndOfTerm::create([
                'student_id' => $request->studentId,
                'level_id' => $request->level_id,
                'term_id' => $request->term_id,
                'total_score' => $total_score,
                'total_percentage' => $endTermTotalPercentage,
                'conduct' => $request->conduct,
                'attitude' => $request->attitude,
                'interest' => $request->interest,
                'general_remarks' => $request->general_remarks,
                'school_id' => Auth::guard('admin')->user()->school_id,
                'branch_id' => $request->branch_id
            ]);

            foreach ($endTermEntry as $key => $value) {
                EndOfTermBreakdown::create([
                    'end_term_student_id' => $EndTerm->id,
                    'student_id' => $request->studentId,
                    'term_id' => $request->term_id,
                    'subject_id' => $value['subject_id'],
                    'score' => $value['score'],
                    'percentage' => $value['percentage'],
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'branch_id' => $request->branch_id
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Student End of Term Entry saved successfully'
            ]);
        } catch(\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }
}
