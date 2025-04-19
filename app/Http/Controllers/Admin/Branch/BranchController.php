<?php

namespace App\Http\Controllers\Admin\Branch;

use App\Exports\BranchesListDataTableExport;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use function App\Helpers\TermAndAcademicYear;

class BranchController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.branch.index', compact('schoolTerm'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required',
            'branch_address' => 'required',
            'branch_email' => 'required|lowercase|email',
            'branch_contact' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Branch::create([
                'branch_name' => strtoupper($request->branch_name),
                'branch_description' => $request->branch_description,
                'branch_location' => $request->branch_address,
                'branch_email' => $request->branch_email,
                'branch_contact' => $request->branch_contact,
                'school_id' => Auth::guard('admin')->user()->school_id //$request->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Branch created successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //fetch branch data
    public function edit(Request $request)
    {
        $data = Branch::where('id', $request->branch_id)->first();
        return response()->json($data);
    }

    //update branch data
    public function update(Request $request)
    {
        $request->validate([
            'branch_name' => 'required',
            'branch_address' => 'required',
            'branch_email' => 'required|lowercase|email',
            'branch_contact' => 'required'
        ]);

        DB::beginTransaction();

        try {
            Branch::where('id', $request->branch_id)->update([
                'branch_name' => strtoupper($request->branch_name),
                'branch_description' => $request->branch_description,
                'branch_location' => $request->branch_address,
                'branch_email' => $request->branch_email,
                'branch_contact' => $request->branch_contact,
                'is_active' => $request->branch_is_active ? 1 : 0
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Branch updated successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //delete branch data
    public function delete(Request $request)
    {
        DB::beginTransaction();

        try {
            Branch::where('id', $request->branch_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Branch deleted successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //get branches based on school id
    public function getBranchesBySchoolId(Request $request)
    {
        $school_id = Auth::guard('admin')->user()->school_id; //$request->school_id;
        $output = [];
        $branches = Branch::select('id', 'branch_name')->where('school_id', $school_id)->where('is_active', 1)->get();
        $output[] = "<option value=''>Choose</option>";
        foreach ($branches as $branch) {
            $output[] = "<option value='" . $branch->id . "'>" . $branch->branch_name . "</option>";
        }
        return $output;
    }

    // branch DataTable
    public function branches_datatables_list(Request $request){
        $query = Branch::query()
            ->where([
                'school_id' => Auth::guard('admin')->user()->school_id
            ])->orderBy('created_at', 'DESC');

        // apply filters
        if($request->has('branch_is_active') && !empty($request->input('branch_is_active'))){
            $query->where('is_active', $request->branch_is_active);
        }
        if($request->has('branch_name') && !empty($request->input('branch_name'))){
            $searchName = $request->input('branch_name');
            $query->where(function ($q) use ($searchName){
                $q->where('branch_name', 'LIKE', "%{$searchName}%");
            });
        }
        if($request->has('branch_contact') && !empty($request->input('branch_contact'))){
            $query->where('branch_contact', $request->branch_contact);
        }
        if($request->has('branch_location') && !empty($request->input('branch_location'))){
            $searchName = $request->input('branch_location');
            $query->where(function ($q) use ($searchName){
                $q->where('branch_location', 'LIKE', "%{$searchName}%");
            });
            // $query->where('branch_location', $request->branch_location);
        }
        if($request->has('branch_email') && !empty($request->input('branch_email'))){
            $query->where('branch_email', $request->branch_email);
        }
        if ($request->has('created_at') && $request->filled('created_at')) {
            $query->where('created_at', $request->input('created_at'));
        }

        // dd($query);
        // $data = Branch::where('school_id', Auth::guard('admin')->user()->school_id)->orderBy('created_at', 'DESC');
        // $data = DB::select('select * FROM branches WHERE school_id = ?', [Auth::guard('admin')
        //     ->user()->school_id]);
        $data = $query->with('school')->get();

        return DataTables::of($data)

            ->addColumn('name', function ($row) {
                $name = $row->branch_name;
                return $name ?? '...';
            })
            ->addColumn('contact', function ($row) {
                $contact = $row->branch_contact;
                return $contact ?? '...';
            })
            ->addColumn('email', function ($row) {
                $email = $row->branch_email;
                return $email ?? '...';
            })
            ->addColumn('location', function ($row) {
                $location = $row->branch_location;
                return $location ?? '...';
            })
            ->addColumn('created_at', function ($row) {
                $created_at = $row->created_at;
                return $created_at ?? '...';
            })
            ->addColumn('is_active', function ($row) {
                //                $department_status =;
                if ($row->is_active === 1) {
                    return '<div class="bootstrap-badge">
                                <span class="badge badge-xl light badge-success text-uppercase">active</span>
                           </div>';
                } else {
                    return '<span class="badge badge-xl light badge-danger text-uppercase">disabled</span>';
                }
                //                return $remodelledStatus ?? '...';
            })
            ->addColumn('action', function ($row) {
                $branch_id = $row->id;
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
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-branch-modal" data-id="' . $branch_id . '">Edit Branch</a>
                                <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-branch-modal" data-id="' . $branch_id. '">Delete Branch</a>
                            </div>
                        </div>
                    ';
//                return '<div class="d-flex">
//                            <a data-bs-toggle="modal" data-bs-target="#edit-branch-modal" data-id="' . $branch_id . '"
//                            class="btn btn-primary shadow btn-xs sharp me-1">
//                                <i class="fas fa-pencil-alt"></i>
//                            </a>
//                            <a data-bs-toggle="modal" data-bs-target="#delete-branch-modal" data-id="' . $branch_id
//                    . '" class="btn btn-danger shadow btn-xs sharp">
//                                <i class="fa fa-trash"></i>
//                            </a>
//                         </div>
//                ';
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }


    public function export_branches_datatables_list(Request $request){
        $query = Branch::query()
            ->where([
                'school_id' => Auth::guard('admin')->user()->school_id
            ])->orderBy('created_at', 'DESC');

        // apply filters
        if($request->has('branch_is_active') && !empty($request->input('branch_is_active'))){
            $query->where('is_active', $request->branch_is_active);
        }
        if($request->has('branch_name') && !empty($request->input('branch_name'))){
            $searchName = $request->input('branch_name');
            $query->where(function ($q) use ($searchName){
                $q->where('branch_name', 'LIKE', "%{$searchName}%");
            });
        }
        if($request->has('branch_contact') && !empty($request->input('branch_contact'))){
            $query->where('branch_contact', $request->branch_contact);
        }
        if($request->has('branch_location') && !empty($request->input('branch_location'))){
            $searchName = $request->input('branch_location');
            $query->where(function ($q) use ($searchName){
                $q->where('branch_location', 'LIKE', "%{$searchName}%");
            });
            // $query->where('branch_location', $request->branch_location);
        }
        if($request->has('branch_email') && !empty($request->input('branch_email'))){
            $query->where('branch_email', $request->branch_email);
        }
        if ($request->has('created_at') && $request->filled('created_at')) {
            $query->whereDate('created_at', $request->input('created_at'));
        }

        // dd($query);
        // $data = Branch::where('school_id', Auth::guard('admin')->user()->school_id)->orderBy('created_at', 'DESC');
        // $data = DB::select('select * FROM branches WHERE school_id = ?', [Auth::guard('admin')
        //     ->user()->school_id]);
        $data = $query->with('school')->get();

        return Excel::download(new BranchesListDataTableExport($data), 'Branches_List_'.date('Y-m-d H:i:s').'.xlsx');
    }
}
