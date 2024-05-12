<?php

namespace App\Http\Controllers\Teacher\Level;

use App\Models\AssignSubjectToLevel;
use App\Models\Department;
use App\Models\Level;
use App\Models\StudentsAdmissions;
use App\Models\SubjectsToTeacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use function App\Helpers\TermAndAcademicYear;

class TeacherLevelController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
            $teacherLevels = SubjectsToTeacher::with('subject', 'level')
                ->where('teacher_id', Auth::guard('teacher')->user()->id)
                ->where('school_id', Auth::guard('teacher')->user()->school_id)
                ->orderBy('created_at', 'DESC')
                ->get();

            foreach ($teacherLevels as $teacherLevel) {
//                $level[] = $teacherLevel->level_id;


            $teacherStudents = StudentsAdmissions::with('teacher_level')
                ->where('student_level', $teacherLevel->level_id)
                ->where('school_id', Auth::guard('teacher')->user()->school_id)
                ->where('admission_status', '=', 1)
                ->orderBy('created_at', 'DESC')
                ->get();
            }

            return view('teacher.dashboard.level.index', [
                'schoolTerm' => $schoolTerm,
                'teacherLevels' => $teacherLevels,
                'teacherStudents' => $teacherStudents
            ]);

//        }


//        else{
//            $teacherLevels = SubjectsToTeacher::with('subject', 'level')
//                ->where('teacher_id', Auth::guard('teacher')->user()->id)
//                ->where('school_id', Auth::guard('teacher')->user()->school_id)
//                ->orderBy('created_at', 'DESC')
//                ->get();
////        dd($teacherLevels);
////        $teacherStudents = array();
//            if($teacherLevels->count() > 0){
//                foreach ($teacherLevels as $teacherLevel) {
////                if(is_array($teacherStudents) || is_object($teacherStudents)){
//                    $teacherStudents = StudentsAdmissions::with('level')
//                        ->where('student_level', $teacherLevel->level_id)
//                        ->where('school_id', Auth::guard('teacher')->user()->school_id)
//                        ->where('admission_status', '=', 1)
//                        ->orderBy('created_at', 'DESC')
//                        ->get();
////                }
//                }
//            }
//        }



//        dd($teacherStudents);
//        return view('teacher.dashboard.level.index', [
//            'schoolTerm' => $schoolTerm,
//            'teacherLevels' => $teacherLevels,
//            'teacherStudents' => $teacherStudents
//        ]);
    }

    public function getLevelsBySchoolId(){
        $output = [];
        $levels = Level::with('branch')->where('school_id', Auth::guard('teacher')
            ->user()
            ->school_id)
            ->where
            ('is_active', 1)
            ->get();
        $output[] .= "<option value=''>Choose</option>";
        foreach ($levels as $level){
            $output[] .= "<option value='".$level->id."'>".$level->level_name. " - " .$level->branch->branch_name." Branch</option>";
        }
        return $output;
    }

}
