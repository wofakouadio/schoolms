<?php

namespace App\Http\Controllers\Admin\Departments;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DepartmentsController extends Controller
{
    //index
    public function index()
    {
        $departmentsDataTableView = Department::all();
        return view(
            "admin.dashboard.department.index",
            compact('departmentsDataTableView')
        );
    }

    // create new department
    public function create()
    {
        return view("admin.dashboard.department.create");
    }

    // store new department
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:' . Department::class],
        ]);

        //        dd($request->all());

        DB::beginTransaction();

        try {

            $department = Department::create([
                'name' => strtoupper($request->name),
                'description' => $request->description,
                'school_id' => Auth::guard('admin')->user()->school_id //$request->id,
                //                'branch_id' => $request->branch_id
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Category created successfully'
            ]);

            //            return redirect()->route('new-department')->with('message','New Department created successfully');

        } catch (\Exception $th) {

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
    public function edit(Request $request)
    {

        return view('admin.dashboard.department.edit');
    }

    //Departments DataTables
    public function DepartmentsDataTables(Request $request)
    {
        //        if ($request->ajax()) {
        //            $data = Department::select('name', 'is_active');
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
        //        return view('admin.dashboard.department.index');
    }
}
