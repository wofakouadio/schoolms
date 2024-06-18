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

class EndOfTermController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.assessment.end-of-term.index', compact('schoolTerm'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'student' => 'required'
        ]);

        $schoolTerm = TermAndAcademicYear();

        //let get student data
        $studentData = StudentsAdmissions::with('level')
            ->where('id', $request->student)
            ->where("school_id", Auth::guard('admin')->user()->school_id)
            ->where('admission_status', 1)
            ->first();

        //let get student subjects level assigned to mock
        $studentSubjectsLevel = AssignSubjectToLevel::with('subject')
            ->where('level_id', $request->level)
            ->where("school_id", Auth::guard('admin')->user()->school_id)
            ->get();

        //let get academic year
        $academicYearSession = Term::with('academic_year')->where("school_id", Auth::guard('admin')->user()->school_id)
            ->where("is_active", 1)
            ->first();

        //let get student class records
        $studentClassAssessment = ClassAssessmentTotalScoreRecord::with(['subject', 'mid_term'])->where([
            'student_id' => $request->student,
            'term_id' => $academicYearSession->id,
            'level_id' => $request->level,
            'academic_year_id' => $academicYearSession->term_academic_year,
            'school_id' => Auth::guard('admin')->user()->school_id
        ])->get();

        //get school Assessment set
        $schoolAssessmentSettings = ClassAssessmentSettings::where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            'academic_year_id' => $academicYearSession->term_academic_year,
        ])->first();

        if(empty($schoolAssessmentSettings)){
            $classPercentage = config('assessment-settings.class_percentage');
            $examPercentage = config('assessment-settings.exam_percentage');
        }else{
            $classPercentage = $schoolAssessmentSettings->class_percentage;
            $examPercentage = $schoolAssessmentSettings->exam_percentage;
        }

        return view('admin.dashboard.assessment.end-of-term.EndTermForm',
            compact('studentData',
                'studentSubjectsLevel',
                'academicYearSession',
                'studentClassAssessment',
                'schoolTerm',
                'classPercentage',
                'examPercentage',
            ));
    }

    public function store(Request $request){
//        dd($request->all());
        DB::beginTransaction();
        try {
            $class_score = 0;
            $exam_score = 0;
            $total_score = 0;
            $endTermEntry = [];
            foreach($request->end_term as $key => $value){
                $class_score += $value['class_score'];
                $exam_score += $value['exam_score'];
                $endTermEntry[] = [
                    'subject_id' => $value['subject_id'],
                    'class_score' => $value['class_score'],
                    'exam_score' => $value['exam_score']
                ];
            }

            $EndTerm = EndOfTerm::create([
                'student_id' => $request->studentId,
                'level_id' => $request->level_id,
                'term_id' => $request->term_id,
                'total_class_score' => $class_score,
                'total_exam_score' => $exam_score,
                'total_score' => $class_score + $exam_score,
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
                    'class_score' => $value['class_score'],
                    'exam_score' => $value['exam_score'],
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'branch_id' => $request->branch_id
                ]);
            }

//            dd($mockEntry);

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Student End of Term Entry saved successfully'
            ]);
        }catch(\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }
}
