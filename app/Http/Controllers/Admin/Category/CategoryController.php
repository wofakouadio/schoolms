<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //index
    public function index(){
        return view('admin.dashboard.category.index');
    }

    //store
    public function store(Request $request){
        $request->validate([
            'category_name' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Category::create([
                'category_name' => $request->category_name,
                'category_description' => $request->category_description,
                'school_id' => $request->school_id
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Category created successfully'
            ]);
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //edit
    public function edit(Request $request){
        $data = Category::where('id', $request->category_id)->first();
        return response()->json($data);
    }

    //update
    public function update(Request $request){
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
        }catch (\Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 201,
                'msg' => 'Error: something went wrong. More Details : ' . $th->getMessage()
            ]);
        }
    }

    //delete
    public function delete(Request $request){
        DB::beginTransaction();
        try {
            Category::where('id', $request->category_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'msg' => 'Category deleted successfully'
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
