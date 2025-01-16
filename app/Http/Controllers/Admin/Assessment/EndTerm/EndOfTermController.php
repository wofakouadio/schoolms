<?php

namespace App\Http\Controllers\Admin\Assessment\EndTerm;

use App\Models\Term;
use App\Models\EndOfTerm;
use Illuminate\Http\Request;
use App\Models\GradingSystem;
use App\Models\MockBreakdown;
use App\Models\ClassAssessment;
use App\Models\MidTermBreakdown;
use App\Models\EndOfTermBreakdown;
use App\Models\StudentsAdmissions;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AssignSubjectToLevel;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassAssessmentSettings;
use App\Models\StudentsAcademicRecords;
use function App\Helpers\TermAndAcademicYear;
use App\Models\StudentsAcademicRecordsSummary;

use App\Models\ClassAssessmentTotalScoreRecord;
use function App\Helpers\SchoolAssessmentPercentageSettings;

class EndOfTermController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $exam_percentage = $SchoolAssessmentPercentageSettings->getData()->exam_percentage;
        // $EndTermRecords = EndOfTermBreakdown::with('end_term', 'student', 'branch', 'term')
        //     ->where('school_id', Auth::guard('admin')->user()->school_id)
        //     ->orderBy('created_at', 'DESC')
        //     ->get();
        $EndTermRecords = StudentsAcademicRecordsSummary::with('student', 'branch', 'term', 'level', 'academic_year')
        ->where([
            'school_id' => Auth::guard('admin')->user()->school_id,
            'term_id' => $schoolTerm->id,
            'academic_year_id' => $schoolTerm->term_academic_year
        ])->orderBy('created_at', 'DESC')->get();

        return view('admin.dashboard.assessment.end-of-term.index', compact('schoolTerm', 'exam_percentage', 'EndTermRecords'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'student' => 'required'
        ]);

        // $schoolTerm = TermAndAcademicYear();

        //let get student data
        $studentData = StudentsAdmissions::with('level')
            ->where(["school_id" => Auth::guard('admin')->user()->school_id, 'admission_status' => 1, 'id' => $request->student])
            ->first();

        //let get student subjects level assigned to mock
        $studentSubjectsLevel = AssignSubjectToLevel::with('subject')
            ->where(['level_id' => $request->level, "school_id" => Auth::guard('admin')->user()->school_id])
            ->get();

        //let get academic year
        $academicYearSession = Term::with('academic_year')
            ->where(["school_id" => Auth::guard('admin')->user()->school_id, "is_active" => 1])
            ->first();

        //let get student class records
        // $studentClassAssessment = ClassAssessmentTotalScoreRecord::with(['subject', 'mid_term'])->where([
        //     'student_id' => $request->student,
        //     'term_id' => $academicYearSession->id,
        //     'level_id' => $request->level,
        //     'academic_year_id' => $academicYearSession->term_academic_year,
        //     'school_id' => Auth::guard('admin')->user()->school_id
        // ])->get();

        //get school Assessment set
        // $schoolAssessmentSettings = ClassAssessmentSettings::where([
        //     'school_id' => Auth::guard('admin')->user()->school_id,
        //     'academic_year_id' => $academicYearSession->term_academic_year,
        // ])->first();

        // if(empty($schoolAssessmentSettings)) {
        //     $classPercentage = config('assessment-settings.class_percentage');
        //     $examPercentage = config('assessment-settings.exam_percentage');
        // } else {
        //     $classPercentage = $schoolAssessmentSettings->class_percentage;
        //     $examPercentage = $schoolAssessmentSettings->exam_percentage;
        // }

        $data = [
            "StudentData" => $studentData,
            "Subjects" => $studentSubjectsLevel,
            "Term" => $academicYearSession
        ];

        return response()->json($data);

        // return view('admin.dashboard.assessment.end-of-term.EndTermForm',
        //     compact('studentData',
        //         'studentSubjectsLevel',
        //         'academicYearSession',
        //         'studentClassAssessment',
        //         'schoolTerm',
        //         'classPercentage',
        //         'examPercentage',
        //     ));
    }

    // method to get grading system to be used in the end of term entry
    private function getGradingSystem($academic_year_id, $school_id, $percentage) {
        $GradingSystem = GradingSystem::where([
            'academic_year' => $academic_year_id,
            'is_active' => 1,
            'school_id' => $school_id,
        ])->orderBy('grade', 'ASC')->get();

        foreach($GradingSystem as $grading) {
            if($grading['score_from'] <= $percentage && $percentage <= $grading['score_to']) {
                return [
                    'grade_id' => $grading['id'],
                    'grade_level' => $grading['grade'],
                    'grade_proficiency_level' => $grading['level_of_proficiency']
                ];
            }
        }
        return [];
    }
    // method to save or update end of term entry
    private function SaveOrUpdateEndOfTerm($student_id, $level_id, $term_id, $total_score, $total_percentage, $conduct, $attitude, $interest, $general_remarks, $school_id, $branch_id){
        // check if record exists
        $checkEndOfTerm = EndOfTerm::where([
            'student_id' => $student_id,
            'level_id' => $level_id,
            'term_id' => $term_id,
            'school_id' => $school_id,
            'branch_id' => $branch_id
        ])->first();

        if(empty($checkEndOfTerm)) {
            // if no record exists, then we create a new record
            $EndTerm = EndOfTerm::create([
                'student_id' => $student_id,
                'level_id' => $level_id,
                'term_id' => $term_id,
                'total_score' => $total_score,
                'total_percentage' => $total_percentage,
                'conduct' => $conduct,
                'attitude' => $attitude,
                'interest' => $interest,
                'general_remarks' => $general_remarks,
                'school_id' => $school_id,
                'branch_id' => $branch_id
            ]);
        } else {
            // if record exists, then we update the record
            $EndTerm = $checkEndOfTerm->update([
                'total_score' => $total_score,
                'total_percentage' => $total_percentage,
                'conduct' => $conduct,
                'attitude' => $attitude,
                'interest' => $interest,
                'general_remarks' => $general_remarks,
            ]);
        }
        // dd($EndTerm);
        // return $EndTerm;
    }

    // method to save or update end of term breakdown
    private function SaveOrUpdateEndOfTermBreakdown($endTermEntry, $student_id, $term_id, $level_id, $school_id, $branch_id){

        $checkEndOfTerm = EndOfTerm::where([
            'student_id' => $student_id,
            'level_id' => $level_id,
            'term_id' => $term_id,
            'school_id' => $school_id,
            'branch_id' => $branch_id
        ])->first();

        // dd($endTermEntry);

        foreach ($endTermEntry as $value) {

            // $test[] = [
            //     'subject' => $value['subject_id'],
            //     'score' => $value['score'],
            //     'percentage' => $value['percentage']
            // ];

            $checkEndOfTermBreakdown = EndOfTermBreakdown::where([
                'end_term_student_id' => $checkEndOfTerm->id,
                'student_id' => $student_id,
                'term_id' => $term_id,
                'subject_id' => $value['subject_id'],
                'school_id' => $school_id,
                'branch_id' => $branch_id
            ])->get();

            // dd($checkEndOfTermBreakdown);

            if($checkEndOfTermBreakdown->isEmpty()) {
                // if no record exists, then we create a new record
                EndOfTermBreakdown::create([
                    'end_term_student_id' => $checkEndOfTerm->id,
                    'student_id' => $student_id,
                    'term_id' => $term_id,
                    'subject_id' => $value['subject_id'],
                    'score' => $value['score'],
                    'percentage' => $value['percentage'],
                    'school_id' => $school_id,
                    'branch_id' => $branch_id
                ]);
            } else {
                // if record exists, then we update the record
                EndOfTermBreakdown::where([
                    'student_id' => $student_id,
                    'term_id' => $term_id,
                    'subject_id' => $value['subject_id'],
                    'school_id' => $school_id,
                    'branch_id' => $branch_id
                ])->update([
                    'end_term_student_id' => $checkEndOfTerm->id,
                    'score' => $value['score'],
                    'percentage' => $value['percentage']
                ]);
            }
        }
        // dd($checkEndOfTermBreakdown);
    }

    // method to store or update student academic records summary
    private function SaveOrUpdateStudentAcademicRecordsSummary($student_id, $academic_year_id, $term_id, $level_id, $end_term_total_score, $end_term_total_percentage, $conduct, $attitude, $interest, $general_remarks, $school_id, $branch_id){

        // check if student records summary exists
        $studentAcademicRecordsSummaryExists = StudentsAcademicRecordsSummary::where([
            'student_id' => $student_id,
            'term_id' => $term_id,
            'level_id' => $level_id,
            'academic_year_id' => $academic_year_id,
            'school_id' => $school_id,
            'branch_id' => $branch_id
        ])->first();

        // if empty, create a new record
        if(empty($studentAcademicRecordsSummaryExists)){

            $grading_system = $this->getGradingSystem($academic_year_id, $school_id, $end_term_total_percentage);

            StudentsAcademicRecordsSummary::create([
                'student_id' => $student_id,
                'academic_year_id' => $academic_year_id,
                'term_id' => $term_id,
                'level_id' => $level_id,
                'end_term_total_score' => $end_term_total_score,
                'end_term_total_score_percentage' => $end_term_total_percentage,
                'total_score' => $end_term_total_score,
                'total_score_percentage' => $end_term_total_percentage,
                'grade_id' => $grading_system['grade_id'],
                'grade_level' => $grading_system['grade_level'],
                'grade_proficiency_level' => $grading_system['grade_proficiency_level'],
                'conduct' => $conduct,
                'attitude' => $attitude,
                'interest' => $interest,
                'general_remarks' => $general_remarks,
                'school_id' => $school_id,
                'branch_id' => $branch_id
            ]);
        }else{
            $old_cas = $studentAcademicRecordsSummaryExists->class_total_score ?? 0.0;
            $old_cas_percentage = $studentAcademicRecordsSummaryExists->class_total_score_percentage ?? 0.0;
            $old_mts = $studentAcademicRecordsSummaryExists->mid_term_total_score ?? 0.0;
            $old_mts_percentage = $studentAcademicRecordsSummaryExists->mid_term_total_score_percentage ?? 0.0;

            $new_total_score = $end_term_total_score + $old_cas + $old_mts;
            $new_total_percentage = $end_term_total_percentage + $old_cas_percentage + $old_mts_percentage;

            $grading_system = $this->getGradingSystem($academic_year_id, $school_id, $new_total_percentage);

            $studentAcademicRecordsSummaryExists->update([
                'end_term_total_score' => $end_term_total_score,
                'end_term_total_score_percentage' => $end_term_total_percentage,
                'total_score' => $new_total_score,
                'total_score_percentage' => $new_total_percentage,
                'grade_id' => $grading_system['grade_id'],
                'grade_level' => $grading_system['grade_level'],
                'grade_proficiency_level' => $grading_system['grade_proficiency_level'],
                'conduct' => $conduct,
                'attitude' => $attitude,
                'interest' => $interest,
                'general_remarks' => $general_remarks,
            ]);
        }

        // dd($grading_system['grade_id']);
    }

    // method to save or update student academic records
    private function SaveOrUpdateStudentAcademicRecords($endTermEntry, $student_id, $term_id, $level_id, $academic_year_id, $school_id, $branch_id){
        $test = [];

        $checkEndOfTerm = EndOfTerm::where([
            'student_id' => $student_id,
            'level_id' => $level_id,
            'term_id' => $term_id,
            'school_id' => $school_id,
            'branch_id' => $branch_id
        ])->first();

        foreach($endTermEntry as $key => $value){
            // Retrieve relevant EndOfTermBreakdown records
            $EndOfTermBreakdown = EndOfTermBreakdown::where([
                'end_term_student_id' => $checkEndOfTerm->id,
                'student_id' => $student_id,
                'term_id' => $term_id,
                'subject_id' => $value['subject_id'],
                'school_id' => $school_id,
                'branch_id' => $branch_id
            ])->first();

            // skip if no records was found
            if (!$EndOfTermBreakdown) {
                continue;
            }

            $end_term_breakdown_id = $EndOfTermBreakdown->id;

            // Check if academic records already exist
            $studentAcademicRecordsExists = StudentsAcademicRecords::where([
                'student_id' => $student_id,
                'term_id' => $term_id,
                'level_id' => $level_id,
                'academic_year_id' => $academic_year_id,
                'subject_id' => $value['subject_id'],
                'school_id' => $school_id,
                'branch_id' => $branch_id
            ])->first();

            // if no record exists, then we create a new record
            if(empty($studentAcademicRecordsExists)){

                $grading = $this->getGradingSystem($academic_year_id, $school_id, $value['percentage']);

                // Find the grade for the current percentage
                // $grading = collect($grading_system)->first(function ($grading) use ($value) {
                //     return $grading['score_from'] <= $value['percentage'] && $value['percentage'] <= $grading['score_to'];
                // });

                // if ($grading) {
                    StudentsAcademicRecords::create([
                        'student_id' => $student_id,
                        'academic_year_id' => $academic_year_id,
                        'term_id' => $term_id,
                        'level_id' => $level_id,
                        'subject_id' => $value['subject_id'],
                        'end_term_id' => $end_term_breakdown_id,
                        'end_term_raw_score' => $value['score'],
                        'end_term_percentage' => $value['percentage'],
                        'total_raw_score' => $value['score'],
                        'total_percentage_score' => $value['percentage'],
                        'grade_id' => $grading['grade_id'],
                        'grade_level' => $grading['grade_level'],
                        'grade_proficiency_level' => $grading['grade_proficiency_level'],
                        'school_id' => $school_id,
                        'branch_id' => $branch_id
                    ]);
                // }else{
                    // Update existing record
                    // $new_total_raw_score = $value['score'] + $studentAcademicRecordsExists->class_assessment_raw_score + $studentAcademicRecordsExists->mid_term_raw_score;
                    // $new_total_raw_percentage = $value['percentage'] + $studentAcademicRecordsExists->class_assessment_percentage + $studentAcademicRecordsExists->mid_term_percentage;

                    // $UpdatedGrading = $this->getGradingSystem($academic_year_id, $school_id, $new_total_raw_percentage);

                    // if ($grading) {
                    //     $studentAcademicRecordsExists->update([
                    //         'end_term_id' => $end_term_breakdown_id,
                    //         'end_term_raw_score' => $value['score'],
                    //         'end_term_percentage' => $value['percentage'],
                    //         'total_raw_score' => $new_total_raw_score,
                    //         'total_percentage_score' => $new_total_raw_percentage,
                    //         'grade_id' => $UpdatedGrading['grade_id'],
                    //         'grade_level' => $UpdatedGrading['grade_level'],
                    //         'grade_proficiency_level' => $UpdatedGrading['grade_proficiency_level'],
                    //     ]);
                    // }

                // }
            }else{
                $grading = $this->getGradingSystem($academic_year_id, $school_id, $value['percentage']);

                $new_total_raw_score = $value['score'] + $studentAcademicRecordsExists->class_assessment_raw_score + $studentAcademicRecordsExists->mid_term_raw_score;
                    $new_total_raw_percentage = $value['percentage'] + $studentAcademicRecordsExists->class_assessment_percentage + $studentAcademicRecordsExists->mid_term_percentage;

                $UpdatedGrading = $this->getGradingSystem($academic_year_id, $school_id, $new_total_raw_percentage);

                     // Find the grade for the current percentage
                // $grading = collect($grading_system)->first(function ($grading) use ($new_total_raw_percentage) {
                //     return $grading['score_from'] <= $new_total_raw_percentage && $new_total_raw_percentage <= $grading['score_to'];
                // });

                if ($grading) {
                    $studentAcademicRecordsExists->update([
                        'end_term_id' => $end_term_breakdown_id,
                        'end_term_raw_score' => $value['score'],
                        'end_term_percentage' => $value['percentage'],
                        'total_raw_score' => $new_total_raw_score,
                        'total_percentage_score' => $new_total_raw_percentage,
                        'grade_id' => $UpdatedGrading['grade_id'],
                        'grade_level' => $UpdatedGrading['grade_level'],
                        'grade_proficiency_level' => $UpdatedGrading['grade_proficiency_level'],
                    ]);
                }

            }

            // $test[] = $grading;
        }

        // dd($test);
    }

    public function store(Request $request){
        $request->validate([
            'end_term.*.score' => 'required|numeric|min:0|max:100'
        ]);
        $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
        $exam_percentage = $SchoolAssessmentPercentageSettings->getData()->exam_percentage;
        $student_id = $request->studentId;
        $level_id = $request->level_id;
        $term_id = $request->term_id;
        $conduct = $request->conduct;
        $attitude = $request->attitude;
        $interest = $request->interest;
        $general_remarks = $request->general_remarks;
        $branch_id = $request->branch_id;
        $school_id = Auth::guard('admin')->user()->school_id;
        $academic_year_id = $request->academic_year_id;

        DB::beginTransaction();
        try{

            $total_score = 0.0;
            $totalOverallScore = 0.0;
            $totalOverallPercentage = 0.0;
            $endTermEntry = [];
            $grade_id = '';
            $grade_level = '';
            $grade_proficiency_level = '';
            $grade_id_per_subject = '';
            $grade_level_per_subject = '';
            $grade_proficiency_level_per_subject = '';

            foreach ($request->end_term as $key => $value) {
                $endTermEntry[] = [
                    'subject_id' => $value['subject_id'],
                    'score' => $value['score'],
                    'percentage' => ($value['score'] / 100) * $exam_percentage
                ];
                $totalOverallScore = array_sum(array_column($endTermEntry, 'score'));
            }
            $totalOverallPercentage = ($totalOverallScore / (count($endTermEntry) * 100)) * $exam_percentage;

            // dd($endTermEntry);

            // $v = [];
            // foreach($endTermEntry as $key => $value){
            //     $total_score += $value['score'];
            //     $v[] = $this->getGradingSystem($academic_year_id, $school_id, $value['percentage']);
            // }

            // dd($v);

            $this->SaveOrUpdateEndOfTerm($student_id, $level_id, $term_id, total_score: $totalOverallScore, total_percentage: $totalOverallPercentage, conduct: $conduct, attitude: $attitude, interest: $interest, general_remarks: $general_remarks, school_id: $school_id, branch_id: $branch_id);

            $this->SaveOrUpdateEndOfTermBreakdown( $endTermEntry, $student_id, $term_id, level_id: $level_id, school_id: $school_id, branch_id: $branch_id);

            $this->SaveOrUpdateStudentAcademicRecordsSummary($student_id, $academic_year_id, $term_id, level_id: $level_id, end_term_total_score: $totalOverallScore, end_term_total_percentage: $totalOverallPercentage, conduct: $conduct, attitude: $attitude, interest: $interest, general_remarks: $general_remarks, school_id: $school_id, branch_id: $branch_id);

            $this->SaveOrUpdateStudentAcademicRecords($endTermEntry, $student_id, $term_id, $level_id, $academic_year_id, $school_id, $branch_id);

            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Student End of Term Entry saved successfully'
            ]);

        }catch(\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    // public function OldStore(Request $request)
    // {
    //     $request->validate([
    //         'end_term.*.score' => 'required|numeric|min:0|max:100'
    //     ]);
    //     $SchoolAssessmentPercentageSettings = SchoolAssessmentPercentageSettings();
    //     $exam_percentage = $SchoolAssessmentPercentageSettings->getData()->exam_percentage;
    //     $student_id = $request->studentId;
    //     $level_id = $request->level_id;
    //     $term_id = $request->term_id;
    //     $conduct = $request->conduct;
    //     $attitude = $request->attitude;
    //     $interest = $request->interest;
    //     $general_remarks = $request->general_remarks;
    //     $branch_id = $request->branch_id;
    //     $school_id = Auth::guard('admin')->user()->school_id;
    //     $academic_year_id = $request->academic_year_id;

    //     DB::beginTransaction();
    //     try {
    //         $total_score = 0.0;
    //         $totalOverallScore = 0.0;
    //         $totalOverallPercentage = 0.0;
    //         $endTermEntry = [];
    //         $grade_id = '';
    //         $grade_level = '';
    //         $grade_proficiency_level = '';
    //         $grade_id_per_subject = '';
    //         $grade_level_per_subject = '';
    //         $grade_proficiency_level_per_subject = '';

    //         $gradingSystem = GradingSystem::where([
    //             'academic_year' => $academic_year_id,
    //             'is_active' => 1,
    //             'school_id' => $school_id,
    //         ])->orderBy('grade', 'ASC')->get();

    //         // dd($gradingSystem);
    //         foreach ($request->end_term as $key => $value) {
    //             // $total_score += $value['score'];
    //             $endTermEntry[] = [
    //                 'subject_id' => $value['subject_id'],
    //                 'score' => $value['score'],
    //                 'percentage' => ($value['score'] / 100) * $exam_percentage
    //             ];
    //             $totalOverallScore = array_sum(array_column($endTermEntry, 'score'));
    //         }
    //         $totalOverallPercentage = ($totalOverallScore / (count($endTermEntry) * 100)) * $exam_percentage;

    //         $EndTerm = EndOfTerm::create([
    //             'student_id' => $student_id,
    //             'level_id' => $level_id,
    //             'term_id' => $term_id,
    //             'total_score' => $totalOverallScore,
    //             'total_percentage' => $totalOverallPercentage,
    //             'conduct' => $conduct,
    //             'attitude' => $attitude,
    //             'interest' => $interest,
    //             'general_remarks' => $general_remarks,
    //             'school_id' => $school_id,
    //             'branch_id' => $branch_id
    //         ]);

    //         foreach ($endTermEntry as $key => $value) {
    //             EndOfTermBreakdown::create([
    //                 'end_term_student_id' => $EndTerm->id,
    //                 'student_id' => $student_id,
    //                 'term_id' => $term_id,
    //                 'subject_id' => $value['subject_id'],
    //                 'score' => $value['score'],
    //                 'percentage' => $value['percentage'],
    //                 'school_id' => $school_id,
    //                 'branch_id' => $branch_id
    //             ]);
    //         }

    //         // let do some checks here to see if the student academic records summary exists based on the same subject
    //         // so we can update the records
    //         $studentAcademicRecordsSummaryExists = StudentsAcademicRecordsSummary::where([
    //             'student_id' => $student_id,
    //             'term_id' => $term_id,
    //             'level_id' => $level_id,
    //             'academic_year_id' => $academic_year_id,
    //             'school_id' => $school_id,
    //             'branch_id' => $branch_id
    //         ])->first();

    //         // get grading system
    //         // $gradingSystem = GradingSystem::where([
    //         //     'academic_year' => $academic_year_id,
    //         //     'is_active' => 1,
    //         //     'school_id' => $school_id,
    //         // ])->get();

    //         /*** STUDENT ACADEMIC RECORDS SUMMARY START ***/
    //         if (empty($studentAcademicRecordsSummaryExists)) {
    //             // if no record exists, then we create a new record
    //             // implementing grading system for the new overall total score and the new overall total percentage
    //             foreach($gradingSystem as $grading) {
    //                 if($grading['score_from'] <= $totalOverallPercentage && $totalOverallPercentage <= $grading['score_to']) {
    //                     $grade_id = $grading['id'];
    //                     $grade_level = $grading['grade'];
    //                     $grade_proficiency_level = $grading['level_of_proficiency'];
    //                 }
    //                 StudentsAcademicRecordsSummary::create([
    //                     'student_id' => $student_id,
    //                     'academic_year_id' => $academic_year_id,
    //                     'term_id' => $term_id,
    //                     'level_id' => $level_id,
    //                     'end_term_total_score' => $totalOverallScore,
    //                     'end_term_total_score_percentage' => $totalOverallPercentage,
    //                     'total_score' => $totalOverallScore,
    //                     'total_score_percentage' => $totalOverallPercentage,
    //                     'grade_id' => $grade_id,
    //                     'grade_level' => $grade_level,
    //                     'grade_proficiency_level' => $grade_proficiency_level,
    //                     'conduct' => $conduct,
    //                     'attitude' => $attitude,
    //                     'interest' => $interest,
    //                     'general_remarks' => $general_remarks,
    //                     'school_id' => $school_id,
    //                     'branch_id' => $branch_id
    //                 ]);
    //             }
    //         } else {
    //             $old_cas = $studentAcademicRecordsSummaryExists->class_total_score ?? 0.0;
    //             $old_cas_percentage = $studentAcademicRecordsSummaryExists->class_total_score_percentage ?? 0.0;
    //             $old_mts = $studentAcademicRecordsSummaryExists->mid_term_total_score ?? 0.0;
    //             $old_mts_percentage = $studentAcademicRecordsSummaryExists->mid_term_total_score_percentage ?? 0.0;

    //             $new_totalOverallScore = $totalOverallScore + $old_cas + $old_mts;
    //             $new_totalOverallPercentage = $totalOverallPercentage + $old_cas_percentage + $old_mts_percentage;


    //             // implementing grading system for the updated overall total score and the updated overall total percentage
    //             foreach($gradingSystem as $grading) {
    //                 if($grading['score_from'] <= $new_totalOverallPercentage && $new_totalOverallPercentage <= $grading['score_to']) {
    //                     $grade_id = $grading['id'];
    //                     $grade_level = $grading['grade'];
    //                     $grade_proficiency_level = $grading['level_of_proficiency'];
    //                 }
    //                 $studentAcademicRecordsSummaryExists->update([
    //                     'end_term_total_score' => $totalOverallScore,
    //                     'end_term_total_score_percentage' => $totalOverallPercentage,
    //                     'total_score' => $new_totalOverallScore,
    //                     'total_score_percentage' => $new_totalOverallPercentage,
    //                     'grade_id' => $grade_id,
    //                     'grade_level' => $grade_level,
    //                     'grade_proficiency_level' => $grade_proficiency_level,
    //                     'conduct' => $conduct,
    //                     'attitude' => $attitude,
    //                     'interest' => $interest,
    //                     'general_remarks' => $general_remarks,
    //                 ]);
    //             }
    //         }
    //         /*** STUDENT ACADEMIC RECORDS SUMMARY END ***/

    //         /*** STUDENT ACADEMIC RECORDS START ***/
    //         foreach ($endTermEntry as $key => $value) {
    //             $EndOfTermBreakdown = EndOfTermBreakdown::where([
    //                 'end_term_student_id' => $EndTerm->id,
    //                 'student_id' => $student_id,
    //                 'term_id' => $term_id,
    //                 'subject_id' => $value['subject_id'],
    //                 'school_id' => $school_id,
    //                 'branch_id' => $branch_id
    //             ])->get();

    //             foreach ($EndOfTermBreakdown as $breakdown) {
    //                 $end_term_breakdown_id = $breakdown->id;

    //                 $studentAcademicRecordsExists = StudentsAcademicRecords::where([
    //                     'student_id' => $student_id,
    //                     'term_id' => $term_id,
    //                     'level_id' => $level_id,
    //                     'academic_year_id' => $academic_year_id,
    //                     'subject_id' => $value['subject_id'],
    //                     'school_id' => $school_id,
    //                     'branch_id' => $branch_id
    //                 ])->first();

    //                 if (empty($studentAcademicRecordsExists)) {
    //                     // implementing grading system for the new end term score and the new end term percentage
    //                     foreach($gradingSystem as $grading) {
    //                         if($grading['score_from'] <= $value['percentage'] && $value['percentage'] <= $grading['score_to']) {
    //                             $grade_id_per_subject = $grading['id'];
    //                             $grade_level_per_subject = $grading['grade'];
    //                             $grade_proficiency_level_per_subject = $grading['level_of_proficiency'];
    //                         }
    //                         // if no record exists, then we create a new record
    //                         StudentsAcademicRecords::create([
    //                             'student_id' => $student_id,
    //                             'academic_year_id' => $academic_year_id,
    //                             'term_id' => $term_id,
    //                             'level_id' => $level_id,
    //                             'subject_id' => $value['subject_id'],
    //                             'end_term_id' => $end_term_breakdown_id,
    //                             'end_term_raw_score' => $value['score'],
    //                             'end_term_percentage' => $value['percentage'],
    //                             'total_raw_score' => $value['score'],
    //                             'total_percentage_score' => $value['percentage'],
    //                             'grade_id' => $grade_id_per_subject,
    //                             'grade_level' => $grade_level_per_subject,
    //                             'grade_proficiency_level' => $grade_proficiency_level_per_subject,
    //                             'school_id' => $school_id,
    //                             'branch_id' => $branch_id
    //                         ]);
    //                     }
    //                 } else {
    //                     $old_cars = $studentAcademicRecordsExists->class_assessment_raw_score;
    //                     $old_cars_percentage = $studentAcademicRecordsExists->class_assessment_percentage;
    //                     $old_mts = $studentAcademicRecordsExists->mid_term_raw_score;
    //                     $old_mts_percentage = $studentAcademicRecordsExists->mid_term_percentage;

    //                     $new_total_raw_score = $value['score'] + $old_cars + $old_mts;
    //                     $new_total_raw_percentage = $value['percentage'] + $old_cars_percentage + $old_mts_percentage;

    //                     // implementing grading system for the new end term score and the new end term percentage
    //                     foreach($gradingSystem as $grading) {
    //                         if($grading['score_from'] <= $new_total_raw_percentage && $new_total_raw_percentage <= $grading['score_to']) {
    //                             $grade_id_per_subject = $grading['id'];
    //                             $grade_level_per_subject = $grading['grade'];
    //                             $grade_proficiency_level_per_subject = $grading['level_of_proficiency'];
    //                         }
    //                         $studentAcademicRecordsExists->update([
    //                             'end_term_id' => $end_term_breakdown_id,
    //                             'end_term_raw_score' => $value['score'],
    //                             'end_term_percentage' => $value['percentage'],
    //                             'total_raw_score' => $new_total_raw_score,
    //                             'total_percentage_score' => $new_total_raw_percentage,
    //                             'grade_id' => $grade_id_per_subject,
    //                             'grade_level' => $grade_level_per_subject,
    //                             'grade_proficiency_level' => $grade_proficiency_level_per_subject,
    //                         ]);
    //                     }
    //                 }
    //             }
    //             /*** STUDENT ACADEMIC RECORDS END ***/
    //         }

    //         DB::commit();
    //         return response()->json([
    //             'status' => 200,
    //             'msg' => 'Student End of Term Entry saved successfully'
    //         ]);
    //     } catch (\Exception $th) {
    //         DB::rollBack();
    //         return response()->json([
    //             'status' => 201,
    //             'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
    //         ]);
    //     }
    // }
}
