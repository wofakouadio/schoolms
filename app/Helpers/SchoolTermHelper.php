<?php

    namespace App\Helpers;

    use App\Models\Term;
    use Illuminate\Support\Facades\Auth;

    if(!function_exists('TermAndAcademicYear')){
        function TermAndAcademicYear(){
            return Term::select('term_name', 'term_academic_year')->where('school_id', Auth::guard('admin')->user()
                ->school_id)->where
            ('is_active', 1)
                ->first();
        }
    }


