<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Nilai;
use App\Tahfiz;
use App\Siswa;
use App\Kelas;
use App\JadwalTahfiz;
use App\RapotTahfiz;
use App\NilaiIndikatorTahfiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RapotTahfizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahfiz = Tahfiz::where('id_cardTahfiz', Auth::user()->id_cardTahfiz)->first();
        $jadwalTahfiz = JadwalTahfiz::where('tahfiz_id', $tahfiz->id)->orderBy('kelas_id')->get();
        $kelas = $jadwalTahfiz->groupBy('kelas_id');

        return view('tahfiz.rapot.index', compact('tahfiz','kelas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.rapot.home', compact('kelas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($encryption)
    {
        $id = Crypt::decrypt($encryption);
        $tahfiz = Tahfiz::where('id_cardTahfiz', Auth::user()->id_cardTahfiz)->first();
        $kelas = Kelas::where('id', $id)->get()->first();
        $siswa = Siswa::where('kelas_id', $id)->get();
        return view('tahfiz.rapot.rapot', compact('tahfiz', 'kelas', 'siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::orderBy('nama_siswa')->where('kelas_id', $id)->get();
        return view('admin.rapot.index', compact('kelas', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function input_nilai(Request $request)
    {
        $id = null;
        $existing = RapotTahfiz::where([
            ['siswa_id', '=', $request->siswa_id],
        ])
        ->get()
        ->first();

        if ($existing) {
            $id = $existing->id;
        }

        
        RapotTahfiz::updateOrCreate(
            [ 'id' => $id ],
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
