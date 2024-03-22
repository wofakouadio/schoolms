<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{
    //index
    public function index(){
        return view("admin.dashboard.department.index");
    }

    // create new department
    public function create(){
        return view("admin.dashboard.department.create");
    }

    // store new department
    public function store(Request $request){
        $request->validate([
            'name'=>['required','string', 'max:255', 'unique:'.Department::class],
        ]);

//        dd($request->all());

        DB::beginTransaction();

        try {

            Department::create([
                'name'=> strtoupper($request->name),
                'description' => $request->description,
//                'school_id' => $request->school_id,
//                'branch_id' => $request->branch_id
            ]);

            DB::commit();

            return redirect()->route('new-department')->with('message','New Department created successfully');

        }catch(\Exception $th){

//            dd($th);

            DB::rollBack();

            return back()->withErrors(['message' => $th->getMessage()]);

        }
    }
}
