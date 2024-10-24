<?php

namespace App\Http\Controllers\Admin\Assessment\MidTerm;

use App\Http\Controllers\Controller;
use App\Models\AssignSubjectToLevel;
use App\Models\MidTerm;
use App\Models\MidTermBreakdown;
use App\Models\StudentsAdmissions;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolAssessmentPercentageSettings;

class MidTermController extends Controller
{
    //index
    public function index(){
        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $midTermPercentage = $SchoolAssessmentPercentageSettings->getData()->mid_term_percentage;
        $schoolTerm = TermAndAcademicYear();
        $midTermRecords = MidTermBreakdown::with('midTerm', 'student', 'branch', 'term')
        ->where('school_id', Auth::guard('admin')->user()->school_id)
        ->orderBy('created_at', 'DESC')
        ->get();
        // dd($midTermRecords);
        return view('admin.dashboard.assessment.mid-term.index', compact('schoolTerm', 'midTermPercentage', 'midTermRecords'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'mid_term' => 'required',
            'student' => 'required'
        ]);

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
//        dd($studentSubjectsLevel);
        //let get academic year
        $academicYearSession = Term::with('academic_year')->where("school_id", Auth::guard('admin')->user()->school_id)
            ->where("is_active", 1)
            ->first();

        $data = [
            'StudentData' => $studentData,
            'MidTerm' => $request->mid_term,
            'Subjects' => $studentSubjectsLevel,
            'Term' => $academicYearSession
        ];
        return response()->json($data);
    }

    public function store(Request $request){
        $request->validate([
            'mid_term.*.score' => 'required|min:0|max:100|numeric'
        ]);

        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $midTermPercentage = $SchoolAssessmentPercentageSettings->getData()->mid_term_percentage;

        DB::beginTransaction();
        try {
            $midTermScore = 0;
            $midTermEntry = [];
            foreach($request->mid_term as $key => $value){
                $midTermScore += $value['score'];
                $midTermEntry[] = [
                    'subject_id' => $value['subject_id'],
                    'score' => $value['score'],
                    'percentage' => ($value['score']/100) * $midTermPercentage
                ];
            }
            // get the total count of the mid term recorded based on the number of subjects
            // by default the mid-term score is over 100
            $totalMidTermScore = count($midTermEntry) * 100;
            // get the total strike percentage value by the count of available score to be recorded
            $totalStrikePercentage = $midTermPercentage * count($midTermEntry);
            //after getting the above we use the computation to get the total percentage mid term percentage dynamically
            $midTermTotalPercentage = ($midTermScore/$totalMidTermScore) * $totalStrikePercentage;

            // dd(count($midTermEntry) * 100);

            $midTerm = MidTerm::create([
                'student_id' => $request->studentId,
                'level_id' => $request->level_id,
                'mid_term' => $request->mid_term_name,
                'term_id' => $request->term_id,
                'total_score' => $midTermScore,
                'total_percentage' => $midTermTotalPercentage,
                'school_id' => Auth::guard('admin')->user()->school_id,
                'branch_id' => $request->branch_id
            ]);

            foreach ($midTermEntry as $key => $value) {
                MidTermBreakdown::create([
                    'mid_term_student_id' => $midTerm->id,
                    'student_id' => $request->studentId,
                    'mid_term' => $request->mid_term_name,
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
                'msg' => 'Student Mid-Term Entry saved successfully'
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
