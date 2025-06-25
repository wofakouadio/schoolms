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
use function App\Helpers\SchoolAssessmentPercentageSettings;

class TeacherLevelController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();

        // this variable helps to get the levels/classes taught by the teacher
        $teacherLevels = SubjectsToTeacher::with('level')
            ->where([
                'teacher_id' => Auth::guard('teacher')->user()->id,
                'school_id' => Auth::guard('teacher')->user()->school_id
            ])->distinct()
            // ->orderBy('level.created_at', 'asc')
            ->get(['level_id']);
        $enrolledStudents = [];

        // dd($teacherLevels);

        // Iterate through the levels/classes assigned to the teacher
        // to retrieve all students associated with each level/class
        foreach ($teacherLevels as $teacherLevel) {
            // Fetch subjects assigned to the current level/class
            $assignedSubjects = SubjectsToTeacher::with('subject')
                ->where([
                    'teacher_id' => Auth::guard('teacher')->user()->id,
                    'school_id' => Auth::guard('teacher')->user()->school_id,
                    'level_id' => $teacherLevel->level_id
                ])
                ->orderBy('created_at', 'DESC')
                ->get();

            // Retrieve students enrolled in the current level/class
            // $enrolledStudents = StudentsAdmissions::with('level', 'house', 'category')
            //     ->where([
            //         'student_level' => $teacherLevel->level_id,
            //         'school_id' => Auth::guard('teacher')->user()->school_id,
            //         'admission_status' => 1
            //     ])
            //     ->orderBy('created_at', 'DESC')
            //     ->get();
        }
        // dd($teacherStudents);
        // dd($TeacherLevelsSubjects);

        return view('teacher.dashboard.level.index', [
            'schoolTerm' => $schoolTerm,
            'teacherLevels' => $teacherLevels,
            // 'teacherStudents' => $teacherStudents,
            'subjectsTaught' => $assignedSubjects
        ]);
    }

    public function getLevelsBySchoolId()
    {
        $output = [];

        $output[] = "<option value=''>Choose</option>";
        $teacherLevels = SubjectsToTeacher::with('level')
        ->select('level_id')
        ->where(['teacher_id' => Auth::guard('teacher')->user()->id,
                 'school_id' => Auth::guard('teacher')->user()->school_id
                 ])
        ->distinct()->get();
        foreach($teacherLevels as $value){
            $output[] = "<option value='".$value->level_id."'>".$value->level->level_name."</option>";
        }
        return $output;
        // $levels = Level::with('branch')->where([
        //     'school_id' => Auth::guard('teacher')->user()->school_id,
        //     'is_active' => 1])
        //     ->get();
        // dd($levels);
        // return response()->json($teacherLevels);
    }

}
