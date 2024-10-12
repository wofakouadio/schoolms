<?php

namespace App\Http\Controllers\Teacher\MidTerm;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\MidTerm;
use App\Models\MidTermBreakdown;
use App\Models\School;
use App\Models\StudentsAdmissions;
use App\Models\Term;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;

class TeacherMidTermReportController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $data = [] ?? null;
        return view('teacher.dashboard.report.mid-term.index', compact('schoolTerm', 'data'));
    }

    public function preview_mid_term_report(Request $request){
        $mid_term = $request->mid_term;
        $level = $request->level;
        $student = $request->student;
        $schoolTerm = TermAndAcademicYear();

        //get mid-term first entry
        $midTermFirst = MidTerm::where("mid_term", $mid_term)
            ->where('level_id', $level)
            ->where("student_id", $student)
            ->where('school_id', Auth::guard('teacher')->user()->school_id)
            ->first();

        if(!empty($midTermFirst)){

            //get school data
            $schoolData = School::where("id", Auth::guard('teacher')->user()->school_id)->first();
            //get school profile
            if($schoolData->getMedia('school_logo')->count() == 0){
                $schoolProfile = asset('assets/images/avatar/1.jpg');
            }else{
                $schoolProfile = $schoolData->getFirstMediaUrl('school_logo');
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
                $studentProfile = asset('assets/images/profile/small/pic1.jpg');
            }else{
                $studentProfile = $studentData->getFirstMediaUrl('student_profile');
            }

            //get term details
            $termData = Term::with('academic_year')->where('school_id', Auth::guard('teacher')->user()->school_id)
                ->where('id', $midTermFirst->term_id)
                ->first();

            //get mid-term breakdown entry
            $midTermBreakdown = MidTermBreakdown::with('subject')
                ->where('mid_term_student_id', $midTermFirst->id)
                ->where('term_id', $midTermFirst->term_id)
                ->where('student_id', $student)
                ->where('school_id', Auth::guard('teacher')->user()->school_id)
                ->where('branch_id', $studentData->student_branch)
                ->get();

            $data[] = [
                'status' => 1,
                'notice' => 'record found',
                'midTermFirst' => $midTermFirst,
                'levelData' => $levelData,
                'studentData' => $studentData,
                'schoolProfile' => $schoolProfile,
                'midTermData' => $mid_term,
                'studentProfile' => $studentProfile,
                'schoolData' => $schoolData,
                'termData' => $termData,
                'midTermBreakdown' => $midTermBreakdown
            ];
        }else{
            $data[] = [
                'status' => 0,
                'notice' => 'No record found'
            ];
        }

        return view('teacher.dashboard.report.mid-term.index', compact('schoolTerm', 'data'));
    }

    public function download_mid_term_report(Request $request){
        $mid_term = $request->mid_term;
        $level = $request->level;
        $student = $request->student;

        //get mid-term first entry
        $midTermFirst = MidTerm::where("mid_term", $mid_term)
            ->where('level_id', $level)
            ->where("student_id", $student)
            ->where('school_id', Auth::guard('teacher')->user()->school_id)
            ->first();

        if(!empty($midTermFirst)){

            //get school data
            $schoolData = School::where("id", Auth::guard('teacher')->user()->school_id)->first();
            //get school profile
            if($schoolData->getMedia('school_logo')->count() == 0){
                $schoolProfile = asset('assets/images/avatar/1.jpg');
            }else{
                $schoolProfile = $schoolData->getFirstMediaUrl('school_logo');
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
                $studentProfile = asset('assets/images/profile/small/pic1.jpg');
            }else{
                $studentProfile = $studentData->getFirstMediaUrl('student_profile');
            }

            //get term details
            $termData = Term::with('academic_year')->where('school_id', Auth::guard('teacher')->user()->school_id)
                ->where('id', $midTermFirst->term_id)
                ->first();

            //get mid-term breakdown entry
            $midTermBreakdown = MidTermBreakdown::with('subject')
                ->where('mid_term_student_id', $midTermFirst->id)
                ->where('term_id', $midTermFirst->term_id)
                ->where('student_id', $student)
                ->where('school_id', Auth::guard('teacher')->user()->school_id)
                ->where('branch_id', $studentData->student_branch)
                ->get();

            $data[] = [
                'status' => 1,
                'notice' => 'record found',
                'midTermFirst' => $midTermFirst,
                'levelData' => $levelData,
                'studentData' => $studentData,
                'schoolProfile' => $schoolProfile,
                'midTermData' => $mid_term,
                'studentProfile' => $studentProfile,
                'schoolData' => $schoolData,
                'termData' => $termData,
                'midTermBreakdown' => $midTermBreakdown
            ];
        }else{
            $data[] = [
                'status' => 0,
                'notice' => 'No record found'
            ];
        }
        $pdf = Pdf::loadView("teacher.dashboard.report.mid-term.StudentMidTermReportDownload",compact('data'))
            ->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream($studentData->student_id.'_'.$studentData->student_firstname.'_'
            .$studentData->student_lastname.'_MidTerm_Report.pdf');
    }
}
