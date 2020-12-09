<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use Illuminate\Support\Facades\Crypt;
use App\Siswa;
use App\Affective;
class BKController extends Controller
{
    public function index(){
        $kelas= Kelas::all();
    
        return view('bk.affective', compact('kelas'));
    }

    public function show($encryption){
        $id = Crypt::decrypt($encryption);
        // $kelas = Kelas::findorfail($kelas_id);
        $siswa= Siswa::where('kelas_id', $id)->get();

        return view('bk.show', compact( 'siswa'));
    }

    public function input_nilai(Request $request){
        $id = null;
        $existing = Affective::where([
            ['siswa_id', '=', $request->siswa_id],
        ])
        ->get()
        ->first();

        if ($existing) {
            $id = $existing->id;
        }

        Affective::updateOrCreate(
            [ 'id' => $id ],
            [
                'siswa_id' => $request->siswa_id,
                'spiritual' => $request->spiritual,
                'social' => $request->social,
            ]
        );
        return redirect()->back()->with('success', 'Success!');
    }
}
