<?php

    namespace App\Helpers;

    use App\Models\Term;
    use Illuminate\Support\Facades\Auth;

    if(!function_exists('TermAndAcademicYear')){
        function TermAndAcademicYear(){
            if(Auth::guard('admin')->check()){
                $authUser = Auth::guard('admin')->user()->school_id;
            }elseif(Auth::guard('teacher')->check()){
                $authUser = Auth::guard('teacher')->user()->school_id;
            }else{
                $authUser = '';
            }
            return Term::select('term_name', 'term_academic_year')->where('school_id', $authUser)->where
            ('is_active', 1)
                ->first();
        }
    }


