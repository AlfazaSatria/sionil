<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TahfizhController extends Controller
{
    public function index()
    {
        return view('tahfizh.index');
    }
}
