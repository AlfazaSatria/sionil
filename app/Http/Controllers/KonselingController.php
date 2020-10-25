<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KonselingController extends Controller
{
    public function index()
    {
        return view('konseling.index');
    }
}
