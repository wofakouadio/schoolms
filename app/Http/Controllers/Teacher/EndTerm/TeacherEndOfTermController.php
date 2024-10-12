<?php
namespace App\Http\Controllers\Teacher\EndTerm;

use App\Http\Controllers\Controller;
use App\Models\AssignSubjectToLevel;
use App\Models\EndOfTerm;
use App\Models\EndOfTermBreakdown;
use App\Models\StudentsAdmissions;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolAssessmentPercentageSettings;

class TeacherEndOfTermController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $exam_percentage = $SchoolAssessmentPercentageSettings->getData()->exam_percentage;
        $EndTermRecords = EndOfTermBreakdown::with('end_term', 'student', 'branch', 'term')
        ->where('school_id', Auth::guard('teacher')->user()->school_id)
        ->orderBy('created_at', 'DESC')
        ->get();
        return view('teacher.dashboard.assessment.end-of-term.index', compact('schoolTerm', 'exam_percentage', 'EndTermRecords'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'student' => 'required'
        ]);

        //let get student data
        $studentData = StudentsAdmissions::with('level')
            ->where('id', $request->student)
            ->where("school_id", Auth::guard('teacher')->user()->school_id)
            ->where('admission_status', 1)
            ->first();

        //let get student subjects level assigned to mock
        $studentSubjectsLevel = AssignSubjectToLevel::with('subject')
            ->where('level_id', $request->level)
            ->where("school_id", Auth::guard('teacher')->user()->school_id)
            ->get();
//        dd($studentSubjectsLevel);
        //let get academic year
        $academicYearSession = Term::with('academic_year')->where("school_id", Auth::guard('teacher')->user()->school_id)
            ->where("is_active", 1)
            ->first();

        $data = [
            'StudentData' => $studentData,
            'Subjects' => $studentSubjectsLevel,
            'Term' => $academicYearSession
        ];
        return response()->json($data);
//        dd($studentSubjectsLevel);
    }

    public function store(Request $request){
    //    dd($request->all());
        $request->validate([
            'end_term.*.score' => 'required|numeric|min:0|max:100'
        ]);
        DB::beginTransaction();
        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $exam_percentage = $SchoolAssessmentPercentageSettings->getData()->exam_percentage;
        try {
            // $class_score = 0;
            // $exam_score = 0;
            $total_score = 0;
            $endTermEntry = [];
            foreach($request->end_term as $key => $value){
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
                'school_id' => Auth::guard('teacher')->user()->school_id,
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
                    'school_id' => Auth::guard('teacher')->user()->school_id,
                    'branch_id' => $request->branch_id
                ]);
            }

            DB::commit();
            Alert::success('Notification', 'Student End of Term Entry saved successfully');
            return redirect()->route('teacher_end_term_assessment');
//            return response()->json([
//                'status' => 200,
//                'msg' => 'Student End of Term Entry saved successfully'
//            ]);
        }catch(\Exception $th){
            DB::rollBack();
            Alert::error('Error', 'Something went wrong. More Details : ' . $th->getMessage());
            return back();
//            return response()->json([
//                'status' => 201,
//                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
//            ]);
        }
    }
}
