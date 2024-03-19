<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentsController extends Controller
{
    //index
    public function index(){
        return view("dashboard/department/index");
    }

    // create new department
    public function create(){
        return view("dashboard/department/create");
    }

    // store new department
    public function store(Request $request){
        $request->validate([
            'name'=>['required','string'],
        ]);
        $sql = Department::create([
            'name'=> $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('new-department')->with('success','');
    }
}
