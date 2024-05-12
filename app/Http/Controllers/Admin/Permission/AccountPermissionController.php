<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Controllers\Controller;
use App\Models\AccountPermission;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\TermAndAcademicYear;
use RealRashid\SweetAlert\Facades\Alert;

class AccountPermissionController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $users = AccountPermission::with('teacher')
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->orderBy('created_at', 'desc')
            ->get();
//        dd($users);
        return view('admin.dashboard.users-account.index', [
            'users' => $users,
            'schoolTerm' => $schoolTerm
        ]);
    }

    public function store(Request $request){
        $teacher = $request->user;
        $status = $request->user_status;
        $school = Auth::guard('admin')->user()->school_id;

        DB::beginTransaction();
        try {
            AccountPermission::create([
                'user_id' => $teacher,
                'user_type' => 'Teacher',
                'status' => $status,
                'school_id' =>$school
            ]);
            DB::commit();
            Alert::success('Notification', 'User Account Created Successfully');
            return back();
        }catch(\Exception $e){
            DB::rollBack();
            Alert::alert('Notification', 'Something Went Wrong'.$e->getMessage());
            return back();
        }

    }
}
