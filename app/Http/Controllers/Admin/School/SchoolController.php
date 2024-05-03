<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\TermAndAcademicYear;

class SchoolController extends Controller
{
    //school main page
    public function index()
    {
        $school_id = Auth::guard('admin')->user()->school_id;
        $schoolData = School::where('id', $school_id)->first();
        $schoolData->getMedia("school_logo")->first();
//        dd($schoolData);
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.portfolio.index',
            [
                'schoolData' => $schoolData,
                'schoolTerm' => $schoolTerm
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

        // if($request->hasFile('school_logo'))
        //     // $logo = $request->file('school_logo')->store('school/logo', 'public');
        //     $logo = $request->file('school_logo')->store('school/logo', 'public');
        // else
        //     $logo = $request->school_fetched_logo;

        DB::beginTransaction();
        try {
            $school = School::where('id', Auth::guard('admin')->user()->school_id)->update([
                'school_name' => strtoupper($request->school_name),
                'school_location' => $request->school_location,
                'school_email' => strtolower($request->school_email),
                'school_phoneNumber' => $request->school_contact,
                // 'school_logo' => $logo
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
}
