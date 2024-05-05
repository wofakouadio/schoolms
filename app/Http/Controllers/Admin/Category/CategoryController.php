<?php

namespace App\Http\Controllers\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\TermAndAcademicYear;

class CategoryController extends Controller
{
    //index
    public function index()
    {
        $schoolTerm = TermAndAcademicYear();
        return view('admin.dashboard.category.index', compact('schoolTerm'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Category::create([
                'category_name' => $request->category_name,
                'category_description' => $request->category_description,
                'school_id' => Auth::guard('admin')->user()->school_id //$request->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Category created successfully'
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
        $data = Category::where('id', $request->category_id)->first();
        return response()->json($data);
    }

    //update
    public function update(Request $request)
    {
        $request->validate([
            'category_name' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Category::where('id', $request->category_id)->update([
                'category_name' => $request->category_name,
                'category_description' => $request->category_description,
                'is_active' => $request->category_is_active
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Category updated successfully'
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
            Category::where('id', $request->category_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Category deleted successfully'
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //Category based on school ID
    public function getCategoriesBySchoolId(Request $request)
    {
        $school_id = $request->school_id;
        $output = [];
        $categories = Category::select('id', 'category_name')->where('school_id', $school_id)->where('is_active', 1)
            ->get();
        $output[] .= "<option value=''>Choose</option>";
        foreach ($categories as $category) {
            $output[] .= "<option value='" . $category->id . "'>" . $category->category_name . "</option>";
        }
        return $output;
    }
}
