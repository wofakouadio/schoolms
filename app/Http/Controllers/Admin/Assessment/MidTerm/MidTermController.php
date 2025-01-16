<?php

namespace App\Http\Controllers\Admin\Assessment\MidTerm;

use App\Http\Controllers\Controller;
use App\Models\AssignSubjectToLevel;
use App\Models\MidTerm;
use App\Models\MidTermBreakdown;
use App\Models\StudentsAdmissions;
use App\Models\StudentsAcademicRecordsSummary;
use App\Models\StudentsAcademicRecords;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\TermAndAcademicYear;
use function App\Helpers\SchoolAssessmentPercentageSettings;

class MidTermController extends Controller
{
    //index
    public function index()
    {
        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $midTermPercentage = $SchoolAssessmentPercentageSettings->getData()->mid_term_percentage;
        $schoolTerm = TermAndAcademicYear();
        // $midTermRecords = MidTermBreakdown::with('midTerm', 'student', 'branch', 'term')
        //     ->where('school_id', Auth::guard('admin')->user()->school_id)
        //     ->orderBy('created_at', 'DESC')
        //     ->get();
        $midTermRecords = StudentsAcademicRecordsSummary::with('student', 'branch', 'term', 'level', 'academic_year')
            ->where([
                'school_id' => Auth::guard('admin')->user()->school_id,
                'term_id' => $schoolTerm->id,
                'academic_year_id' => $schoolTerm->term_academic_year
            ])->orderBy('created_at', 'DESC')
            ->get();
        // dd($midTermRecords);
        return view('admin.dashboard.assessment.mid-term.index', compact('schoolTerm', 'midTermPercentage', 'midTermRecords'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'mid_term' => 'required',
            'student' => 'required'
        ]);

        //let get student data
        $studentData = StudentsAdmissions::with('level')
            ->where('id', $request->student)
            ->where("school_id", Auth::guard('admin')->user()->school_id)
            ->where('admission_status', 1)
            ->first();

        //let get student subjects level assigned to mock
        $studentSubjectsLevel = AssignSubjectToLevel::with('subject')
            ->where('level_id', $request->level)
            ->where("school_id", Auth::guard('admin')->user()->school_id)
            ->get();
        //        dd($studentSubjectsLevel);
        //let get academic year
        $academicYearSession = Term::with('academic_year')->where("school_id", Auth::guard('admin')->user()->school_id)
            ->where("is_active", 1)
            ->first();

        $data = [
            'StudentData' => $studentData,
            'MidTerm' => $request->mid_term,
            'Subjects' => $studentSubjectsLevel,
            'Term' => $academicYearSession
        ];
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mid_term.*.score' => 'required|min:0|max:100|numeric'
        ]);

        $student_id = $request->studentId;
        $level_id = $request->level_id;
        $mid_term = $request->mid_term_name;
        $term_id = $request->term_id;
        $academic_year_id = $request->academic_year_id;
        $branch_id = $request->branch_id;

        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $midTermPercentage = $SchoolAssessmentPercentageSettings->getData()->mid_term_percentage;
        $school_id = Auth::guard('admin')->user()->school_id;

        DB::beginTransaction();
        try {
            $midTermScore = 0.0;
            $OverallTotalScore = 0.0;
            $OverallTotalPercentage = 0.0;
            // $midTermPercentage = 0;
            $midTermEntry = [];
            foreach ($request->mid_term as $key => $value) {
                // $midTermScore += $value['score'];
                $midTermEntry[] = [
                    'subject_id' => $value['subject_id'],
                    'score' => $value['score'],
                    'percentage' => (($value['score'] / 100) * $midTermPercentage)
                ];
                $OverallTotalScore = array_sum(array_column($midTermEntry, 'score'));

                // $totalPercentage = array_sum(array_column($midTermEntry, 'percentage'));
                // $OverallTotalPercentage = ($totalScore/(count($midTermEntry) * 100)) * $midTermPercentage;
            }
            // dd(count($midTermEntry));
            $OverallTotalPercentage = ($OverallTotalScore/(count($midTermEntry) * 100)) * $midTermPercentage;

            // dd(vars: $MidTermBreakdown);
            // get the total count of the mid term recorded based on the number of subjects
            // by default the mid-term score is over 100
            // $totalMidTermScore = count($midTermEntry) * 100;
            // get the total strike percentage value by the count of available score to be recorded
            // $totalStrikePercentage = $midTermPercentage * count($midTermEntry);
            //after getting the above we use the computation to get the total percentage mid term percentage dynamically
            // $midTermTotalPercentage = ($midTermScore / $totalMidTermScore) * $totalStrikePercentage;

            // $checkMidTerm = MidTerm::where([
            //     'student_id' => $request->studentId,
            //     'level_id' => $request->level_id,
            //     'mid_term' => $request->mid_term_name,
            //     'term_id' => $request->term_id,
            //     'school_id' => $school_id,
            //     'branch_id' => $request->branch_id
            // ])->first();

            // if (empty($checkMidTerm)) {
                $midTerm = MidTerm::create([
                    'student_id' => $request->studentId,
                    'level_id' => $request->level_id,
                    'mid_term' => $request->mid_term_name,
                    'term_id' => $request->term_id,
                    'total_score' => $OverallTotalScore,
                    'total_percentage' => $OverallTotalPercentage,
                    'school_id' => $school_id,
                    'branch_id' => $request->branch_id
                ]);

                foreach ($midTermEntry as $key => $value) {
                    MidTermBreakdown::create([
                        'mid_term_student_id' => $midTerm->id,
                        'student_id' => $request->studentId,
                        'mid_term' => $request->mid_term_name,
                        'term_id' => $request->term_id,
                        'subject_id' => $value['subject_id'],
                        'score' => $value['score'],
                        'percentage' => $value['percentage'],
                        'school_id' => $school_id,
                        'branch_id' => $request->branch_id
                    ]);
                }

                // let do some checks here to see if the student academic records summary exists based on the same subject
                // so we can update the records
                $studentAcademicRecordsSummaryExists = StudentsAcademicRecordsSummary::where([
                    'student_id' => $student_id,
                    'term_id' => $term_id,
                    'level_id' => $level_id,
                    'academic_year_id' => $academic_year_id,
                    'school_id' => $school_id,
                    'branch_id' => $branch_id
                ])->first();

                if (empty($studentAcademicRecordsSummaryExists)) {
                    // if no record exists, then we create a new record
                    StudentsAcademicRecordsSummary::create([
                        'student_id' => $student_id,
                        'academic_year_id' => $academic_year_id,
                        'term_id' => $term_id,
                        'level_id' => $level_id,
                        'mid_term_total_score' => $OverallTotalScore,
                        'mid_term_total_score_percentage' => $OverallTotalPercentage,
                        'total_score' => $OverallTotalScore,
                        'total_score_percentage' => $OverallTotalPercentage,
                        'school_id' => $school_id,
                        'branch_id' => $branch_id
                    ]);
                } else {
                    $old_cas = $studentAcademicRecordsSummaryExists->class_total_score ?? 0.0;
                    $old_cas_percentage = $studentAcademicRecordsSummaryExists->class_total_score_percentage ?? 0.0;
                    $old_ets = $studentAcademicRecordsSummaryExists->end_term_total_score ?? 0.0;
                    $old_ets_percentage = $studentAcademicRecordsSummaryExists->end_term_total_score_percentage ?? 0.0;
                    $studentAcademicRecordsSummaryExists->update([
                        'mid_term_total_score' => $OverallTotalScore,
                        'mid_term_total_score_percentage' => $OverallTotalPercentage,
                        'total_score' => $OverallTotalScore + $old_cas + $old_ets,
                        'total_score_percentage' => $OverallTotalPercentage + $old_cas_percentage + $old_ets_percentage
                    ]);
                }

                foreach ($midTermEntry as $key => $value) {
                    $MidTermBreakdown = MidTermBreakdown::where([
                        'mid_term_student_id' => $midTerm->id,
                        'student_id' => $request->studentId,
                        'mid_term' => $request->mid_term_name,
                        'term_id' => $request->term_id,
                        'subject_id' => $value['subject_id'],
                        'school_id' => $school_id,
                        'branch_id' => $request->branch_id
                    ])->get();

                    foreach ($MidTermBreakdown as $breakdown) {
                        $mid_term_breakdown_id = $breakdown->id;

                        $studentAcademicRecordsExists = StudentsAcademicRecords::where([
                            'student_id' => $student_id,
                            'term_id' => $term_id,
                            'level_id' => $level_id,
                            'academic_year_id' => $academic_year_id,
                            'subject_id' => $value['subject_id'],
                            'school_id' => $school_id,
                            'branch_id' => $branch_id
                        ])->first();

                        if (empty($studentAcademicRecordsExists)) {
                            StudentsAcademicRecords::create([
                                'student_id' => $student_id,
                                'academic_year_id' => $academic_year_id,
                                'term_id' => $term_id,
                                'level_id' => $level_id,
                                'subject_id' => $value['subject_id'],
                                'mid_term_id' => $mid_term_breakdown_id,
                                'mid_term_raw_score' => $value['score'],
                                'mid_term_percentage' => $value['percentage'],
                                'total_raw_score' => $$value['score'],
                                'total_percentage_score' => $$value['percentage'],
                                'school_id' => $school_id,
                                'branch_id' => $branch_id
                            ]);
                        } else {
                            $old_cars = $studentAcademicRecordsExists->class_assessment_raw_score;
                            $old_cars_percentage = $studentAcademicRecordsExists->class_assessment_percentage;
                            $old_ets = $studentAcademicRecordsExists->end_term_raw_score;
                            $old_ets_percentage = $studentAcademicRecordsExists->end_term_percentage;
                            $studentAcademicRecordsExists->update([
                                'mid_term_id' => $mid_term_breakdown_id,
                                'mid_term_raw_score' => $value['score'],
                                'mid_term_percentage' => $value['percentage'],
                                'total_raw_score' => $value['score'] + $old_cars + $old_ets,
                                'total_percentage_score' => $value['percentage'] + $old_cars_percentage + $old_ets_percentage
                            ]);
                        }
                    }
                    // $studentAcademicRecordsExists = StudentsAcademicRecords::where([
                    //     'student_id' => $student_id,
                    //     'term_id' => $term_id,
                    //     'level_id' => $level_id,
                    //     'academic_year_id' => $academic_year_id,
                    //     'subject_id' => $value['subject_id'],
                    //     'school_id' => $school_id,
                    //     'branch_id' => $branch_id
                    // ])->first();

                    // if (empty($studentAcademicRecordsExists)) {
                    //     StudentsAcademicRecords::create([
                    //         'student_id' => $student_id,
                    //         'academic_year_id' => $academic_year_id,
                    //         'term_id' => $term_id,
                    //         'level_id' => $level_id,
                    //         'subject_id' => $value['subject_id'],
                    //         'mid_term_id' => $$midTerm->id,
                    //         'mid_term_raw_score' => $value['score'],
                    //         'mid_term_percentage' => $value['percentage'],
                    //         'total_raw_score' => $totalScore,
                    //         'total_percentage_score' => $totalPercentage,
                    //         'school_id' => $school_id,
                    //         'branch_id' => $branch_id
                    //     ]);
                    // } else {
                    //     $old_cars = $studentAcademicRecordsExists->class_assessment_raw_score;
                    //     $old_cars_percentage = $studentAcademicRecordsExists->class_assessment_percentage;
                    //     $old_ets = $studentAcademicRecordsExists->end_term_raw_score;
                    //     $old_ets_percentage = $studentAcademicRecordsExists->end_term_percentage;
                    //     $studentAcademicRecordsExists->update([
                    //         'mid_term_id' => $midTerm->id,
                    //         'mid_term_raw_score' => $value['score'],
                    //         'mid_term_percentage' => $value['percentage'],
                    //         'total_raw_score' => $value['score'] + $old_cars + $old_ets,
                    //         'total_percentage_score' => $value['percentage'] + $old_cars_percentage + $old_ets_percentage
                    //     ]);
                    // }
                }
            // }
            // else{
            //     // update mid term records
            //     $midTerm = MidTerm::where([
            //         'student_id' => $request->studentId,
            //         'level_id' => $request->level_id,
            //         'mid_term' => $request->mid_term_name,
            //         'term_id' => $request->term_id,
            //         'school_id' => $school_id,
            //         'branch_id' => $request->branch_id
            //     ])->update([
            //         'total_score' => $midTermScore,
            //         'total_percentage' => $midTermTotalPercentage
            //     ]);
            //     // update mid term breakdown records
            //     foreach ($midTermEntry as $key => $value) {
            //         MidTermBreakdown::where([
            //             'student_id' => $request->studentId,
            //             'mid_term' => $request->mid_term_name,
            //             'term_id' => $request->term_id,
            //             'subject_id' => $value['subject_id'],
            //             'school_id' => $school_id,
            //             'branch_id' => $request->branch_id
            //         ])->update([
            //             'score' => $value['score'],
            //             'percentage' => $value['percentage']
            //         ]);
            //     }
            //     // update student academic records summary
            //     // let do some checks here to see if the student academic records summary exists based on the same subject
            //     // so we can update the records
            //     $studentAcademicRecordsSummaryExists = StudentsAcademicRecordsSummary::where([
            //         'student_id' => $student_id,
            //         'term_id' => $term_id,
            //         'level_id' => $level_id,
            //         'academic_year_id' => $academic_year_id,
            //         'school_id' => $school_id,
            //         'branch_id' => $branch_id
            //     ])->first();

            //     if (empty($studentAcademicRecordsSummaryExists)) {
            //         // if no record exists, then we create a new record
            //         StudentsAcademicRecordsSummary::create([
            //             'student_id' => $student_id,
            //             'academic_year_id' => $academic_year_id,
            //             'term_id' => $term_id,
            //             'level_id' => $level_id,
            //             'mid_term_total_score' => $midTermScore,
            //             'mid_term_total_score_percentage' => $midTermTotalPercentage,
            //             'total_score' => $midTermScore,
            //             'total_score_percentage' => $midTermTotalPercentage,
            //             'school_id' => $school_id,
            //             'branch_id' => $branch_id
            //         ]);
            //     } else {
            //         $old_score_record = $studentAcademicRecordsSummaryExists->mid_term_total_score;
            //         $old_percentage_record = $studentAcademicRecordsSummaryExists->mid_term_total_score_percentage;
            //         $new_score_record = $old_score_record + $midTermScore;
            //         $new_percentage_record = $old_percentage_record + $midTermTotalPercentage;
            //         $studentAcademicRecordsSummaryExists->update([
            //             'mid_term_total_score' => $new_score_record,
            //             'mid_term_total_score_percentage' => $new_percentage_record,
            //             'total_score' => $new_score_record,
            //             'total_score_percentage' => $new_percentage_record
            //         ]);
            //     }

            //     foreach ($midTermEntry as $key => $value) {
            //         $MidTermBreakdown = MidTermBreakdown::where([
            //             'student_id' => $request->studentId,
            //             'mid_term' => $request->mid_term_name,
            //             'term_id' => $request->term_id,
            //             'subject_id' => $value['subject_id'],
            //             'school_id' => $school_id,
            //             'branch_id' => $request->branch_id
            //         ])->first();

            //         $studentAcademicRecordsExists = StudentsAcademicRecords::where([
            //             'student_id' => $student_id,
            //             'term_id' => $term_id,
            //             'level_id' => $level_id,
            //             'academic_year_id' => $academic_year_id,
            //             'subject_id' => $value['subject_id'],
            //             'school_id' => $school_id,
            //             'branch_id' => $branch_id
            //         ])->first();

            //         if (empty($studentAcademicRecordsExists)) {
            //             StudentsAcademicRecords::create([
            //                 'student_id' => $student_id,
            //                 'academic_year_id' => $academic_year_id,
            //                 'term_id' => $term_id,
            //                 'level_id' => $level_id,
            //                 'subject_id' => $value['subject_id'],
            //                 'mid_term_id' => $MidTermBreakdown->mid_term_student_id,
            //                 'mid_term_raw_score' => $value['score'],
            //                 'mid_term_percentage' => $value['percentage'],
            //                 'total_raw_score' => $value['score'],
            //                 'total_percentage_score' => $value['percentage'],
            //                 'school_id' => $school_id,
            //                 'branch_id' => $branch_id
            //             ]);
            //         } else {
            //             $old_mid_term_raw_score = $studentAcademicRecordsExists->mid_term_raw_score;
            //             $old_mid_term_percentage = $studentAcademicRecordsExists->mid_term_percentage;
            //             $new_mid_term_raw_score = $old_mid_term_raw_score + $value['score'];
            //             $new_mid_term_percentage = $old_mid_term_percentage + $value['percentage'];
            //             $studentAcademicRecordsExists->update([
            //                 'mid_term_raw_score' => $new_mid_term_raw_score,
            //                 'mid_term_percentage' => $new_mid_term_percentage,
            //                 'total_raw_score' => $new_mid_term_raw_score,
            //                 'total_percentage_score' => $new_mid_term_percentage
            //             ]);
            //         }
            //     }

            // }


            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Student Mid-Term Entry saved successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }
}
