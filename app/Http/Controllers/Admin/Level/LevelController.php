<?php

namespace App\Http\Controllers\Admin\Level;

use App\Exports\LevelsListDataTableExport;
use App\Models\AssignSubjectToLevel;
use App\Models\Department;
use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use function App\Helpers\TermAndAcademicYear;

class LevelController extends Controller
{
    //index
    public function index(){
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.level.index', compact('schoolTerm'));
    }

    //store
    public function store(Request $request){
        $request->validate([
            'level_name' => 'required',
            'branch' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Level::create([
                'level_name'=> strtoupper($request->level_name),
                'level_description'=> $request->level_description,
                'school_id' => Auth::guard('admin')->user()->school_id,
                'branch_id' => $request->branch
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Level created successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //edit level
    public function edit(Request $request){
        $data = Level::where('id', $request->level_id)->first();
        return response()->json($data);
    }

    //update level
    public function update(Request $request){
        $request->validate([
            'level_name' => 'required',
            'branch' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Level::where('id', $request->level_id)->update([
                'level_name'=> strtoupper($request->level_name),
                'level_description'=> $request->level_description,
                'is_active' => $request->level_is_active ? 1 : 0
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Level updated successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //delete level
    public function delete(Request $request){
        DB::beginTransaction();

        try {
            Level::where('id', $request->level_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Level deleted successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //get levels based on branch id
    public function getLevelsByBranchId(){
        $output = [];
        $levels = Level::with('branch')->where('school_id', Auth::guard('admin')->user()->school_id)->where
        ('is_active', 1)->get();
        $output[] = "<option value=''>Choose</option>";
        foreach ($levels as $level){
            $output[] = "<option value='".$level->id."'>".$level->branch->branch_name . ' Branch - ' .
                $level->level_name
            ."</option>";
        }
        return $output;
    }

    //get levels based on school id
    public function getLevelsBySchoolId(){
        $output = [];
        if(Auth::guard("admin")->check()){
            $levels = Level::with('branch')
                    ->where(['school_id' => Auth::guard('admin')->user()->school_id, 'is_active' => 1])
                    ->get();
            $output[] = "<option value=''>Choose</option>";
            foreach ($levels as $level){
                $output[] = "<option value='".$level->id."'>".$level->level_name. " / " .$level->branch->branch_name." Branch</option>";
            }
        }else{
            // $levels = Level::with('branch')
            // ->where(['school_id' => Auth::guard('teacher')->user()->school_id, 'is_active' => 1])
            // ->get();
            // $output[] .= "<option value=''>Choose</option>";
            // foreach ($levels as $level){
            //     $output[] .= "<option value='".$level->id."'>".$level->level_name. " / " .$level->branch->branch_name." Branch</option>";
            // }
        }

        return $output;
    }

    public function getLevelsInCheckboxBySchoolId(){
        $output = [];
        $levels = Level::with('branch')->where('school_id', Auth::guard('admin')
            ->user()
            ->school_id)
            ->where
            ('is_active', 1)
            ->get();
        foreach ($levels as $level){
            $output[] = '<div class="col-xl-4 col-xxl-4 col-4">
                            <div class="form-check custom-checkbox mb-3">
                                <input type="checkbox" class="form-check-input" name="level[]" value="'
                        .$level->id.'">
                                <label class="form-check-label">'.$level->level_name.' / '
                        .$level->branch->branch_name.' Branch</label>
                            </div>
                        </div>';
        }
        return $output;
    }

    public function assign_subjects_to_level(Request $request){
        DB::beginTransaction();
        try {
            $data = [];
            foreach($request->subject as $key => $value){
                $data[] = [
                    'id' => Str::uuid(),
                    'subject_id' => $value,
                    'level_id' => $request->level_id,
                    'school_id' => Auth::guard('admin')->user()->school_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
//            AssignSubjectToLevel::upsert($data,
//                ['subject_id', 'level_id'],
//            ['subject_id', 'level_id']);
            DB::table('assign_subject_to_levels')->insert($data);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Subjects assigned to Level successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    // level dataTable
    public function LevelsDatatable(Request $request){
        $query = Level::query()->where([
            'school_id' => Auth::guard('admin')->user()->school_id
        ])->orderBy('created_at', 'DESC');

        // apply filters
        if($request->has('level_is_active') && !empty($request->input('level_is_active'))){
            $query->where('is_active', $request->level_is_active);
        }
        if($request->has('level_name') && !empty($request->input('level_name'))){
            $query->where('level_name', $request->level_name);
        }
        if($request->has('branch') && !empty($request->input('branch'))){
            $searchName = $request->input('branch');
            $query->whereHas('branch', function($q) use ($searchName){
                $q->where('branch_name', 'LIKE', "%{$searchName}%");
            });
        }
        if ($request->has('created_at') && $request->filled('created_at')) {
            $query->where('created_at', $request->input('created_at'));
        }

        $data = $query->with('branch')->get();

        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $name = $row->level_name;
                return $name ?? '...';
            })
            ->addColumn('branch', function ($row) {
                $branch = $row->branch->branch_name;
                return $branch ?? '...';
            })
            ->addColumn('created', function ($row) {
                $created_at = $row->created_at;
                return $created_at ?? '...';
            })
            ->addColumn('is_active', function ($row) {
                if ($row->is_active === 1) {
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">active</span>
                        </div>';
                } else {
                    return '<span class="badge badge-xl light badge-danger text-uppercase">disabled</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $level_id = $row->id;
                return '
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                        <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                        <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                    </g>
                                </svg>
                            </button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-level-modal" data-id="' . $level_id . '">Edit Level</a>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#assign-subjects-to-level-modal" data-id="' .
                    $level_id . '" data-name="'.$row->level_name.'">Assign Subjects to Level</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-level-modal" data-id="' . $level_id.'">Delete Level</a>
                            </div>
                        </div>
                    ';
    //                return '<div class="d-flex">
    //                            <a data-bs-toggle="modal" data-bs-target="#edit-level-modal" data-id="' . $level_id . '"
    //                            class="btn btn-primary shadow btn-xs sharp me-1">
    //                                <i class="fas fa-pencil-alt"></i>
    //                            </a>
    //                            <a data-bs-toggle="modal" data-bs-target="#assign-subjects-to-level-modal" data-id="' .
    //                    $level_id . '" data-name="'.$row->level_name.'"
    //                            class="btn btn-primary shadow btn-xs sharp me-1">
    //                                <i class="fas fa-check-to-slot"></i>
    //                            </a>
    //                            <a data-bs-toggle="modal" data-bs-target="#delete-level-modal" data-id="' . $level_id
    //                    . '" class="btn btn-danger shadow btn-xs sharp">
    //                                <i class="fa fa-trash"></i>
    //                            </a>
    //                         </div>
    //                ';
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }

    public function LevelsDatatable_export(Request $request){
        $query = Level::query()->where([
            'school_id' => Auth::guard('admin')->user()->school_id
        ])->orderBy('created_at', 'DESC');

        // apply filters
        if($request->has('level_is_active') && !empty($request->input('level_is_active'))){
            $query->where('is_active', $request->level_is_active);
        }
        if($request->has('level_name') && !empty($request->input('level_name'))){
            $query->where('level_name', $request->level_name);
        }
        if($request->has('branch') && !empty($request->input('branch'))){
            $query->where('branch_id', $request->branch);
            // $searchName = $request->input('branch');
            // $query->whereHas('branch', function($q) use ($searchName){
            //     $q->where('branch_name', 'LIKE', "%{$searchName}%");
            // });
        }
        if ($request->has('created_at') && $request->filled('created_at')) {
            $query->where('created_at', $request->input('created_at'));
        }

        $data = $query->with('branch')->get();

        return Excel::download(new LevelsListDataTableExport($data), 'Levels_List_'.date('Y-m-d H:i:s').'.xlsx');
    }
}
