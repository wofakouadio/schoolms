<?php

namespace App\Http\Controllers\Admin\Report\MidTerm;

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

class MidTermReportController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $data = [] ?? null;
        return view('admin.dashboard.report.mid-term.index', compact('schoolTerm', 'data'));
    }

    public function get_mid_term_report(Request $request){
        $mid_term = $request->mid_term;
        $level = $request->level;
        $student = $request->student;
        $schoolTerm = TermAndAcademicYear();

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

            $data[] = [
                'status' => 1,
                'notice' => 'record found',
                'midTermFirst' => $midTermFirst,
                'levelData' => $levelData,
                'studentData' => $studentData,
                'schoolProfile' => $schoolProfile,
                'midTermData' => $mid_term,
                'studentProfile' => $studentProfile,
                'midTermBreakdown' => $midTermBreakdown,
                'schoolData' => $schoolData,
                'termData' => $termData
            ];

        }else{
            $data[] = [
                'status' => 0,
                'notice' => 'No record found'
            ];
        }

        return view('admin.dashboard.report.mid-term.index', compact('schoolTerm', 'data'));
    }

    public function download_mid_term_report(Request $request){
        $mid_term = $request->mid_term;
        $level = $request->level;
        $student = $request->student;
        $schoolTerm = TermAndAcademicYear();

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

            $data[] = [
                'status' => 1,
                'notice' => 'record found',
                'midTermFirst' => $midTermFirst,
                'levelData' => $levelData,
                'studentData' => $studentData,
                'schoolProfile' => $schoolProfile,
                'midTermData' => $mid_term,
                'studentProfile' => $studentProfile,
                'midTermBreakdown' => $midTermBreakdown,
                'schoolData' => $schoolData,
                'termData' => $termData
            ];

        }else{
            $data[] = [
                'status' => 0,
                'notice' => 'No record found'
            ];
        }
        $pdf = Pdf::loadView("admin.dashboard.report.mid-term.StudentMidTermReportDownload",compact('data'))
            ->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream($studentData->student_id.'_'.$studentData->student_firstname.'_'
            .$studentData->student_lastname.'_MidTerm_Report.pdf');
    }
}
