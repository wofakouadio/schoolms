<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;

class SchoolController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'admin_location' => ['required', 'string', 'max:255'],
            'admin_phoneNumber' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.School::class],
        ]);

        // $school = School::create([
        //     'school_name' => $request->school_name,
        //     'admin_location' => $request->school_location,
        //     'admin_phoneNumber' => $request->school_phoneNumber,
        //     'admin_email' => $request->school_email,
        //     'admin_id' =>
        // ]);
    }
}
