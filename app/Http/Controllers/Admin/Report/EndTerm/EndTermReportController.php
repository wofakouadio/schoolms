<?php

namespace App\Http\Controllers\Admin\Report\EndTerm;

use App\Http\Controllers\Controller;
use App\Models\EndOfTerm;
use App\Models\EndOfTermBreakdown;
use App\Models\Level;
use App\Models\School;
use App\Models\StudentsAdmissions;
use App\Models\Term;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;

class EndTermReportController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $data = [] ?? null;
        return view('admin.dashboard.report.end-of-term.index', compact('schoolTerm', 'data'));
    }

    public function get_end_of_term_report(Request $request){
        $term = $request->term;
        $level = $request->level;
        $student = $request->student;
        $schoolTerm = TermAndAcademicYear();

        //get end of term first entry
        $endTermFirst = EndOfTerm::where("level_id", $level)
        ->where("term_id", $term)
        ->where("student_id", $student)
        ->where('school_id', Auth::guard('admin')->user()->school_id)
        ->first();

        if(!empty($endTermFirst)){
            //get school data
            $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
            //get school profile
            if($schoolData->getMedia('school_logo')->count() == 0){
                $schoolProfile = asset('assets/images/avatar/1.jpg');
            }else{
                $schoolProfile = $schoolData->getFirstMediaUrl('school_logo');
            }
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
            //student profile
            if($studentData->getMedia('student_profile')->count() == 0){
                $studentProfile = asset('assets/images/profile/small/pic1.jpg');
            }else{
                $studentProfile = $studentData->getFirstMediaUrl('student_profile');
            }

            //get end of term breakdown entry
            $endTermBreakdown = EndOfTermBreakdown::with('subject')
                ->where("end_term_student_id", $endTermFirst->id)
                ->where("term_id", $term)
                ->where("student_id", $student)
                ->where('school_id', Auth::guard('admin')->user()->school_id)
                ->where('branch_id', $studentData->student_branch)
                ->get();

            $data[] = [
                'status' => 1,
                'notice' => 'record found',
                'endTermFirst' => $endTermFirst,
                'levelData' => $levelData,
                'studentData' => $studentData,
                'schoolProfile' => $schoolProfile,
                'studentProfile' => $studentProfile,
                'endTermBreakdown' => $endTermBreakdown,
                'schoolData' => $schoolData,
                'termData' => $termData
            ];
        }else{
            $data[] = [
                'status' => 0,
                'notice' => 'No record found'
            ];
        }
        return view('admin.dashboard.report.end-of-term.index', compact('schoolTerm', 'data'));
    }

    public function download_end_of_term_report(Request $request){
        $term = $request->term;
        $level = $request->level;
        $student = $request->student;

        //get end of term first entry
        $endTermFirst = EndOfTerm::where("level_id", $level)
        ->where("term_id", $term)
        ->where("student_id", $student)
        ->where('school_id', Auth::guard('admin')->user()->school_id)
        ->first();

        if(!empty($endTermFirst)){
            //get school data
            $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
            //get school profile
            if($schoolData->getMedia('school_logo')->count() == 0){
                $schoolProfile = asset('assets/images/avatar/1.jpg');
            }else{
                $schoolProfile = $schoolData->getFirstMediaUrl('school_logo');
            }
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
            //student profile
            if($studentData->getMedia('student_profile')->count() == 0){
                $studentProfile = asset('assets/images/profile/small/pic1.jpg');
            }else{
                $studentProfile = $studentData->getFirstMediaUrl('student_profile');
            }

            //get end of term breakdown entry
            $endTermBreakdown = EndOfTermBreakdown::with('subject')
                ->where("end_term_student_id", $endTermFirst->id)
                ->where("term_id", $term)
                ->where("student_id", $student)
                ->where('school_id', Auth::guard('admin')->user()->school_id)
                ->where('branch_id', $studentData->student_branch)
                ->get();

            $data[] = [
                'status' => 1,
                'notice' => 'record found',
                'endTermFirst' => $endTermFirst,
                'levelData' => $levelData,
                'studentData' => $studentData,
                'schoolProfile' => $schoolProfile,
                'studentProfile' => $studentProfile,
                'endTermBreakdown' => $endTermBreakdown,
                'schoolData' => $schoolData,
                'termData' => $termData
            ];
        }else{
            $data[] = [
                'status' => 0,
                'notice' => 'No record found'
            ];
        }
        $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentEndTermReportDownload",compact('data'))
            ->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream($studentData->student_id.'_'.$studentData->student_firstname.'_'
            .$studentData->student_lastname.'_End_of_Term_Report.pdf');
    }
}
