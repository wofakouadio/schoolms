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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;

class MockReportController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.report.mock.index', compact('schoolTerm'));
    }

    public function get_mock_report(Request $request){
        $mock_id = $request->mock;
        $level = $request->level;
        $student = $request->student;
        $output = '';

        //get school data
        $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
        //get mock details
        $mockData = Mock::where('id', $mock_id)->first();
        //get level details
        $levelData = Level::where('id', $level)->first();
        //get term details
        $termData = Term::where('school_id', Auth::guard('admin')->user()->school_id)->where('is_active', 1)->first();
        //get student details
        $studentData = StudentsAdmissions::with('house')
            ->with('category')
            ->with('branch')
            ->where("id", $student)->first();
        //mock first entry
        $mockFirstEntry = StudentMock::where('mock_id', $mock_id)
            ->where('student_id', $student)
            ->where('level_id', $level)
            ->where('term_id', $termData->id)
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->where('branch_id', $studentData->student_branch)
            ->first();

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

            $output = "<table  class='display table-bordered' style='width:100%; align-self: center'>";
            $output .= '<tr>';
            $output .= '<td width="20%">' . $schoolData->school_name . '</td>';
            $output .= '<td width="60%">
                                <h2 class="text-center fw-bolder text-danger">' . $schoolData->school_name . '</h2>
                                <h6 class="text-center">' . $schoolData->school_location . '</h6>
                                <h6 class="text-center">' . $schoolData->school_email . ' / ' . $schoolData->school_phoneNumber . '</h6>
                                <p class="text-center text-info">' . $studentData->branch->branch_name . ' Branch</p>
                            </td>';
            $output .= '<td width="20%">' . $schoolData->school_name . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td colspan="3"><p class="text-center text-uppercase fw-light">Student Assessment Record</p></td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td colspan="3"><p class="text-center text-primary text-uppercase fw-semibold">Mock '
                . $mockData->mock_type
                . ' Performance Summary</p></td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td colspan="3"><p class="text-center text-primary">=========================================================================================================</p></td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td colspan="3">';
            $output .= '<table class="table-bordered" width="100%">';
            $output .= '<tr>';
            $output .= '<td width="20%"><p>ID</p></td>';
            $output .= '<td width="30%"><p>' . $studentData->student_id . '</p></td>';
            $output .= '<td width="20%"><p>Name</p></td>';
            $output .= '<td width="30%"><p>' . $studentData->student_firstname . ' '
                . $studentData->student_othername . ' '
                . $studentData->student_lastname . '</p></td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td width="20%"><p>Level</p></td>';
            $output .= '<td width="30%"><p>' . $levelData->level_name . '</p></td>';
            $output .= '<td width="20%"><p>Residency</p></td>';
            $output .= '<td width="30%"><p>' . $studentData->student_residency_type . '</p></td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td width="20%"><p>House</p></td>';
            $output .= '<td width="30%"><p>' . $studentData->house->house_name . '</p></td>';
            $output .= '<td width="20%"><p>Category</p></td>';
            $output .= '<td width="30%"><p>' . $studentData->category->category_name . '</p></td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td width="20%">Term</td>';
            $output .= '<td width="30%">' . $termData->term_name . '</td>';
            $output .= '<td width="10%">Academic Year</td>';
            $output .= '<td width="10%">' . $termData->term_academic_year . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td width="50%" colspan="2">Total Score</td>';
            $output .= '<td width="50%" colspan="2" class="text-center text-primary fw-bolder">'
                . $mockFirstEntry->total_score
                . '</td>';
            $output .= '</tr>';
            $output .= '</table>';
            $output .= '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td colspan="3">';
            $output .= '<p class="fw-bolder text-uppercase text-center"><u>Details of result</u></p>';
            $output .= '</td>';
            $output .= '</tr>';

            $output .= '<tr>';
            $output .= '<td width="33.33%" class="text-uppercase">Subject</td>';
            $output .= '<td width="33.33%" class="text-uppercase">Score</td>';
            $output .= '<td width="33.33%" class="text-uppercase">proficiency level</td>';
            $output .= '</tr>';

            foreach ($mockBreakdown as $breakdown) {
                $output .= '<tr>';
                $output .= '<td width="33.33%" class="text-uppercase fw-bolder">' . $breakdown->subject->subject_name . '</td>';
                $output .= '<td width="33.33%" class="text-uppercase fw-bolder">' . $breakdown->score . '</td>';
                $output .= '<td width="33.33%" class="text-uppercase fw-bolder">-</td>';
                $output .= '</tr>';
            }

            $output .= '<tr>';
            $output .= '<td colspan="3">';
            $output .= '<p class="fw-bolder text-uppercase text-center"><u>appraisal</u></p>';
            $output .= '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td colspan="3">';
            $output .= '<table class="table-bordered" width="100%">';
            $output .= '<tr>';
            $output .= '<td width="20%"><p>Conduct</p></td>';
            $output .= '<td width="30%"><p class="text-uppercase">' . $mockFirstEntry->conduct . '</p></td>';
            $output .= '<td width="20%"><p>Attitude</p></td>';
            $output .= '<td width="30%"><p class="text-uppercase">' . $mockFirstEntry->attitude . '</p></td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td width="20%"><p>Interest</p></td>';
            $output .= '<td width="30%"><p class="text-uppercase">' . $mockFirstEntry->interest . '</p></td>';
            $output .= '<td width="20%"><p>General Remarks</p></td>';
            $output .= '<td width="30%"><p class="text-uppercase">' . $mockFirstEntry->general_remarks . '</p></td>';
            $output .= '</tr>';
            $output .= '</table>';
            $output .= '</td>';
            $output .= '</tr>';

            $output .= "</table>";
        }
        else{
            $output .= '<h4 class="fw-bolder text-uppercase text-danger">No record found</h4>';
        }

        return $output;
    }
}
