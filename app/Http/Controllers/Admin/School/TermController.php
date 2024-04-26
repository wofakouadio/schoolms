<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TermController extends Controller
{
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
                'school_id' => Auth::guard('admin')->user()->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Term created successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //edit term
    public function edit(Request $request){
        $data = Term::where('id', $request->term_id)->first();
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

        if($request->term_is_active == '0'){
            try {
                Term::where('id', $request->term_id)->update([
                    'term_name' => strtoupper($request->term_name),
                    'term_opening_date' => $request->term_opening_date,
                    'term_closing_date' => $request->term_closing_date,
                    'term_academic_year' => $request->term_academic_year,
                    'is_active' => $request->term_is_active
                ]);
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'msg' => 'Term updated successfully'
                ]);
            }catch (\Exception $th){
                DB::rollBack();
                return response()->json([
                    'status' => 201,
                    'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
                ]);
            }
        }else{
            $sqlCheckActive = Term::where('school_id', Auth::guard('admin')->user()->school_id)->where('is_active',
                $request->term_is_active)
                ->first();
            if($sqlCheckActive){
                return response()->json([
                    'status' => 201,
                    'msg' => 'Disable Term in Session before activating a new term'
                ]);
            }else{
                try {
                    Term::where('id', $request->term_id)->update([
                        'term_name' => strtoupper($request->term_name),
                        'term_opening_date' => $request->term_opening_date,
                        'term_closing_date' => $request->term_closing_date,
                        'term_academic_year' => $request->term_academic_year,
                        'is_active' => $request->term_is_active
                    ]);
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'msg' => 'Term updated successfully'
                    ]);
                }catch (\Exception $th){
                    DB::rollBack();
                    return response()->json([
                        'status' => 201,
                        'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
                    ]);
                }
            }
        }
    }

    //delete team
    public function delete(Request $request){
        DB::beginTransaction();
        try {
            Term::where('id', $request->term_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Term deleted successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //Terms based on school id
    public function getTermsBySchoolId(){
        $output = [];
        $terms = Term::select('id', 'term_name', 'term_academic_year')->where('school_id', Auth::guard('admin')->user()
            ->school_id)
            ->get();
        $output[] .= "<option value=''>Choose</option>";
        foreach ($terms as $term){
            $output[] .= "<option value='".$term->id."'>".$term->term_name.' - '.$term->term_academic_year."</option>";
        }
        return $output;
    }

    //Active Term based on school id
    public function getActiveTermBySchoolID(){
        $data = [];
        $ActiveTerm = Term::select('id', 'term_name', 'term_academic_year')
            ->where('is_active', 1)
            ->where('school_id', Auth::guard('admin')->user()->school_id)
            ->first();
        $data = [
            'term_id' => $ActiveTerm->id,
            'term_name' => $ActiveTerm->term_name,
            'term_academic_year' => $ActiveTerm->term_academic_year
        ];
        return response()->json($data);
    }

}
