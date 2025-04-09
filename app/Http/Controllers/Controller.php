<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


abstract class Controller
{
    public function index(Request $request)
    {
        return view('admin.login');
    }
}
