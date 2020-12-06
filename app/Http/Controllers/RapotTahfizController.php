<?php

namespace App\Http\Controllers;


use App\RapotTahfiz;
use App\NilaiIndikatorTahfiz;
use Illuminate\Http\Request;


class RapotTahfizController extends Controller
{
       

    public function input_nilai(Request $request)
    {
        
        RapotTahfiz::updateOrCreate(
            [
            'siswa_id' => $request->siswa_id,
            'membaca' => $request->membaca,
            'mendengarkan' => $request->mendengarkan,
            'menghafal' => $request->menghafal,
            'mengikuti' => $request->mengikuti,
        ]);
        return redirect()->back()->with('success', 'Success!');
    }
}
