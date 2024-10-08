<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use function App\Helpers\TermAndAcademicYear;

class TermController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        $terms = Term::with('academic_year')->where('school_id', Auth::guard('admin')->user()->school_id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.dashboard.term.index',
            [
                'terms' => $terms,
                'schoolTerm' => $schoolTerm
            ]
        );
    }
    //store new term
    public function store(Request $request){
        $request->validate([
            'term_name' => 'required|string',
            'term_opening_date' => 'required',
            'term_closing_date' => 'required',
            'term_academic_year' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Term::create([
                'term_name' => strtoupper($request->term_name),
                'term_opening_date' => $request->term_opening_date,
                'term_closing_date' => $request->term_closing_date,
                'term_academic_year' => $request->term_academic_year,
                'is_active' => 0,
                'school_id' => Auth::guard('admin')->user()->school_id
            ]);
            DB::commit();
            Alert::success('Success', 'Term created successfully.');
            return redirect()->route('admin_school_term');
        }catch (\Exception $th){
            DB::rollBack();
            return back()->withErrors([$th->getMessage()]);
        }
    }

    //edit term
    public function edit(Request $request){
        $data = Term::with('academic_year')->where('id', $request->term_id)->first();
        return response()->json($data);
    }

    //update term
    public function update(Request $request){
        $request->validate([
            'term_name' => 'required|string',
            'term_opening_date' => 'required',
            'term_closing_date' => 'required',
            'term_academic_year' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Term::where('id', $request->term_id)->update([
                'term_name' => strtoupper($request->term_name),
                'term_opening_date' => $request->term_opening_date,
                'term_closing_date' => $request->term_closing_date,
                'term_academic_year' => $request->term_academic_year
            ]);
            DB::commit();
            Alert::success('Success', 'Term updated successfully.');
            return redirect()->route('admin_school_term');
        }catch (\Exception $th){
            DB::rollBack();
            return back()->withErrors([$th->getMessage()]);
        }
    }

    //update term status
    public function update_status(Request $request){
        $request->validate([
            'term_is_active' => 'required'
        ]);

        DB::beginTransaction();

        $sqlCheckActive = Term::where('school_id', Auth::guard('admin')->user()->school_id)
            ->where('is_active',1)
            ->first();

        if($sqlCheckActive){
            if($sqlCheckActive->is_active == $request->term_is_active){
                return back()->withErrors(['Disable Term in Session before activating a new term']);
//                return response()->json([
//                    'status' => 201,
//                    'msg' => 'Disable Term in Session before activating a new term'
//                ]);
            }else{
                try {
                    Term::where('id', $request->term_id)->update([
                        'is_active' => $request->term_is_active
                    ]);
                    DB::commit();
                    Alert::success('Success', 'Term Status updated successfully.');
                    return redirect()->route('admin_school_term');
//                    return response()->json([
//                        'status' => 200,
//                        'msg' => 'Term Status updated successfully'
//                    ]);
                }catch (\Exception $th){
                    DB::rollBack();
                    return back()->withErrors([$th->getMessage()]);
//                    return response()->json([
//                        'status' => 201,
//                        'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
//                    ]);
                }
            }
        }else{
            try {
                Term::where('id', $request->term_id)->update([
                    'is_active' => $request->term_is_active
                ]);
                DB::commit();
                Alert::success('Success', 'Term Status updated successfully.');
                return redirect()->route('admin_school_term');
//                return response()->json([
//                    'status' => 200,
//                    'msg' => 'Term Status updated successfully'
//                ]);
            }catch (\Exception $th){
                DB::rollBack();
                return back()->withErrors([$th->getMessage()]);
//                return response()->json([
//                    'status' => 201,
//                    'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
//                ]);
            }
        }
    }

    //delete team
    public function delete(Request $request){
        DB::beginTransaction();
        try {
            Term::where('id', $request->term_id)->delete();
            DB::commit();
            Alert::success('Success', 'Term deleted successfully.');
            return redirect()->route('admin_school_term');
//            return response()->json([
//                'status' => 200,
//                'msg' => 'Term deleted successfully'
//            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return back()->withErrors([$th->getMessage()]);
//            return response()->json([
//                'status' => 201,
//                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
//            ]);
        }
    }

    //Terms based on school id
    public function getTermsBySchoolId(){
        $output = [];
        $terms = Term::with('academic_year')->where('school_id', Auth::guard
        ('admin')
            ->user()
            ->school_id)
            ->get();
        $output[] = "<option value=''>Choose</option>";
        foreach ($terms as $term){
            $output[] = "<option value='".$term->id."'>".$term->term_name.' - '
                .$term->academic_year->academic_year_start."/".$term->academic_year->academic_year_end."</option>";
        }
        return $output;
    }

    //Active Term based on school id
    public function getActiveTermBySchoolID(){
        $data = [];
        $ActiveTerm = Term::with('academic_year')
            ->where('is_active', 1)
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->first();
        $data = [
            'term_id' => $ActiveTerm->id,
            'term_name' => $ActiveTerm->term_name,
            'academic_year_start' => $ActiveTerm->academic_year->academic_year_start,
            'academic_year_end' => $ActiveTerm->academic_year->academic_year_end,
        ];
        return response()->json($data);
    }

}
