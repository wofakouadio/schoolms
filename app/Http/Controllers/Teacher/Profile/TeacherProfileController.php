<?php

namespace App\Http\Controllers\Teacher\Profile;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function App\Helpers\TermAndAcademicYear;

class TeacherProfileController extends Controller
{
    //school main page
    public function index()
    {
        $schoolData = School::where('id', Auth::guard('teacher')->user()->school_id)->first();
        $teacherData = Teacher::where('id', Auth::guard('teacher')->user()->id)->first();
        $schoolData->getMedia("school_logo")->first();
//        dd($schoolData);
        $schoolTerm = TermAndAcademicYear();
        return view('teacher.dashboard.profile.index',
            [
                'schoolData' => $schoolData,
                'teacherData' => $teacherData,
                'schoolTerm' => $schoolTerm
            ]
        );
    }

    public function school_data(){
        $data = School::where('id', Auth::guard('teacher')->user()->school_id)->first();
        $data->getMedia("school_logo")->first();
        $acronym = Str::of($data->school_name)->headline()->acronym();
        $result = [
            'school_data' => $data,
            'acronym' => $acronym
        ];
        return response()->json($result);
    }

}
