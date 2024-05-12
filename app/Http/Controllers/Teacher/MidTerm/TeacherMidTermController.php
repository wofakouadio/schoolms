<?php

namespace App\Http\Controllers\Teacher\MidTerm;

use App\Http\Controllers\Controller;
use App\Models\AssignSubjectToLevel;
use App\Models\MidTerm;
use App\Models\MidTermBreakdown;
use App\Models\StudentsAdmissions;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use function App\Helpers\TermAndAcademicYear;

class TeacherMidTermController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $data = MidTerm::with('level')
            ->with('student')
            ->with('branch')
            ->with('term')
            ->where('school_id', Auth::guard('teacher')->user()->school_id)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('teacher.dashboard.assessment.mid-term.index', compact('schoolTerm', 'data'));
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
        $academicYearSession = Term::where("school_id", Auth::guard('teacher')->user()->school_id)
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
//        dd($request->all());
        DB::beginTransaction();
        try {
            $midTermScore = 0;
            $midTermEntry = [];
            foreach($request->mid_term as $key => $value){
                $midTermScore += $value['score'];
                $midTermEntry[] = [
                    'subject_id' => $value['subject_id'],
                    'score' => $value['score'],
                ];
            }

            $midTerm = MidTerm::create([
                'student_id' => $request->studentId,
                'level_id' => $request->level_id,
                'mid_term' => $request->mid_term_name,
                'term_id' => $request->term_id,
                'total_score' => $midTermScore,
                'school_id' => Auth::guard('teacher')->user()->school_id,
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
                    'school_id' => Auth::guard('teacher')->user()->school_id,
                    'branch_id' => $request->branch_id
                ]);
            }
            DB::commit();
            Alert::success('Notification', 'Student Mid-Term Entry saved successfully');
            return redirect()->route('teacher_mid_term_assessment');

        }catch(\Exception $th){
            DB::rollBack();
            Alert::error('Notification', 'Error: something went wrong. More Details : ' . $th->getMessage());
            return back();
        }
    }
}
