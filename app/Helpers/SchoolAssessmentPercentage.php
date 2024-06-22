<?php
    namespace App\Helpers;

    use App\Models\AssessmentSettings;
    use Illuminate\Support\Facades\Auth;

    if(!function_exists("SchoolAssessmentPercentageSettings")){
        function SchoolAssessmentPercentageSettings(){
            if(Auth::guard('admin')->check()){
                $authUser = Auth::guard('admin')->user()->school_id;
            }elseif(Auth::guard('teacher')->check()){
                $authUser = Auth::guard('teacher')->user()->school_id;
            }else{
                $authUser = '';
            }
            $check = AssessmentSettings::with('school_academic_year')->where([
                'school_id' => $authUser,
                'is_active' => 1
            ])->first();

            // dd($check);

            if($check->count() > 0){
                return response()->json([
                    'class_percentage' => $check->class_percentage,
                    'mid_term_percentage' => $check->mid_term_percentage,
                    'exam_percentage' => $check->exam_percentage
                ]);
            }else{
                return response()->json([
                    'class_percentage' => config('assessment-settings.class_percentage'),
                    'mid_term_percentage' => config('assessment-settings.mid_term_percentage'),
                    'exam_percentage' => config('assessment-settings.exam_percentage')
                ]);
            }
        }
    }
