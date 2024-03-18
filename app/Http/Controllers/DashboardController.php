<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //load main dashboard
    public function index(){
        return view("dashboard/index");
    }
}
