<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssignLevelToDepartment;
use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;

class CustomJSController extends Controller
{
    //
    public function getLevelsByDepartmentBranchSchoolId(Request $request){
        $department = $request->department_id;
        $output = [];
        $output[] .= "<option value=''>Choose</option>";
        $levels = AssignLevelToDepartment::with('AssignLevel')->where('department_id', $department)->get();
//        dd($levels);
        foreach ($levels as $level) {
            $output[] .= "<option value='".$level->level_id."'>".$level->AssignLevel->level_name."</option>";
        }
        return $output;
    }

    public function getSubjectsByLevelDepartmentBranchSchoolId(Request $request){
        $level_id = $request->level_id;
        $output = [];
        $output[] .= "<option value=''>Choose</option>";
        $subjects = Subject::where('level_id', $level_id)->get();
        foreach ($subjects as $subject) {
            $output[] .= "<option value='".$subject->id."'>".$subject->subject_name."</option>";
        }
        return $output;
    }
}
