<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //index to load login page
    public function index(){
        return view("login");
    }

    // load forgot password page
    public function forgotPasswordPage(){
        return view("forgot-password");
    }
}
