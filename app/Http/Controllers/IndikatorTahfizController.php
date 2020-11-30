<?php

namespace App\Http\Controllers;

use App\IndikatorTahfiz;
use App\Kelas;
use App\NilaiIndikatorTahfiz;
use App\Tahfiz;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class IndikatorTahfizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahfiz = Tahfiz::where('id_cardTahfiz', Auth::user()->id_cardTahfiz)->first();
        $indikatorTahfiz = IndikatorTahfiz::where('tahfiz_id', $tahfiz->id)->get();
        return view('tahfiz.indikator.indikator', compact('tahfiz', 'indikatorTahfiz'));
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
            'tahfiz_id' => 'required|numeric',
            'indikator' => 'required',
        ]);
        IndikatorTahfiz::updateOrCreate(
            [ 'id' => $request->id ],
            [
                'tahfiz_id' => $request->tahfiz_id,
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
        $tahfiz = Tahfiz::where('id_cardTahfiz', Auth::user()->id_cardTahfiz)->first();
        $indikatorTahfiz = IndikatorTahfiz::where('tahfiz_id', $tahfiz->id)->get();
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::where('kelas_id', $id)->get();
        return view('tahfiz.indikator.nilai', compact('tahfiz', 'indikatorTahfiz', 'kelas', 'siswa'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $indikator = IndikatorTahfiz::findorfail($id);
        $indikator->delete();
        return redirect()->back()->with('success', 'Indikator di hapus!');
    }

    public function input_nilai(Request $request)
    {
        $id = null;
        $existing = NilaiIndikatorTahfiz::where([
            ['indikator_id', '=', $request->indikator_id],
            ['siswa_id', '=', $request->siswa_id],
        ])
        ->get()
        ->first();

        if ($existing) {
            $id = $existing->id;
        }
        NilaiIndikatorTahfiz::updateOrCreate(
            [ 'id' => $id ],
            [
                'siswa_id' => $request->siswa_id,
                'indikator_id' => $request->indikator_id,
                'baris' => $request->baris,
                'salah' => $request->salah,               
                'nilai_indikator' => $request->nilai_indikator,
            ]
        );
        return redirect()->back()->with('success', 'Success!');
    }
}
