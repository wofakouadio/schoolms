<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function App\Helpers\TermAndAcademicYear;

class SchoolController extends Controller
{
    //school main page
    public function index()
    {
        $school_id = Auth::guard('admin')->user()->school_id;
        $schoolData = School::where('id', $school_id)->first();
        $schoolData->getMedia("school_logo")->first();

        $adminData = Admin::where('school_id', $school_id)->first();
        $adminData->getMedia("admin_profile")->first();
//        dd($adminData);
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.portfolio.index',
            [
                'schoolData' => $schoolData,
                'schoolTerm' => $schoolTerm,
                'adminData' => $adminData,
            ]
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'school_name' => 'required',
            'school_location' => 'required',
            'school_email' => 'required',
            'school_contact' => 'required',
            'school_logo' => 'image|mimes:jpeg,jpg,png,gif'
        ]);

        DB::beginTransaction();
        try {
            $school = School::where('id', Auth::guard('admin')->user()->school_id)->update([
                'school_name' => strtoupper($request->school_name),
                'school_location' => $request->school_location,
                'school_email' => strtolower($request->school_email),
                'school_phoneNumber' => $request->school_contact,
            ]);

            if ($request->hasFile('school_logo')) {
                $school = School::where('id', Auth::guard('admin')->user()->school_id)->first();
                $school->clearMediaCollection('school_logo');
                $school->addMedia($request->file('school_logo'))
                    ->toMediaCollection('school_logo');
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'School Basic updated successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    public function school_data(){
        $data = School::where('id', Auth::guard('admin')->user()->school_id)->first();
        $data->getMedia("school_logo")->first();
        $acronym = Str::of($data->school_name)->headline()->acronym();
        $result = [
            'school_data' => $data,
            'acronym' => $acronym
        ];
        return response()->json($result);
    }

}
