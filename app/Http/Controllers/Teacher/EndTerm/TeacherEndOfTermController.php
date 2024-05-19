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

class TeacherEndOfTermController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $data = EndOfTerm::with('level')
            ->with('student')
            ->with('branch')
            ->with('term')
            ->where('school_id', Auth::guard('teacher')->user()->school_id)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('teacher.dashboard.assessment.end-of-term.index', compact('schoolTerm', 'data'));
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
                'school_id' => Auth::guard('teacher')->user()->school_id,
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
