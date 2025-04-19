<?php

namespace App\Http\Controllers\Admin\House;

use App\Exports\HousesListExport;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use function App\Helpers\TermAndAcademicYear;

class HouseController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.house.index', compact('schoolTerm'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'house_name' => 'required',
//            'house_type' => 'required',
            'branch' => 'required'
        ]);

        DB::beginTransaction();
        try {
            House::create([
                'house_name' => $request->house_name,
                'house_description' => $request->house_description ?? '',
                'house_type' => $request->house_type ?? '',
                'branch_id' => $request->branch,
                'school_id' => Auth::guard('admin')->user()->school_id //$request->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'House created successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //edit
    public function edit(Request $request)
    {
        $data = House::where('id', $request->house_id)->first();
        return response()->json($data);
    }

    //update
    public function update(Request $request)
    {
        $request->validate([
            'house_name' => 'required',
            'branch' => 'required'
        ]);

        DB::beginTransaction();
        try {
            House::where('id', $request->house_id)->update([
                'house_name' => $request->house_name,
                'house_description' => $request->house_description ?? 'null',
                'house_type' => $request->house_type ?? 'null',
                'is_active' => $request->house_is_active,
                'branch_id' => $request->branch
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'House updated successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //delete
    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            House::where('id', $request->house_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'House deleted successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //houses based on branch id
    public function getHousesByBranchId()
    {
        $output = [];
        $houses = House::with('branch')->where('school_id', Auth::guard('admin')->user()->school_id)->where
        ('is_active', 1)
                ->get();
        $output[] = "<option value=''>Choose</option>";
        foreach ($houses as $house){
            $output[] = "<option value='".$house->id."'>".$house->branch->branch_name . ' Branch -  '
                .$house->house_name."</option>";
        }
        return $output;
    }

    // house dataTables
    public function housesDataTables(Request $request){
        $query =  House::query()->where(['school_id' => Auth::guard('admin')->user()->school_id])->orderBy('created_at', 'DESC');

        // apply filters
        if($request->has('house_name') && !empty($request->input('house_name'))){
            $searchName = $request->input('house_name');
            $query->where(function ($q) use ($searchName){
                $q->where('house_name', 'LIKE', "%{$searchName}%");
            });
        }
        if($request->has('branch') && !empty($request->input('branch'))){
            $query->where('branch_id', $request->branch);
        }
        if($request->has('status') && !empty($request->input('status'))){
            $query->where('is_active', $request->status);
        }
        if ($request->has('created_at') && $request->filled('created_at')) {
            $date = $request->input('created_at');
            $query->whereDate('created_at', $date);
        }

        $data = $query->with('school', 'branch')->get();

        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $name = $row->house_name;
                return $name ?? '...';
            })
            ->addColumn('branch', function ($row) {
                $branch = $row->branch->branch_name;
                return $branch ?? '...';
            })
            ->addColumn('is_active', function ($row) {
                if ($row->is_active === 1) {
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">active</span>
                           </div>';
                } else {
                    return '<span class="badge badge-xl light badge-danger text-uppercase">disabled</span>';
                }
                //                return $remodelledStatus ?? '...';
            })
            ->addColumn('created_at', function($row){
                return $row->created_at ?? '...';
            })
            ->addColumn('action', function ($row) {
                $house_id = $row->id;
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
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-house-modal" data-id="' . $house_id . '">Edit House</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-house-modal" data-id="' . $house_id.'">Delete House</a>
                            </div>
                        </div>
                    ';
            })
            ->rawColumns(['type', 'is_active', 'action'])
            ->make(true);
    }

    public function HousesDatatableExport(Request $request){
        $query =  House::query()->where(['school_id' => Auth::guard('admin')->user()->school_id])->orderBy('created_at', 'DESC');

        // apply filters
        if($request->has('house_name') && !empty($request->input('house_name'))){
            $searchName = $request->input('house_name');
            $query->where(function ($q) use ($searchName){
                $q->where('house_name', 'LIKE', "%{$searchName}%");
            });
        }
        if($request->has('branch') && !empty($request->input('branch'))){
            $query->where('branch_id', $request->branch);
        }
        if($request->has('status') && !empty($request->input('status'))){
            $query->where('is_active', $request->status);
        }
        if ($request->has('created_at') && $request->filled('created_at')) {
            $date = $request->input('created_at');
            $query->whereDate('created_at', $date);
        }

        $data = $query->with('school', 'branch')->get();

        return Excel::download(new HousesListExport($data), 'Houses_List_'.date('Y-m-d H:i:s').'.xlsx');

    }
}
