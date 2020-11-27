<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Indikator;
use App\Kelas;
use App\Nilai;
use App\NilaiIndikator;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class IndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $indikators = Indikator::where('guru_id', $guru->id)->get();
        return view('guru.indikator.indikator', compact('guru', 'indikators'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guru_id' => 'required|numeric',
            'tipe' => 'required',
            'indikator' => 'required',
        ]);
        Indikator::updateOrCreate(
            [ 'id' => $request->id ],
            [
                'guru_id' => $request->guru_id,
                'tipe' => ($request->tipe),
                'indikator' => $request->indikator,
            ]
        );
        return redirect()->back()->with('success', 'Success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($encryption)
    {
        $decrypt = Crypt::decrypt($encryption);
        $id = $decrypt['id'];
        $tipe = $decrypt['tipe'];
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $indikators = Indikator::where([
            [ 'guru_id', '=', $guru->id ],
            [ 'tipe', '=', $tipe ]
        ])->get();
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::where('kelas_id', $id)->get();
        return view('guru.indikator.nilai', compact('guru', 'indikators', 'kelas', 'siswa'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $indikator = Indikator::findorfail($id);
        $indikator->delete();
        return redirect()->back()->with('success', 'Indikator di hapus!');
    }

    public function input_nilai(Request $request)
    {
        $id = null;
        $existing = NilaiIndikator::where([
            ['indikator_id', '=', $request->indikator_id],
            ['siswa_id', '=', $request->siswa_id],
        ])
        ->get()
        ->first();

        if ($existing) {
            $id = $existing->id;
        }

        NilaiIndikator::updateOrCreate(
            [ 'id' => $id ],
            [
                'siswa_id' => $request->siswa_id,
                'indikator_id' => $request->indikator_id,
                'nilai_indikator' => $request->nilai_indikator,
            ]
        );
        return redirect()->back()->with('success', 'Success!');
    }
}
