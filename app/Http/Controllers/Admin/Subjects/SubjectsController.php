<?php

namespace App\Http\Controllers\Admin\Subjects;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SubjectsController extends Controller
{
    //index
    public function index(){
        $subjectsDataTableView = Subject::all();
        return view("admin.dashboard.subject.index",
            compact('subjectsDataTableView'));
    }

    // create new subject
    public function create(){
        return view("admin.dashboard.subject.create");
    }

    // store new department
    public function store(Request $request){
        $request->validate([
            'name'=>['required','string', 'max:255', 'unique:'.Subject::class],
        ]);

//        dd($request->all());

        DB::beginTransaction();

        try {

            $subject = Subject::create([
                'name'=> strtoupper($request->name),
                'description' => $request->description,
                'school_id' => $request->id,
//                'branch_id' => $request->branch_id
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Category created successfully'
            ]);

//            return redirect()->route('new-subject')->with('message','New Department created successfully');

        }catch(\Exception $th){

//            dd($th);

            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
//            return back()->withErrors(['message' => $th->getMessage()]);

        }
    }

    //edit department
    public function edit(Request $request){

        return view('admin.dashboard.subject.edit');
    }

    //Subjects DataTables
    public function SubjectsDataTables(Request $request){
//        if ($request->ajax()) {
//            $data = Subject::select('name', 'is_active');
//
//            return Datatables::of($data)
//                ->addIndexColumn()
//                ->editColumn('is_active', function ($row){
//                    if($row['is_active'] == 0){
//                        return '<span class="badge badge-xl light badge-success text-uppercase">active</span>';
//                    }else{
//                        return '<span class="badge badge-xl light badge-danger text-uppercase">disabled</span>';
//                    }
//                })
//                ->addColumn('action', function ($row){
//                    return '<div class="d-flex">
//                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
//                                <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
//                            </div>';
//                })->rawColumns(['action'])
//                ->make(true);
//        }
//        return view('admin.dashboard.subject.index');
    }
}
