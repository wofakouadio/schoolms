<?php

namespace App\Http\Controllers\Teacher\Mock;

use App\Exports\StudentsMockExport;
use App\Http\Controllers\Controller;
use App\Models\AssignSubjectsToMock;
use App\Models\AssignSubjectToLevel;
use App\Models\Mock;
use App\Models\MockBreakdown;
use App\Models\StudentMock;
use App\Models\StudentsAdmissions;
use App\Models\Subject;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use function App\Helpers\TermAndAcademicYear;

class TeacherMockController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        $data = StudentMock::with('teacher_level')
            ->with('student')
            ->with('mock')
            ->with('branch')
            ->with('term')
            ->where('school_id', Auth::guard('teacher')->user()->school_id)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('teacher.dashboard.assessment.mock.index', compact('schoolTerm', 'data'));
    }

    //get mock in select
    public function getMocksInSelectBasedOnSchool()
    {
        $output = [];
        $mocks = Mock::where('school_id', Auth::guard('teacher')->user()->school_id)->get();
        $output[] .= '<option value="">Choose</option>';
        foreach ($mocks as $mock) {
            $output[] .= '<option value="' . $mock->id . '">' . $mock->mock_type . '</option>';
        }
        return $output;
    }
    public function getStudentsBasedOnLevel(Request $request)
    {
        $level_id = $request->level_id;
        $output = [];
        $students = StudentsAdmissions::where('student_level', $level_id)
            ->where("school_id", Auth::guard('teacher')->user()->school_id)
            ->where('admission_status', 1)
            ->orderBy('student_firstname', 'ASC')
            ->get();
        $output[] .= '<option value="">Choose</option>';
        foreach ($students as $student) {
//            dd($student);
            $output[] .= '<option value="' . $student->id . '">' . $student->student_firstname . ' '
                . $student->student_othername . ' '
                . $student->student_lastname . '</option>';
        }
        return $output;
    }

    public function create(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'mock' => 'required',
            'student' => 'required'
        ]);

        //let get student data
        $studentData = StudentsAdmissions::with('level')
            ->where('id', $request->student)
            ->where("school_id", Auth::guard('teacher')->user()->school_id)
            ->where('admission_status', 1)
            ->first();

        //let get mock data
        $mockData = Mock::where('id', $request->mock)
            ->where("school_id", Auth::guard('teacher')->user()->school_id)
            ->first();

        //let get student subjects level assigned to mock
        $studentSubjectsLevel = AssignSubjectsToMock::with('AssignSubject')
            ->where('mock_id', $request->mock)
            ->where('level_id', $request->level)
            ->where("school_id", Auth::guard('teacher')->user()->school_id)
            ->get();

        //let get academic year
        $academicYearSession = Term::with('academic_year')->where("school_id", Auth::guard('teacher')->user()
            ->school_id)
            ->where("is_active", 1)
            ->first();

        $data = [
            'StudentData' => $studentData,
            'MockData' => $mockData,
            'Subjects' => $studentSubjectsLevel,
            'Term' => $academicYearSession
        ];
        return response()->json($data);
//        dd($studentSubjectsLevel);
    }

    //new student mock entry
    public function store(Request $request){
//        dd($request->all());
        DB::beginTransaction();
        try {
            $mockScore = 0;
            $mockEntry = [];
            foreach($request->mock as $key => $value){
                $mockScore += $value['score'];
                $mockEntry[] = [
                    'subject_id' => $value['subject_id'],
                    'score' => $value['score'],
                ];
            }

            $mock = StudentMock::create([
                'student_id' => $request->studentId,
                'level_id' => $request->level_id,
                'mock_id' => $request->mock_id,
                'term_id' => $request->term_id,
                'total_score' => $mockScore,
                'conduct' => $request->conduct,
                'attitude' => $request->attitude,
                'interest' => $request->interest,
                'general_remarks' => $request->general_remarks,
                'school_id' => Auth::guard('teacher')->user()->school_id,
                'branch_id' => $request->branch_id
            ]);

            foreach ($mockEntry as $key => $value) {
                MockBreakdown::create([
                    'mock_student_id' => $mock->id,
                    'student_id' => $request->studentId,
                    'mock_id' => $request->mock_id,
                    'term_id' => $request->term_id,
                    'subject_id' => $value['subject_id'],
                    'score' => $value['score'],
                    'school_id' => Auth::guard('teacher')->user()->school_id,
                    'branch_id' => $request->branch_id
                ]);
            }

//            dd($mockEntry);

            DB::commit();
            Alert::success('Notification', 'Student Mock saved successfully');
            return redirect()->route('teacher_mock_assessment');
//            return response()->json([
//                'status' => 200,
//                'msg' => 'Student Mock saved successfully'
//            ]);
        }catch(\Exception $th){
            DB::rollBack();
            Alert::error('Notification', 'Error: something went wrong. More Details : ' . $th->getMessage());
            return back();
//            return response()->json([
//                'status' => 201,
//                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
//            ]);
        }

    }

    public function export_Students_mock_list(Request $request){
//        DB::beginTransaction();
        try {
//            Excel::download(new StudentsMockExport($request->level), 'list.xlsx');
//            return Excel::download(new StudentsMockExport($request->level), 'mock.xlsx',
//                \Maatwebsite\Excel\Excel::XLSX);
            return (new StudentsMockExport($request->level))->download('mock.xlsx');
//            return new StudentsMockExport();
//            DB::commit();
//            return response()->json([
//                'status' => 200,
//                'msg' => 'Student Mock saved successfully'
//            ]);
        }catch (\Exception $th){
//            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
//        dd($request->all());

//        return (new StudentsMockExport)->level($request->level)->download('fileone.xlsx');
    }
}
