<?php

namespace App\Http\Controllers\Admin\Report\EndTerm;

use App\Http\Controllers\Controller;
use App\Models\AssessmentSettings;
use App\Models\AssignSubjectToLevel;
use App\Models\MidTerm;
use App\Models\ClassAssessmentTotalScoreRecord;
use App\Models\EndOfTerm;
use App\Models\EndOfTermBreakdown;
use App\Models\GradingSystem;
use App\Models\Level;
use App\Models\MidTermBreakdown;
use App\Models\School;
use App\Models\StudentsAdmissions;
use App\Models\Subject;
use App\Models\StudentsAcademicRecords;
use App\Models\StudentsAcademicRecordsSummary;
use App\Models\Term;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolAssessmentPercentageSettings;

class EndTermReportController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        $schoolAssessmentsPercentageSettings = SchoolAssessmentPercentageSettings();
        $schoolAssessmentPercentage = $schoolAssessmentsPercentageSettings->getData();
        $data = [] ?? null;
        return view('admin.dashboard.report.end-of-term.index', compact('schoolTerm', 'data', 'schoolAssessmentPercentage'));
    }

    public function get_end_of_term_report(Request $request)
    {
        $term = $request->term;
        $level = $request->level;
        $student = $request->student;
        $schoolTerm = TermAndAcademicYear();
        $schoolAssessmentsPercentageSettings = SchoolAssessmentPercentageSettings();
        $schoolAssessmentPercentage = $schoolAssessmentsPercentageSettings->getData();
        $data = [] ?? null;

        // check if request for student is all or student id
        if ($student != 'all') {
            $termData = Term::with('academic_year')
                ->where(['school_id' => Auth::guard('admin')->user()->school_id, 'id' => $term])
                ->first();
            $studentAssessmentRecordsSummary = StudentsAcademicRecordsSummary::with('student', 'academic_year', 'term', 'level', 'grade', 'school', 'branch')
                ->where([
                    'student_id' => $student,
                    'term_id' => $term,
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'academic_year_id' => $termData->term_academic_year,
                    'level_id' => $level
                ])->first();

            if($studentAssessmentRecordsSummary){
                //get school data
                $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
                //get school profile
                if ($schoolData->getMedia('school_logo')->count() == 0) {
                    $schoolProfile = asset('assets/images/avatar/1.jpg');
                } else {
                    $schoolProfile = $schoolData->getFirstMediaUrl('school_logo');
                }
                //get level details
                $levelData = Level::where('id', $level)->first();
                //get term details
                $termData = Term::with('academic_year')
                    ->where(['school_id' => Auth::guard('admin')->user()->school_id, 'id' => $term])
                    ->first();
                //get student details
                $studentData = StudentsAdmissions::with('house', 'category', 'branch')
                    ->where("id", $student)
                    ->first();
                //student profile
                if ($studentData->getMedia('student_profile')->count() == 0) {
                    $studentProfile = asset('assets/images/profile/small/pic1.jpg');
                } else {
                    $studentProfile = $studentData->getFirstMediaUrl('student_profile');
                }

                //get grading
                $gradingSystem = GradingSystem::where([
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'academic_year' => $termData->term_academic_year,
                    'is_active' => 1
                ])->orderBy('grade', 'asc')->get();

                // dd($gradingSystem);

                // get student assessment records
                $studentAssessmentRecords = StudentsAcademicRecords::with('student', 'academic_year', 'term', 'level', 'subject', 'class_assessment', 'mid_term', 'end_term', 'grade')
                    ->where([
                        'student_id' => $student,
                        'term_id' => $term,
                        'school_id' => Auth::guard('admin')->user()->school_id,
                        'academic_year_id' => $termData->term_academic_year,
                        'level_id' => $level
                    ])->get();

                $data = [
                    'status' => 1,
                    'notice' => 'record found',
                    'levelData' => $levelData,
                    'studentData' => $studentData,
                    'schoolProfile' => $schoolProfile,
                    'studentProfile' => $studentProfile,
                    'studentAssessmentRecords' => $studentAssessmentRecords,
                    'studentAssessmentRecordsSummary' => $studentAssessmentRecordsSummary,
                    'schoolData' => $schoolData,
                    'termData' => $termData,
                    'gradingSystem' => $gradingSystem,
                    'schoolAssessmentPercentage' => $schoolAssessmentPercentage
                ];
            }else{
                $data = [
                    'status' => 0,
                    'notice' => 'No record found'
                ];
            }
                return view('admin.dashboard.report.end-of-term.index', compact('schoolTerm', 'data', 'schoolAssessmentPercentage'));
        }
        else {
            // let get all students
            $allStudents = StudentsAdmissions::with('house', 'category', 'branch')->orderBy('students_admissions.student_id', 'asc')->get();

            foreach($allStudents as $student){

                $termData = Term::with('academic_year')
                ->where([
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'id' => $term
                ])->first();

                //get school data
                $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
                //get school profile
                if ($schoolData->getMedia('school_logo')->count() == 0) {
                    $schoolProfile = asset('assets/images/avatar/1.jpg');
                } else {
                    $schoolProfile = $schoolData->getFirstMediaUrl('school_logo');
                }
                //get level details
                $levelData = Level::where('id', $level)->first();
                //get term details
                $termData = Term::with('academic_year')
                    ->where(['school_id' => Auth::guard('admin')->user()->school_id, 'id' => $term])
                    ->first();
                //get student details
                $studentData = StudentsAdmissions::with('house', 'category', 'branch')
                    ->where("id", $student->id)
                    ->first();
                //student profile
                if ($studentData->getMedia('student_profile')->count() == 0) {
                    $studentProfile = asset('assets/images/profile/small/pic1.jpg');
                } else {
                    $studentProfile = $studentData->getFirstMediaUrl('student_profile');
                }

                //get grading
                $gradingSystem = GradingSystem::where([
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'academic_year' => $termData->term_academic_year,
                    'is_active' => 1
                ])->orderBy('grade', 'asc')->get();

                $studentAssessmentRecordsSummary = StudentsAcademicRecordsSummary::with('student', 'academic_year', 'term', 'level', 'grade', 'school', 'branch')
                    ->where([
                        'student_id' => $student->id,
                        'term_id' => $term,
                        'school_id' => Auth::guard('admin')->user()->school_id,
                        'academic_year_id' => $termData->term_academic_year,
                        'level_id' => $level
                    ])->first();

                if($studentAssessmentRecordsSummary){
                    // dd($gradingSystem);

                    // get student assessment records
                    $studentAssessmentRecords = StudentsAcademicRecords::with('student', 'academic_year', 'term', 'level', 'subject', 'class_assessment', 'mid_term', 'end_term', 'grade')
                        ->where([
                            'student_id' => $student->id,
                            'term_id' => $term,
                            'school_id' => Auth::guard('admin')->user()->school_id,
                            'academic_year_id' => $termData->term_academic_year,
                            'level_id' => $level
                        ])->get();

                    $data[] = [
                        'status' => 1,
                        'notice' => 'record found',
                        'levelData' => $levelData,
                        'studentData' => $studentData,
                        'schoolProfile' => $schoolProfile,
                        'studentProfile' => $studentProfile,
                        'studentAssessmentRecords' => $studentAssessmentRecords,
                        'studentAssessmentRecordsSummary' => $studentAssessmentRecordsSummary,
                        'schoolData' => $schoolData,
                        'termData' => $termData,
                        'gradingSystem' => $gradingSystem,
                        'schoolAssessmentPercentage' => $schoolAssessmentPercentage
                    ];
                }else{
                    $data[] = [
                        'status' => 0,
                        'notice' => 'No record found',
                        'levelData' => $levelData,
                        'studentData' => $studentData,
                        'schoolProfile' => $schoolProfile,
                        'studentProfile' => $studentProfile,
                        'schoolData' => $schoolData,
                        'termData' => $termData,
                        'gradingSystem' => $gradingSystem,
                        'schoolAssessmentPercentage' => $schoolAssessmentPercentage,
                        'studentAssessmentRecords' => [],
                        'studentAssessmentRecordsSummary' => [],
                    ];
                }

            }

            // dd($data);
        //     // dd($allStudents);
        //     //let get end of term data
        //     $endTermFirst = EndOfTerm::where([
        //         "level_id" => $level,
        //         "term_id" => $term,
        //         "school_id" => Auth::guard('admin')->user()->school_id
        //         ])
        //     ->get();
        //     // school data
        //     $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
        //     //get level details
        //     $levelData = Level::where('id', $level)->first();
        //     //get term details
        //     $termData = Term::with('academic_year')
        //         ->where(['school_id' => Auth::guard('admin')->user()->school_id, 'id' => $term])
        //         ->first();
        //     // get class assessment total entry
        //     $classTotalAssessment = ClassAssessmentTotalScoreRecord::with('student', 'level', 'term', 'academicYear', 'subject')->where([
        //         'term_id' => $term,
        //         'school_id' => Auth::guard('admin')->user()->school_id,
        //         'academic_year_id' => $termData->term_academic_year,
        //         'level_id' => $level
        //     ])->get();
        //     // get mid term summary
        //     $midTermSummary = MidTerm::with('level', 'student', 'term')->where([
        //         'level_id' => $level,
        //         'term_id' => $term,
        //     ])->get();

        //     // get all subjects
        //     $subjects = AssignSubjectToLevel::with('level', 'subject')->where([
        //         'level_id' => $level,
        //         'school_id' => Auth::guard('admin')->user()->school_id,
        //         'is_active' => 1
        //     ])->get();

        //     // get mid term breakdown
        //     $midTermBreakdown = MidTermBreakdown::with('midTerm', 'subject')->where([
        //         'term_id' => $term,
        //         'school_id' => Auth::guard('admin')->user()->school_id,
        //         // 'mid_term_student_id' => $midTermSummary->id
        //     ])->get();

        //     //get end of term breakdown entry
        //     $endTermBreakdown = EndOfTermBreakdown::with('subject', 'end_term', 'student', 'term')
        //         ->where([
        //             // "end_term_student_id" => $endTermFirst->id,
        //             "term_id" => $term,
        //             "school_id" => Auth::guard('admin')->user()->school_id
        //         ])->get();

        //     //get grading
        //     $gradingSystem = GradingSystem::where([
        //         'school_id' => Auth::guard('admin')->user()->school_id,
        //         'academic_year' => $termData->term_academic_year,
        //         'is_active' => 1
        //     ])->orderBy('grade', 'asc')->get();

        //     // dd($classTotalAssessment);

        //     // $data = [
        //     //     'status' => 1,
        //     //     'notice' => 'record found',
        //     //     'levelData' => $levelData,
        //     //     'studentData' => $allStudents,
        //     //     // 'schoolProfile' => $schoolProfile,
        //     //     // 'studentProfile' => $studentProfile,
        //     //     // 'classPercentageScore' => $classPercentageScore,
        //     //     'classTotalAssessment' => $classTotalAssessment,
        //     //     'midTermSummary' => $midTermSummary,
        //     //     'endTermFirst' => $endTermFirst,
        //     //     'schoolData' => $schoolData,
        //     //     'termData' => $termData,
        //     //     // 'schoolAssessmentPercentage' => $schoolAssessmentPercentage,
        //     //     'gradingSystem' => $gradingSystem,
        //     //     // 'finalData' => $finalData

        //     // ];

        //     // dd($data);

            // $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentsEndTermReportDownload", compact('levelData', 'allStudents', 'classTotalAssessment', 'midTermSummary', 'endTermFirst', 'schoolData', 'termData', 'gradingSystem', 'schoolAssessmentPercentage', 'midTermBreakdown', 'endTermBreakdown', 'subjects'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
            $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentsEndTermReportDownload", compact('data'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
        //     // $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentsEndTermReportDownload", compact('data'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');

            return $pdf->stream('AllStudents_End_of_Term_Report.pdf');

        //     // return view('admin.dashboard.report.end-of-term.index', compact('schoolTerm', 'data', 'schoolAssessmentPercentage'));
        }
    }



    public function download_end_of_term_report(Request $request)
    {
        $term = $request->term;
        $level = $request->level;
        $student = $request->student;
        $schoolTerm = TermAndAcademicYear();
        $schoolAssessmentsPercentageSettings = SchoolAssessmentPercentageSettings();
        $schoolAssessmentPercentage = $schoolAssessmentsPercentageSettings->getData();
        $data = [] ?? null;

        // check if request for student is all or student id
        if ($student != 'all') {
            $termData = Term::with('academic_year')
                ->where(['school_id' => Auth::guard('admin')->user()->school_id, 'id' => $term])
                ->first();
            $studentAssessmentRecordsSummary = StudentsAcademicRecordsSummary::with('student', 'academic_year', 'term', 'level', 'grade', 'school', 'branch')
                ->where([
                    'student_id' => $student,
                    'term_id' => $term,
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'academic_year_id' => $termData->term_academic_year,
                    'level_id' => $level
                ])->first();

            if($studentAssessmentRecordsSummary){
                //get school data
                $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
                //get school profile
                if ($schoolData->getMedia('school_logo')->count() == 0) {
                    $schoolProfile = asset('assets/images/avatar/1.jpg');
                } else {
                    $schoolProfile = $schoolData->getFirstMediaUrl('school_logo');
                }
                //get level details
                $levelData = Level::where('id', $level)->first();
                //get term details
                $termData = Term::with('academic_year')
                    ->where(['school_id' => Auth::guard('admin')->user()->school_id, 'id' => $term])
                    ->first();
                //get student details
                $studentData = StudentsAdmissions::with('house', 'category', 'branch')
                    ->where("id", $student)
                    ->first();
                //student profile
                if ($studentData->getMedia('student_profile')->count() == 0) {
                    $studentProfile = asset('assets/images/profile/small/pic1.jpg');
                } else {
                    $studentProfile = $studentData->getFirstMediaUrl('student_profile');
                }

                //get grading
                $gradingSystem = GradingSystem::where([
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'academic_year' => $termData->term_academic_year,
                    'is_active' => 1
                ])->orderBy('grade', 'asc')->get();

                // dd($gradingSystem);

                // get student assessment records
                $studentAssessmentRecords = StudentsAcademicRecords::with('student', 'academic_year', 'term', 'level', 'subject', 'class_assessment', 'mid_term', 'end_term', 'grade')
                    ->where([
                        'student_id' => $student,
                        'term_id' => $term,
                        'school_id' => Auth::guard('admin')->user()->school_id,
                        'academic_year_id' => $termData->term_academic_year,
                        'level_id' => $level
                    ])->get();

                $data = [
                    'status' => 1,
                    'notice' => 'record found',
                    'levelData' => $levelData,
                    'studentData' => $studentData,
                    'schoolProfile' => $schoolProfile,
                    'studentProfile' => $studentProfile,
                    'studentAssessmentRecords' => $studentAssessmentRecords,
                    'studentAssessmentRecordsSummary' => $studentAssessmentRecordsSummary,
                    'schoolData' => $schoolData,
                    'termData' => $termData,
                    'gradingSystem' => $gradingSystem,
                    'schoolAssessmentPercentage' => $schoolAssessmentPercentage
                ];
            }else{
                $data = [
                    'status' => 0,
                    'notice' => 'No record found'
                ];
            }

                $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentEndTermReportDownload", compact('data'))
            ->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');

        return $pdf->stream($studentData->student_id . '_' . $studentData->student_firstname . '_'
            . $studentData->student_lastname . '_End_of_Term_Report.pdf');
                // return view('admin.dashboard.report.end-of-term.index', compact('schoolTerm', 'data', 'schoolAssessmentPercentage'));
        }
    //     $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentEndTermReportDownload", compact('data'))
    //         ->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
    //     return $pdf->stream($studentData->student_id . '_' . $studentData->student_firstname . '_'
    //         . $studentData->student_lastname . '_End_of_Term_Report.pdf');
    }
}
