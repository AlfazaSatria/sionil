<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NilaiController extends Controller
{
    function index($id_jadwal){
        $jadwal = \DB::table('jadwal_pelajaran')
                ->join('guru','guru.kode_guru','=','jadwal_pelajaran.kode_guru')
                ->join('matapelajaran','matapelajaran.kode_mp','=','jadwal_pelajaran.kode_mp')
                ->where('id',$id_jadwal)->first();

        $data['mahasiswa'] = \DB::table('raport')
                            ->join('mahasiswa','mahasiswa.nisn','=','raport.nisn')
                            ->where('raport.kode_guru',$jadwal->kode_guru)
                            ->where('raport.kode_mp',$jadwal->kode_mp)
                            ->get();
        $data['jadwal']    = $jadwal;
        return view('nilai.index',$data);
    }

    function update_nilai(request $request)
    {
        $nilai = \DB::table('raport')
                ->where('id',$request->id_raport)
                ->update([
                    'nilai_uas'         =>  $request->nilai_uas,
                    'nilai_uts'         =>  $request->nilai_uts,
                    'nilai_kehadiran'   =>  $request->nilai_kehadiran,
                    'nilai_tugas'       =>  $request->nilai_tugas
                    ]);
    }
}
