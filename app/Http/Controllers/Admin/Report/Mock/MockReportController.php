<?php

namespace App\Http\Controllers\Admin\Report\Mock;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Mock;
use App\Models\MockBreakdown;
use App\Models\School;
use App\Models\StudentMock;
use App\Models\StudentsAdmissions;
use App\Models\Term;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;


class MockReportController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $data = [] ?? null;
        return view('admin.dashboard.report.mock.index', compact('schoolTerm', 'data'));
    }

    public function preview_mock_report(Request $request){

        $mock_id = $request->mock;
        $level = $request->level;
        $student = $request->student;
//        dd($request->all());
        $schoolTerm = TermAndAcademicYear();
        //get term details
        $termData = Term::with('academic_year')->where('school_id', Auth::guard('admin')->user()->school_id)->where
        ('is_active', 1)
            ->first();
        //mock first entry
        $mockFirstEntry = StudentMock::where('mock_id', $mock_id)
            ->where('student_id', $student)
            ->where('level_id', $level)
            ->where('term_id', $termData->id)
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->first();
        //get school data
        $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
        //get school profile
        if($schoolData->getMedia('school_logo')->count() == 0){
            $schoolProfile = asset('assets/images/avatar/1.jpg');
        }else{
            $schoolProfile = $schoolData->getFirstMediaUrl('school_logo');
        }
        //get mock details
        $mockData = Mock::where('id', $mock_id)->first();
        //get level details
        $levelData = Level::where('id', $level)->first();
        //get student details
        $studentData = StudentsAdmissions::with('house')
            ->with('category')
            ->with('branch')
            ->where("id", $student)->first();
        //student profile
        if($studentData->getMedia('student_profile')->count() == 0){
            $studentProfile = asset('assets/images/profile/small/pic1.jpg');
        }else{
            $studentProfile = $studentData->getFirstMediaUrl('student_profile');
        }

        if(!empty($mockFirstEntry)) {
            //get mock breakdown entry
            $mockBreakdown = MockBreakdown::with('subject')
                ->where('mock_student_id', $mockFirstEntry->id)
                ->where('mock_id', $mock_id)
                ->where('student_id', $student)
                ->where('term_id', $termData->id)
                ->where('school_id', Auth::guard('admin')->user()->school_id)
                ->where('branch_id', $studentData->student_branch)
                ->get();

            $data[] = [
                'status' => 1,
                'notice' => 'record found',
                'mockFirstEntry' => $mockFirstEntry,
                'levelData' => $levelData,
                'studentData' => $studentData,
                'schoolProfile' => $schoolProfile,
                'mockData' => $mockData,
                'studentProfile' => $studentProfile,
                'mockBreakdown' => $mockBreakdown,
                'schoolData' => $schoolData,
                'termData' => $termData
            ];
        }
        else{
            $data[] = [
                'status' => 0,
                'notice' => 'No record found'
            ];
        }
//        dd($data);
        return view('admin.dashboard.report.mock.index', compact('schoolTerm', 'data'));
    }

    public function download_mock_report(Request $request){

        $mock_id = $request->mock;
        $level = $request->level;
        $student = $request->student;
//        dd($request->all());
        //get term details
        $termData = Term::with('academic_year')->where('school_id', Auth::guard('admin')->user()->school_id)->where
        ('is_active', 1)
            ->first();
        //mock first entry
        $mockFirstEntry = StudentMock::where('mock_id', $mock_id)
            ->where('student_id', $student)
            ->where('level_id', $level)
            ->where('term_id', $termData->id)
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->first();
        //get school data
        $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
        //get school profile
        if($schoolData->getMedia('school_logo')->count() == 0){
            $schoolProfile = asset('assets/images/avatar/1.jpg');
        }else{
            $schoolProfile = $schoolData->getFirstMediaUrl('school_logo');
        }
        //get mock details
        $mockData = Mock::where('id', $mock_id)->first();
        //get level details
        $levelData = Level::where('id', $level)->first();
        //get student details
        $studentData = StudentsAdmissions::with('house')
            ->with('category')
            ->with('branch')
            ->where("id", $student)->first();
        //student profile
        if($studentData->getMedia('student_profile')->count() == 0){
            $studentProfile = asset('assets/images/profile/small/pic1.jpg');
        }else{
            $studentProfile = $studentData->getFirstMediaUrl('student_profile');
        }

        if(!empty($mockFirstEntry)) {
            //get mock breakdown entry
            $mockBreakdown = MockBreakdown::with('subject')
                ->where('mock_student_id', $mockFirstEntry->id)
                ->where('mock_id', $mock_id)
                ->where('student_id', $student)
                ->where('term_id', $termData->id)
                ->where('school_id', Auth::guard('admin')->user()->school_id)
                ->where('branch_id', $studentData->student_branch)
                ->get();

            $data[] = [
                'status' => 1,
                'notice' => 'record found',
                'mockFirstEntry' => $mockFirstEntry,
                'levelData' => $levelData,
                'studentData' => $studentData,
                'schoolProfile' => $schoolProfile,
                'mockData' => $mockData,
                'studentProfile' => $studentProfile,
                'mockBreakdown' => $mockBreakdown,
                'schoolData' => $schoolData,
                'termData' => $termData
            ];
        }
        $pdf = Pdf::loadView("admin.dashboard.report.mock.StudentMockReportDownload",compact('data'))
            ->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream($studentData->student_id.'_'.$studentData->student_firstname.'_'
            .$studentData->student_lastname.'_Mock_Report.pdf');
    }
}
