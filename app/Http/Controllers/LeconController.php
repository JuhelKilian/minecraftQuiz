<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeconController extends Controller
{
    public function index()
    {
        return view('lecon.index');
    }
}
