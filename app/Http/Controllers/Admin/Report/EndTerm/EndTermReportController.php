<?php

namespace App\Http\Controllers\Admin\Report\EndTerm;

use App\Http\Controllers\Controller;
use App\Models\EndOfTerm;
use App\Models\EndOfTermBreakdown;
use App\Models\Level;
use App\Models\School;
use App\Models\StudentsAdmissions;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;

class EndTermReportController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.report.end-of-term.index', compact('schoolTerm'));
    }

    public function get_end_of_term_report(Request $request){
        $term = $request->term;
        $level = $request->level;
        $student = $request->student;
        $output = '';

        //get end of term first entry
        $endTermFirst = EndOfTerm::where("level_id", $level)
        ->where("term_id", $term)
        ->where("student_id", $student)
        ->where('school_id', Auth::guard('admin')->user()->school_id)
        ->first();

        if(!empty($endTermFirst)){
            //get school data
            $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
            //get level details
            $levelData = Level::where('id', $level)->first();
            //get term details
            $termData = Term::where('school_id', Auth::guard('admin')->user()->school_id)
                ->where('id', $term)
                ->first();
            //get student details
            $studentData = StudentsAdmissions::with('house')
                ->with('category')
                ->with('branch')
                ->where("id", $student)->first();

            //get end of term breakdown entry
            $endTermBreakdown = EndOfTermBreakdown::with('subject')
                ->where("end_term_student_id", $endTermFirst->id)
                ->where("term_id", $term)
                ->where("student_id", $student)
                ->where('school_id', Auth::guard('admin')->user()->school_id)
                ->where('branch_id', $studentData->student_branch)
                ->get();

//            dd($endTermBreakdown);

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
                    $output .= '<td colspan="3"><p class="text-center text-primary text-uppercase fw-semibold"> End of Term '. $termData->term_name . ' Performance Summary</p></td>';
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
                                $output .= '<td width="30%"><p>' . $studentData->student_firstname . ' '. $studentData->student_othername . ' '. $studentData->student_lastname . '</p></td>';
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
                                . $endTermFirst->total_score
                                . '</td>';
                            $output .= '</tr>';
                            $output .= '<tr>';
                                $output .= '<td width="20%">Total Class Score</td>';
                                $output .= '<td width="30%">' . $endTermFirst->total_class_score . '</td>';
                                $output .= '<td width="20%">Total Exam Score</td>';
                                $output .= '<td width="30%">' . $endTermFirst->total_exam_score . '</td>';
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
                    $output .= '<td colspan="3">';
                        $output .= '<table class="table-bordered" width="100%">';
                            $output .= '<tr>';
                                $output .= '<td width="25%" class="text-uppercase">Subject</td>';
                                $output .= '<td width="25%" class="text-uppercase">Class Score</td>';
                                $output .= '<td width="25%" class="text-uppercase">Exam Score</td>';
                                $output .= '<td width="25%" class="text-uppercase">proficiency level</td>';
                            $output .= '</tr>';
                            foreach ($endTermBreakdown as $breakdown){
                                $output .= '<tr>';
                                    $output .= '<td width="25%" class="text-uppercase fw-bolder">' .
                                        $breakdown->subject->subject_name . '</td>';
                                    $output .= '<td width="25%" class="text-uppercase fw-bolder">' . $breakdown->class_score .
                                        '</td>';
                                    $output .= '<td width="25%" class="text-uppercase fw-bolder">' . $breakdown->exam_score .
                                        '</td>';
                                    $output .= '<td width="25%" class="text-uppercase fw-bolder">-</td>';
                                $output .= '</tr>';
                            }
                        $output .= '<table>';
                    $output .= '</td>';
                $output .= '</tr>';
                $output .= '<tr>';
                    $output .= '<td colspan="3"><p class="fw-bolder text-uppercase text-center"><u>appraisal</u></p></td>';
                $output .= '</tr>';
                $output .= '<tr>';
                    $output .= '<td colspan="3">';
                        $output .= '<table class="table-bordered" width="100%">';
                            $output .= '<tr>';
                                $output .= '<td width="20%"><p>Conduct</p></td>';
                                $output .= '<td width="30%"><p class="text-uppercase">' . $endTermFirst->conduct . '</p></td>';
                                $output .= '<td width="20%"><p>Attitude</p></td>';
                                $output .= '<td width="30%"><p class="text-uppercase">' . $endTermFirst->attitude . '</p></td>';
                            $output .= '</tr>';
                            $output .= '<tr>';
                                $output .= '<td width="20%"><p>Interest</p></td>';
                                $output .= '<td width="30%"><p class="text-uppercase">' . $endTermFirst->interest . '</p></td>';
                                $output .= '<td width="20%"><p>General Remarks</p></td>';
                                $output .= '<td width="30%"><p class="text-uppercase">' . $endTermFirst->general_remarks . '</p></td>';
                            $output .= '</tr>';
                        $output .= '</table>';
                    $output .= '</td>';
                $output .= '</tr>';

            $output .= "</table>";

        }else{
            $output .= '<h4 class="fw-bolder text-uppercase text-danger">No record found</h4>';
        }
        return $output;
    }
}
