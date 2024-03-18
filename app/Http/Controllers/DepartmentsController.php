<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
