<?php

namespace App\Http\Controllers\Admin\AcademicYear;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use function App\Helpers\TermAndAcademicYear;

class AcademicYearController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $academicYears = AcademicYear::where('school_id', Auth::guard('admin')->user()->school_id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.dashboard.academic-year.index',
            [
                'academicYears' => $academicYears,
                'schoolTerm' => $schoolTerm
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'academic_year_start' => 'required',
            'academic_year_end' => 'required',
        ]);
        DB::beginTransaction();
        try {
            AcademicYear::create([
                'academic_year_start' => $request->academic_year_start,
                'academic_year_end' => $request->academic_year_end,
                'is_active' => 0,
                'school_id' => Auth::guard('admin')->user()->school_id
            ]);
            DB::commit();
            Alert::success('Success', 'Academic Year created successfully');
            return redirect()->route('admin_academic_year');
        }catch(\Exception $th){
            DB::rollBack();
            return back()->withErrors(['error', 'Something went wrong. Details:'.$th->getMessage()]);
        }
    }

    public function edit(Request $request){
        $data = AcademicYear::where('id', $request->academic_year_id)->first();
        return response()->json($data);
    }

    public function update(Request $request){
        $request->validate([
            'academic_year_start' => 'required',
            'academic_year_end' => 'required',
        ]);
        DB::beginTransaction();
        try {
            AcademicYear::where('id', $request->academic_year_id)->update([
                'academic_year_start' => $request->academic_year_start,
                'academic_year_end' => $request->academic_year_end
            ]);
            DB::commit();
            Alert::success('Success', 'Academic Year updated successfully');
            return redirect()->route('admin_academic_year');
        }catch(\Exception $th){
            DB::rollBack();
            return back()->withErrors(['error', 'Something went wrong. Details:'.$th->getMessage()]);
        }
    }

    public function update_status(Request $request){
        $request->validate([
            'academic_status' => 'required'
        ]);
        DB::beginTransaction();
        try {
            if($request->academic_status == 0){
                AcademicYear::where('id', $request->academic_year_id)->update([
                    'is_active' => $request->academic_status
                ]);
                DB::commit();
                Alert::success('Success', 'Academic Year Status updated successfully');
                return redirect()->route('admin_academic_year');
            }else{
                $chkActive = AcademicYear::where(['school_id' => Auth::guard('admin')->user()->school_id, 'is_active' =>
                    $request->academic_status])->get();
                if($chkActive->count() == 0){
                    AcademicYear::where('id', $request->academic_year_id)->update([
                        'is_active' => $request->academic_status
                    ]);
                    DB::commit();
                    Alert::success('Success', 'Academic Year Status updated successfully');
                    return redirect()->route('admin_academic_year');
                }else{
                    return back()->withErrors(['You must disable the Active Academic Year before activating another one.']);
                }
            }
        }catch(\Exception $th){
            DB::rollBack();
            return back()->withErrors(['Something went wrong. Details:'.$th->getMessage()]);
        }
    }

    public function delete(Request $request){
        DB::beginTransaction();
        try {
            AcademicYear::where('id', $request->academic_year_id)->delete();
            DB::commit();
            Alert::success('Success', 'Academic Year deleted successfully');
            return redirect()->route('admin_academic_year');
        }catch(\Exception $th){
            DB::rollBack();
            return back()->withErrors(['error', 'Something went wrong. Details:'.$th->getMessage()]);
        }
    }

    public function getAcademicYearsBySchoolId(){
        $data = AcademicYear::where(['school_id'=>Auth::guard('admin')->user()->school_id, 'is_active'=>1])->get();
        return response()->json($data);
    }
}
