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
            //get end of term first entry
            $endTermFirst = EndOfTerm::where([
                "level_id" => $level,
                "term_id" => $term,
                "student_id" => $student,
                "school_id" => Auth::guard('admin')->user()->school_id
            ])
                ->first();

            // check if there is end of term first entry
            // then we proceed to get the remaining data
            // else we throw an empty response
            if (!empty($endTermFirst)) {
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

                // get class assessment total entry
                $classTotalAssessment = ClassAssessmentTotalScoreRecord::with('student', 'level', 'term', 'academicYear', 'subject')->where([
                    'student_id' => $student,
                    'term_id' => $term,
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'academic_year_id' => $termData->term_academic_year,
                    'level_id' => $level
                ])->get();

                $classPercentageScore = 0;
                foreach ($classTotalAssessment as $key => $class) {
                    $classPercentageScore += $class->percentage;
                }

                // dd($studentData);

                // get mid term summary
                $midTermSummary = MidTerm::with('level', 'student', 'term')->where([
                    'student_id' => $student,
                    'level_id' => $level,
                    'term_id' => $term,
                ])->first();

                // get mid term breakdown
                $midTermBreakdown = MidTermBreakdown::with('midTerm', 'subject')->where([
                    'mid_term_student_id' => $midTermSummary->id
                ])->get();


                //get end of term breakdown entry
                $endTermBreakdown = EndOfTermBreakdown::with('subject', 'end_term', 'student', 'term')
                    ->where([
                        "end_term_student_id" => $endTermFirst->id,
                        "term_id" => $term,
                        "student_id" => $student,
                        "school_id" => Auth::guard('admin')->user()->school_id
                    ])->get();

                //get grading
                $gradingSystem = GradingSystem::where([
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'academic_year' => $termData->term_academic_year,
                    'is_active' => 1
                ])->orderBy('grade', 'asc')->get();

                // Prepare final data structure
                $finalData = [];
                $grading = [];
                // FIRST SAMPLE TRY
                foreach ($classTotalAssessment as $data) {
                    $subject = $data->subject_id;
                    $finalData[$subject]['subject_name'] = $data->subject->subject_name;
                    if (!isset($finalData[$subject])) {
                        $finalData[$subject] = ['class_assessment' => 0.0, 'mid_term' => 0.0, 'end_term' => 0.0];
                    } else {
                        $finalData[$subject]['class_assessment'] = +$data->percentage;
                    }
                }
                foreach ($midTermBreakdown as $data) {
                    $subject = $data->subject_id;
                    $finalData[$subject]['subject_name'] = $data->subject->subject_name;
                    if (!isset($finalData[$subject])) {
                        $finalData[$subject] = ['class_assessment' => 0.0, 'mid_term' => 0.0, 'end_term' => 0.0];
                    } else {
                        $finalData[$subject]['mid_term'] = +$data->percentage;
                    }
                }
                foreach ($endTermBreakdown as $data) {
                    $subject = $data->subject_id;
                    $finalData[$subject]['subject_name'] = $data->subject->subject_name;
                    if (!isset($finalData[$subject])) {
                        $finalData[$subject] = ['class_assessment' => 0.0, 'mid_term' => 0.0, 'end_term' => 0.0];
                    } else {
                        $finalData[$subject]['end_term'] = +$data->percentage;
                    }
                }
                foreach ($finalData as $subject => $scores) {
                    if (isset($scores['class_assessment'])) {
                        $scores['class_assessment'] ? $scores['class_assessment'] : 0;
                    } else {
                        $scores['class_assessment'] = 0.0;
                    }
                    if (isset($scores['mid_term'])) {
                        $scores['mid_term'] ? $scores['mid_term'] : 0;
                    } else {
                        $scores['mid_term'] = 0.0;
                    }
                    if (isset($scores['end_term'])) {
                        $scores['end_term'] ? $scores['end_term'] : 0;
                    } else {
                        $scores['end_term'] = 0.0;
                    }
                    $finalData[$subject]['total'] = $scores['class_assessment'] + $scores['mid_term'] + $scores['end_term'];
                }
                foreach ($gradingSystem as $key => $value) {
                    $level = $value['level_of_proficiency'];
                    $grading[$level] = [
                        'grade' => $value['grade'],
                        'from' => $value['score_from'],
                        'to' => $value['score_to'],
                        'proficiency' => $value['level_of_proficiency']
                    ];
                }
                foreach ($finalData as $subject => $score) {
                    foreach ($grading as $level => $value) {
                        if ($score['total'] >= $value['from'] && $score['total'] <= $value['to']) {
                            $finalData[$subject]['grade'] = $value['grade'];
                            $finalData[$subject]['level'] = $value['proficiency'];
                        }
                    }
                }

                $data = [
                    'status' => 1,
                    'notice' => 'record found',
                    'levelData' => $levelData,
                    'studentData' => $studentData,
                    'schoolProfile' => $schoolProfile,
                    'studentProfile' => $studentProfile,
                    'classPercentageScore' => $classPercentageScore,
                    'classTotalAssessment' => $classTotalAssessment,
                    'midTermSummary' => $midTermSummary,
                    'endTermFirst' => $endTermFirst,
                    // 'midTermBreakdown' => $midTermBreakdown,
                    // 'endTermBreakdown' => $endTermBreakdown,
                    'schoolData' => $schoolData,
                    'termData' => $termData,
                    'schoolAssessmentPercentage' => $schoolAssessmentPercentage,
                    'gradingSystem' => $gradingSystem,
                    'finalData' => $finalData

                ];
            } else {
                $data = [
                    'status' => 0,
                    'notice' => 'No record found'
                ];
            }

            return view('admin.dashboard.report.end-of-term.index', compact('schoolTerm', 'data', 'schoolAssessmentPercentage'));
        } else {

            $termData = Term::with('academic_year')
                ->where(['school_id' => Auth::guard('admin')->user()->school_id, 'id' => $term])
                ->first();

            // school data
            $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();

            //get grading
            $gradingSystem = GradingSystem::where([
                'school_id' => Auth::guard('admin')->user()->school_id,
                'academic_year' => $termData->term_academic_year,
                'is_active' => 1
            ])->orderBy('grade', 'asc')->get();

            // get class assessment total entry
            $classTotalAssessment = ClassAssessmentTotalScoreRecord::with('student', 'level', 'term', 'academicYear', 'subject')->where([
                'term_id' => $term,
                'school_id' => Auth::guard('admin')->user()->school_id,
                'academic_year_id' => $termData->term_academic_year,
                'level_id' => $level
            ])->get();

            // get mid term summary
            $midTermSummary = MidTerm::with('level', 'student', 'term')->where([
                'level_id' => $level,
                'term_id' => $term,
            ])->get();

            //let get end of term data
            $endTermFirst = EndOfTerm::where([
                "level_id" => $level,
                "term_id" => $term,
                "school_id" => Auth::guard('admin')->user()->school_id
                ])
            ->get();

            $results = DB::table('students_admissions as sa')
                ->join('branches as b', 'sa.student_branch', '=', 'b.id')
                ->join('houses as h', 'sa.student_house', '=', 'h.id')
                ->join('categories as cat', 'sa.student_category', '=', 'cat.id')
                ->join('levels as l', 'sa.student_level', '=', 'l.id')
                ->join('assign_subject_to_levels as asl', function ($join) {
                    $join->on('asl.level_id', '=', 'l.id')
                        ->whereColumn('sa.student_level', 'asl.level_id');
                })
                ->leftJoin('subjects as s', 's.id', '=', 'asl.subject_id')
                ->leftJoin('class_assessment_total_score_records as c', function ($join) {
                    $join->on('c.student_id', '=', 'sa.id')
                        ->on('s.id', '=', 'c.subject_id')
                        ->on('l.id', '=', 'c.level_id');
                })
                ->leftJoin('mid_term_breakdowns as m', function ($join) {
                    $join->on('m.student_id', '=', 'sa.id')
                        ->on('s.id', '=', 'm.subject_id');
                })
                ->leftJoin('end_of_term_breakdowns as e', function ($join) {
                    $join->on('e.student_id', '=', 'sa.id')
                        ->on('s.id', '=', 'e.subject_id');
                })
                ->where([
                    'c.level_id' => $level,
                    'c.term_id' => $term,
                    'c.academic_year_id' => $termData->term_academic_year,
                    'c.school_id' => Auth::guard('admin')->user()->school_id,
                    'm.term_id' => $term,
                    'm.school_id' => Auth::guard('admin')->user()->school_id,
                    'e.term_id' => $term,
                    'e.school_id' => Auth::guard('admin')->user()->school_id
                ])
                ->select(
                    'sa.id as student_uuid',
                    'sa.student_id',
                    'sa.student_firstname',
                    'sa.student_othername',
                    'sa.student_lastname',
                    'b.branch_name',
                    'l.level_name',
                    'sa.student_residency_type',
                    'h.house_name',
                    'cat.category_name',
                    's.subject_name',
                    DB::raw('IF(c.percentage, c.percentage, 0) as class_score_percentage'),
                    DB::raw('IF(m.percentage, m.percentage, 0) as mid_term_score_percentage'),
                    DB::raw('IF(e.percentage, e.percentage, 0) as end_term_score_percentage'),
                    DB::raw('(IF(c.percentage, c.percentage, 0) + IF(m.percentage, m.percentage, 0) + IF(e.percentage, e.percentage, 0)) as total_100')
                )
                ->get();

            // dd($results);

            // $data = collect($results);

            // dd($data);

            $grouped = $results->groupBy('student_uuid')->map(function ($studentData) {
                $firstStudent = $studentData->first();

                return [
                    "student_uuid" => $firstStudent->student_uuid,
                    "student_id" => $firstStudent->student_id,
                    "student_name" => "{$firstStudent->student_firstname} {$firstStudent->student_othername} {$firstStudent->student_lastname}",
                    "branch_name" => $firstStudent->branch_name,
                    "level_name" => $firstStudent->level_name,
                    "student_residency_type" => $firstStudent->student_residency_type,
                    "house_name" => $firstStudent->house_name,
                    "category_name" => $firstStudent->category_name,
                    "subjects" => $studentData->map(function ($subject) {
                        return [
                            "subject_name" => $subject->subject_name,
                            "class_score_percentage" => $subject->class_score_percentage,
                            "mid_term_score_percentage" => $subject->mid_term_score_percentage,
                            "end_term_score_percentage" => $subject->end_term_score_percentage,
                            "total_score" => $subject->total_100,
                        ];
                    })->values(),
                ];
            });

            $data = $grouped->toArray();

            // dd($gradingSystem);
            $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentsEndTermReportDownload", compact('schoolData', 'termData', 'gradingSystem', 'schoolAssessmentPercentage', 'data', 'classTotalAssessment', 'midTermSummary', 'endTermFirst'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');

            // $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentsEndTermReportDownload", compact('schoolData', 'termData', 'gradingSystem', 'schoolAssessmentPercentage', 'results', 'classTotalAssessment', 'midTermSummary', 'endTermFirst'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
            // $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentsEndTermReportDownload", compact('data'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');

            return $pdf->stream('AllStudents_End_of_Term_Report.pdf');

        }
        // else {
        //     // let get all students
        //     $allStudents = StudentsAdmissions::with('house', 'category', 'branch')->orderBy('students_admissions.student_id', 'asc')->get();
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

        //     $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentsEndTermReportDownload", compact('levelData', 'allStudents', 'classTotalAssessment', 'midTermSummary', 'endTermFirst', 'schoolData', 'termData', 'gradingSystem', 'schoolAssessmentPercentage', 'midTermBreakdown', 'endTermBreakdown', 'subjects'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
        //     // $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentsEndTermReportDownload", compact('data'))->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');

        //     return $pdf->stream('AllStudents_End_of_Term_Report.pdf');

        //     // return view('admin.dashboard.report.end-of-term.index', compact('schoolTerm', 'data', 'schoolAssessmentPercentage'));
        // }
    }



    // public function download_end_of_term_report(Request $request)
    // {
    //     $term = $request->term;
    //     $level = $request->level;
    //     $student = $request->student;
    //     $schoolTerm = TermAndAcademicYear();
    //     $schoolAssessmentsPercentageSettings = SchoolAssessmentPercentageSettings();
    //     $schoolAssessmentPercentage = $schoolAssessmentsPercentageSettings->getData();
    //     $data = [] ?? null;

    //     //get end of term first entry
    //     $endTermFirst = EndOfTerm::where([
    //         "level_id" => $level,
    //         "term_id" => $term,
    //         "student_id" => $student,
    //         "school_id" => Auth::guard('admin')->user()->school_id
    //         ])
    //     ->first();


    //     // check if there is end of term first entry
    //     // then we proceed to get the remaining data
    //     // else we throw an empty response
    //     if (!empty($endTermFirst)) {
    //         //get school data
    //         $schoolData = School::where("id", Auth::guard('admin')->user()->school_id)->first();
    //         //get school profile
    //         if ($schoolData->getMedia('school_logo')->count() == 0) {
    //             $schoolProfile = asset('assets/images/avatar/1.jpg');
    //         } else {
    //             $schoolProfile = $schoolData->getFirstMediaUrl('school_logo');
    //         }
    //         //get level details
    //         $levelData = Level::where('id', $level)->first();
    //         //get term details
    //         $termData = Term::with('academic_year')
    //             ->where(['school_id' => Auth::guard('admin')->user()->school_id, 'id' => $term])
    //             ->first();
    //         //get student details
    //         $studentData = StudentsAdmissions::with('house', 'category', 'branch')
    //             ->where("id", $student)
    //             ->first();
    //         //student profile
    //         if ($studentData->getMedia('student_profile')->count() == 0) {
    //             $studentProfile = asset('assets/images/profile/small/pic1.jpg');
    //         } else {
    //             $studentProfile = $studentData->getFirstMediaUrl('student_profile');
    //         }

    //         // get class assessment total entry
    //         $classTotalAssessment = ClassAssessmentTotalScoreRecord::with('student', 'level', 'term', 'academicYear', 'subject')->where([
    //             'student_id' => $student,
    //             'term_id' => $term,
    //             'school_id' => Auth::guard('admin')->user()->school_id,
    //             'academic_year_id' => $termData->term_academic_year,
    //             'level_id' => $level
    //         ])->get();

    //         $classPercentageScore = 0;
    //         foreach ($classTotalAssessment as $key => $class) {
    //             $classPercentageScore += $class->percentage;
    //         }

    //         // dd($studentData);

    //         // get mid term summary
    //         $midTermSummary = MidTerm::with('level', 'student', 'term')->where([
    //             'student_id' => $student,
    //             'level_id' => $level,
    //             'term_id' => $term,
    //         ])->first();

    //         // get mid term breakdown
    //         $midTermBreakdown = MidTermBreakdown::with('midTerm', 'subject')->where([
    //             'mid_term_student_id' => $midTermSummary->id
    //         ])->get();


    //         //get end of term breakdown entry
    //         $endTermBreakdown = EndOfTermBreakdown::with('subject', 'end_term', 'student', 'term')
    //             ->where(["end_term_student_id" => $endTermFirst->id,
    //                     "term_id" => $term,
    //                     "student_id" => $student,
    //                     "school_id" => Auth::guard('admin')->user()->school_id
    //             ])->get();

    //         //get grading
    //         $gradingSystem = GradingSystem::where([
    //             'school_id' => Auth::guard('admin')->user()->school_id,
    //             'academic_year' => $termData->term_academic_year,
    //             'is_active' => 1
    //         ])->orderBy('grade', 'asc')->get();

    //         // Prepare final data structure
    //         $finalData = [];
    //         $grading = [];
    //         // FIRST SAMPLE TRY
    //         foreach ($classTotalAssessment as $data) {
    //             $subject = $data->subject_id;
    //             $finalData[$subject]['subject_name'] = $data->subject->subject_name;
    //             if (!isset($finalData[$subject])) {
    //                 $finalData[$subject] = ['class_assessment' => 0.0, 'mid_term' => 0.0, 'end_term' => 0.0];
    //             } else {
    //                 $finalData[$subject]['class_assessment'] = + $data->percentage;
    //             }
    //         }
    //         foreach ($midTermBreakdown as $data) {
    //             $subject = $data->subject_id;
    //             $finalData[$subject]['subject_name'] = $data->subject->subject_name;
    //             if (!isset($finalData[$subject])) {
    //                 $finalData[$subject] = ['class_assessment' => 0.0, 'mid_term' => 0.0, 'end_term' => 0.0];
    //             } else {
    //                 $finalData[$subject]['mid_term'] = + $data->percentage;
    //             }
    //         }
    //         foreach ($endTermBreakdown as $data) {
    //             $subject = $data->subject_id;
    //             $finalData[$subject]['subject_name'] = $data->subject->subject_name;
    //             if (!isset($finalData[$subject])) {
    //                 $finalData[$subject] = ['class_assessment' => 0.0, 'mid_term' => 0.0, 'end_term' => 0.0];
    //             } else {
    //                 $finalData[$subject]['end_term'] = + $data->percentage;
    //             }
    //         }
    //         foreach ($finalData as $subject => $scores) {
    //             if (isset($scores['class_assessment'])) {
    //                 $scores['class_assessment'] ? $scores['class_assessment'] : 0;
    //             } else {
    //                 $scores['class_assessment'] = 0.0;
    //             }
    //             if (isset($scores['mid_term'])) {
    //                 $scores['mid_term'] ? $scores['mid_term'] : 0;
    //             } else {
    //                 $scores['mid_term'] = 0.0;
    //             }
    //             if (isset($scores['end_term'])) {
    //                 $scores['end_term'] ? $scores['end_term'] : 0;
    //             } else {
    //                 $scores['end_term'] = 0.0;
    //             }
    //             $finalData[$subject]['total'] = $scores['class_assessment'] + $scores['mid_term'] + $scores['end_term'] ;
    //         }
    //         foreach ($gradingSystem as $key => $value) {
    //             $level = $value['level_of_proficiency'];
    //             $grading[$level] = [
    //                 'grade' => $value['grade'],
    //                 'from' => $value['score_from'],
    //                 'to' => $value['score_to'],
    //                 'proficiency' => $value['level_of_proficiency']
    //             ];
    //         }
    //         foreach ($finalData as $subject => $score) {
    //             foreach ($grading as $level => $value) {
    //                 if ($score['total'] >= $value['from'] && $score['total'] <= $value['to']) {
    //                     $finalData[$subject]['grade'] = $value['grade'];
    //                     $finalData[$subject]['level'] = $value['proficiency'];
    //                 }
    //             }
    //         }

    //         $data = [
    //             'status' => 1,
    //             'notice' => 'record found',
    //             'levelData' => $levelData,
    //             'studentData' => $studentData,
    //             'schoolProfile' => $schoolProfile,
    //             'studentProfile' => $studentProfile,
    //             'classPercentageScore' => $classPercentageScore,
    //             'classTotalAssessment' => $classTotalAssessment,
    //             'midTermSummary' => $midTermSummary,
    //             'endTermFirst' => $endTermFirst,
    //             // 'midTermBreakdown' => $midTermBreakdown,
    //             // 'endTermBreakdown' => $endTermBreakdown,
    //             'schoolData' => $schoolData,
    //             'termData' => $termData,
    //             'schoolAssessmentPercentage' => $schoolAssessmentPercentage,
    //             'gradingSystem' => $gradingSystem,
    //             'finalData' => $finalData

    //         ];
    //     } else {
    //         $data = [
    //             'status' => 0,
    //             'notice' => 'No record found'
    //         ];
    //     }
    //     // dd($data);
    //     $pdf = Pdf::loadView("admin.dashboard.report.end-of-term.StudentEndTermReportDownload", compact('data'))
    //         ->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'landscape');
    //     return $pdf->stream($studentData->student_id . '_' . $studentData->student_firstname . '_'
    //         . $studentData->student_lastname . '_End_of_Term_Report.pdf');
    // }
}
