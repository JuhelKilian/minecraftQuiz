<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MotController extends Controller
{
    public function index()
    {
        $mots = Mot::orderBy('difficulte')->paginate(20); // trier par difficulté et pagination
        return view('mots.index', compact('mots'));
    }
}
