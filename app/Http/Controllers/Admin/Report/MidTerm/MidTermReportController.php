<?php

namespace App\Http\Controllers\Admin\Report\MidTerm;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\MidTerm;
use App\Models\MidTermBreakdown;
use App\Models\School;
use App\Models\StudentsAdmissions;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;

class MidTermReportController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.report.mid-term.index', compact('schoolTerm'));
    }

    public function get_mid_term_report(Request $request){
        $mid_term = $request->mid_term;
        $level = $request->level;
        $student = $request->student;
        $output = '';

        //get mid-term first entry
        $midTermFirst = MidTerm::where("mid_term", $mid_term)
            ->where('level_id', $level)
            ->where("student_id", $student)
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->first();

        if(!empty($midTermFirst)){

            //get school data
            $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
            //get school profile
            if($schoolData->getMedia('school_logo')->count() == 0){
                $schoolProfile = "<img src='". asset('assets/images/avatar/1.jpg') ."' class='rounded-circle' width=200>";
            }else{
                $schoolProfile = "<img src='". $schoolData->getFirstMediaUrl('school_logo') ."' class='rounded' width=200>";
            }
            //get level details
            $levelData = Level::where('id', $level)->first();
            //get student details
            $studentData = StudentsAdmissions::with('house')
                ->with('category')
                ->with('branch')
                ->where("id", $student)->first();
            //student profile
            if($studentData->getMedia('student_profile')->count() == 0){
                $studentProfile = "<img src='". asset('assets/images/profile/small/pic1.jpg') ."' class='rounded-circle' width=200>";
            }else{
                $studentProfile = "<img src='". $studentData->getFirstMediaUrl('student_profile') ."' class='rounded' width=200>";
            }

            //get term details
            $termData = Term::where('school_id', Auth::guard('admin')->user()->school_id)
                ->where('id', $midTermFirst->term_id)
                ->first();

            //get mid-term breakdown entry
            $midTermBreakdown = MidTermBreakdown::with('subject')
                ->where('mid_term_student_id', $midTermFirst->id)
                ->where('term_id', $midTermFirst->term_id)
                ->where('student_id', $student)
                ->where('school_id', Auth::guard('admin')->user()->school_id)
                ->where('branch_id', $studentData->student_branch)
                ->get();

            $output = "<table  class='display table-bordered' style='width:100%; align-self: center'>";
            $output .= '<tr>';
            $output .= '<td width="20%" class="text-center">' . $schoolProfile . '</td>';
            $output .= '<td width="60%">
                                <h2 class="text-center fw-bolder text-danger">' . $schoolData->school_name . '</h2>
                                <h6 class="text-center">' . $schoolData->school_location . '</h6>
                                <h6 class="text-center">' . $schoolData->school_email . ' / ' . $schoolData->school_phoneNumber . '</h6>
                                <p class="text-center text-info">' . $studentData->branch->branch_name . ' Branch</p>
                            </td>';
            $output .= '<td width="20%" class="text-center">' . $studentProfile . '</td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td colspan="3"><p class="text-center text-uppercase fw-light">Student Assessment Record</p></td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td colspan="3"><p class="text-center text-primary text-uppercase fw-semibold">'
                . $mid_term
                . ' Mid-Term Performance Summary</p></td>';
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
                . $midTermFirst->total_score
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

            foreach ($midTermBreakdown as $breakdown){
                $output .= '<tr>';
                $output .= '<td width="33.33%" class="text-uppercase fw-bolder">' . $breakdown->subject->subject_name . '</td>';
                $output .= '<td width="33.33%" class="text-uppercase fw-bolder">' . $breakdown->score . '</td>';
                $output .= '<td width="33.33%" class="text-uppercase fw-bolder">-</td>';
                $output .= '</tr>';
            }

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
