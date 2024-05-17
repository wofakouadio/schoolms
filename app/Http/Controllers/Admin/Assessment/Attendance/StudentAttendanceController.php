<?php

namespace App\Http\Controllers\Admin\Assessment\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\StudentAttendance;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function App\Helpers\TermAndAcademicYear;

class StudentAttendanceController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.assessment.attendance.index', compact('schoolTerm'));
    }

    //get subject name temporarly for display purpose
    public function get_subject(Request $request){
        $data = Subject::select('subject_name')->where('id', $request->subject_id)->first();
//        dd($data);
        return response()->json($data);
    }

    public function store(Request $request){
//dd($request->all());
        DB::beginTransaction();

        try {
            $student_presents = $request->students;
            $branch = Department::select('branch_id')->where('id', $request->department_id)->first();
            $mark_attendance = [];

            //clear all attendance marked for the day, department and level
            StudentAttendance::where([
                'level_id'=>$request->level_id,
                'department_id' => $request->department_id,
                'subject_id' => $request->subject_id,
                'branch_id' => $branch->branch_id,
                'school_id' =>  Auth::guard('admin')->user()->school_id,
                'status' => 1
            ])->whereDay('created_at', now()->day)->delete();

            foreach ($student_presents as $student => $value){
//                dd($value);
                //check if student is already marked
                $StudentAlreadyMarkedPresent = StudentAttendance::where([
                    'student_id' => $value,
                    'level_id'=>$request->level_id,
                    'department_id' => $request->department_id,
                    'subject_id' => $request->subject_id ?? 'null',
                    'branch_id' => $branch->branch_id,
                    'school_id' =>  Auth::guard('admin')->user()->school_id,
                    'status' => 1,
//                    'created_at' =>

                ])->whereDay('created_at', now()->day)->exists();
//dd($StudentAlreadyMarkedPresent);

                if(!$StudentAlreadyMarkedPresent){
                    $mark_attendance[] = [
                        'id' => Str::uuid(),
                        'student_id' => $value,
                        'level_id' => $request->level_id,
                        'department_id' => $request->department_id,
                        'subject_id' => $request->subject_id ?? 'null',
                        'branch_id' => $branch->branch_id,
                        'school_id' => Auth::guard('admin')->user()->school_id,
                        'status' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }

            }

            if(count($mark_attendance) <= 0){
                return response()->json([
                    'status' => 200,
                    'msg' => 'Attendance already submitted successfully'
                ]);
            }

            DB::table('student_attendances')->insert($mark_attendance);
//            foreach($mark_attendance as $attendance){
//                $attendance;
//                $StudentAlreadyMarkedPresent = StudentAttendance::where([
//                    ['student_id', '=', $attendance->student_id],
//                    ['level_id', '=', $attendance->level_id],
//                    ['department_id', '=', $attendance->department_id],
//                    ['subject_id', '=', $attendance->subject_id],
//                    ['branch_id', '=', $attendance->branch_id],
//                    ['school_id', '=', $attendance->school_id],
//                    ['status', '=', $attendance->status],
//                    ['created_at', '=', $attendance->created_at]
//                ])->count();

//                if($StudentAlreadyMarkedPresent == 0){
//                    DB::table('student_attendances')->insert($mark_attendance);
//                }
//            }
//            dd($attendance);
            //check if student has already been marked present



            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Attendance submitted successfully'
            ]);

        }catch(\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }
}
