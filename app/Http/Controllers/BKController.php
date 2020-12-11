<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use Illuminate\Support\Facades\Crypt;
use App\Siswa;
use App\Affective;
use App\DescriptionAffective;
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

    public function deskripsi(){
        $deskripsi = DescriptionAffective::where('id', 1)->first();
        return view('bk.deskripsi', compact('deskripsi'));
    }

    public function input_deskripsi(Request $request){
        $this->validate($request, [
            'deskripsi_a_sp' => 'required',
            'deskripsi_b_sp' => 'required',
            'deskripsi_c_sp' => 'required',
            'deskripsi_d_sp' => 'required',
            'deskripsi_a_so' => 'required',
            'deskripsi_b_so' => 'required',
            'deskripsi_c_so' => 'required',
            'deskripsi_d_so' => 'required'

        ]);
        DescriptionAffective::updateOrCreate(
            [
            'id' => $request->id
            ],
            [
                'deskripsi_a_sp' => $request->deskripsi_a_sp,
                'deskripsi_b_sp' => $request->deskripsi_c_sp,
                'deskripsi_c_sp' => $request->deskripsi_c_sp,
                'deskripsi_d_sp' => $request->deskripsi_d_sp,
                'deskripsi_a_so' => $request->deskripsi_a_so,
                'deskripsi_b_so' => $request->deskripsi_c_so,
                'deskripsi_c_so' => $request->deskripsi_c_so,
                'deskripsi_d_so' => $request->deskripsi_d_so,
            ]
        );

        return redirect()->back()->with('success', 'Deskripsi berhasil di perbarui!');
    }
}
