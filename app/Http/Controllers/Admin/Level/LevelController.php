<?php

namespace App\Http\Controllers\Admin\Level;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    //index
    public function index(){
        return view('admin.dashboard.level.index');
    }
}
