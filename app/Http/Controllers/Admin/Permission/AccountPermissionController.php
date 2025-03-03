<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Controllers\Controller;
use App\Models\AccountPermission;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Accounting;

use function App\Helpers\TermAndAcademicYear;
use RealRashid\SweetAlert\Facades\Alert;
use Svg\Tag\Rect;

class AccountPermissionController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $Teachers = AccountPermission::with('teacher')
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->orderBy('created_at', 'desc')
            ->get();
//        dd($users);
        return view('admin.dashboard.users-account.index', [
            'Teachers' => $Teachers,
            'schoolTerm' => $schoolTerm
        ]);
    }

    // add new teacher user account permission
    public function add_new_teacher_user(Request $request){
        $request->validate([
            'teacher_user' => 'required',
            'teacher_user_status' => 'required'
        ]);
        $teacher = $request->teacher_user;
        $status = $request->teacher_user_status;
        $school = Auth::guard('admin')->user()->school_id;

        // Check if the user already exists
        $existingUser = AccountPermission::where('user_id', $teacher)
            ->where('school_id', $school)
            ->first();

        if ($existingUser) {
            flash()->addWarning('User already exists in this school.');
            return back();
        }

        DB::beginTransaction();
        try {
            AccountPermission::create([
                'user_id' => $teacher,
                'user_type' => 'Teacher',
                'status' => $status,
                'school_id' => $school
            ]);
            DB::commit();
            flash()->addSuccess('User Account Created Successfully');
            return back();
        }catch(\Exception $e){
            DB::rollBack();
            flash()->addError('Something Went Wrong'.$e->getMessage());
            return back();
        }
    }
    // get teacher user account permission
    public function edit_teacher_user(Request $request){
        $teacherUser = AccountPermission::with('teacher')->where('id', $request->teacher_user_id)->first();
        return response()->json($teacherUser);
    }
    // patch teacher user account permission
    public function update_teacher_user(Request $request){
        // dd($request->all());
        $request->validate([
            'teacher_user_permission_id' => 'required',
            'teacher_user_status' => 'required'
        ]);
        $status = $request->teacher_user_status;
        $school = Auth::guard('admin')->user()->school_id;

        // Find the existing user permission record
        $existingUserPermission = AccountPermission::where([
            'id' => $request->teacher_user_permission_id,
            'school_id' => $school
        ])->first();

        if (!$existingUserPermission) {
            flash()->addWarning('User permission does not exist in this school.'); // Updated message for clarity
            return back();
        }

        DB::beginTransaction();
        try {
            // Update the existing user permission
            $existingUserPermission->update([
                'status' => $status
            ]);
            DB::commit();
            flash()->addSuccess('User Account Updated Successfully');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addError('Something Went Wrong: ' . $e->getMessage());
            return back();
        }
    }
    // delete teacher user account permission
    public function delete_teacher_user(Request $request){
    $request->validate([
        'teacher_user_permission_id' => 'required'
    ]);

    $existingUserPermission = AccountPermission::find($request->teacher_user_permission_id);

    if (!$existingUserPermission || $existingUserPermission->school_id !== Auth::guard('admin')->user()->school_id) {
        flash()->addWarning('User permission does not exist in this school.');
        return back();
    }

    try {
        $existingUserPermission->delete();
        flash()->addSuccess('User Account Permission Deleted Successfully');
    } catch (\Exception $e) {
        flash()->addError('Something Went Wrong: ' . $e->getMessage());
    }

    return back();
    }

}
