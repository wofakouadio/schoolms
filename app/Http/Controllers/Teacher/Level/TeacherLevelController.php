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

        $teacherLevels = SubjectsToTeacher::with('subject', 'level')
            ->where('teacher_id', Auth::guard('teacher')->user()->id)
            ->where('school_id', Auth::guard('teacher')->user()->school_id)
            ->orderBy('created_at', 'DESC')
            ->distinct()->get();

        foreach ($teacherLevels as $key => $teacherLevel) {
            $data[] = [
                'subject' => $teacherLevel->subject->subject_name,
                'level' => $teacherLevel->level->level_name
            ];
        }
        $teacherStudents = StudentsAdmissions::with('level', 'house', 'category')
            ->where('student_level', $teacherLevel->level_id)
            ->where('school_id', Auth::guard('teacher')->user()->school_id)
            ->where('admission_status', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('teacher.dashboard.level.index', [
            'schoolTerm' => $schoolTerm,
            'teacherLevels' => $teacherLevels,
            'teacherStudents' => $teacherStudents
        ]);
    }

    // public function getLevelsBySchoolId()
    // {
    //     $output = [];
    //     $levels = Level::with('branch')->where([
    //         'school_id' => Auth::guard('teacher')->user()->school_id,
    //         'is_active' => 1])
    //         ->get();
    //     // dd($levels);
    //     return response()->json();
    // }

}
