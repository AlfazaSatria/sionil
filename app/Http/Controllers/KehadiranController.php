<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kehadiran;

class KehadiranController extends Controller
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
        return view('kehadiran.index',$data);
    }

    function create($id_jadwal)
    {
        $jadwal = \DB::table('jadwal_pelajaran')
                ->join('guru','guru.kode_guru','=','jadwal_pelajaran.kode_guru')
                ->join('matapelajaran','matapelajaran.kode_mp','=','jadwal_pelajaran.kode_mp')
                ->where('id',$id_jadwal)->first();

        $pertemuan = \DB::table('kehadiran')
                    ->where('kode_mp',$jadwal->kode_mp)
                    ->where('kode_guru',$jadwal->kode_guru)
                    ->where('kode_tahun_akademik',$jadwal->kode_tahun_akademik)
                    ->where('kode_kelas',$jadwal->kode_kelas)->count();


        $data['jadwal']    = $jadwal;
        $data['pertemuan_ke'] = $pertemuan+1;
        return view('kehadiran.create',$data);
    }

    function store(Request $request,$id_jadwal){

        $jadwal = \DB::table('jadwal_pelajaran')->where('id',$id_jadwal)->first();

        $kehadiran = new Kehadiran;
        $kehadiran->kode_mp             = $jadwal->kode_mp;
        $kehadiran->kode_guru          = $jadwal->kode_guru;
        $kehadiran->kode_kelas        = $jadwal->kode_kelas;
        $kehadiran->kode_ruang          = $jadwal->kode_ruangan;
        $kehadiran->kode_tahun_akademik = $jadwal->kode_tahun_akademik;
        $kehadiran->pertemuan_ke        = $request->pertemuan_ke;
        $kehadiran->save();

        $lastID = $kehadiran->id;

        return redirect('kehadiran/'.$lastID.'/absen/');

    }


    function show($id_kehadiran)
    {
        $kehadiran          = \DB::table('kehadiran')
                            ->join('guru','guru.kode_guru','=','kehadiran.kode_guru')
                            ->join('matapelajaran','matapelajaran.kode_mp','=','kehadiran.kode_mp')
                            ->first();

        $data['mahasiswa'] = \DB::table('raport')
                            ->join('mahasiswa','mahasiswa.nisn','=','raport.nisn')
                            ->where('raport.kode_guru',$kehadiran->kode_guru)
                            ->where('raport.kode_mp',$kehadiran->kode_mp)
                            ->get();
        $data['kehadiran'] = $kehadiran;
        return view('kehadiran.show',$data);
    }

    function update(Request $request)
    {
        $chek = \DB::table('riwayat_kehadiran')
        ->where('nisn',$request->nisn)
        ->where('kehadiran_id',$request->id_kehadiran)
        ->count();
        if($chek>0)
        {
            // lakukan update

            \DB::table('riwayat_kehadiran')
                    ->where('kehadiran_id',$request->id_kehadiran)
                    ->update([
                    'status_kehadiran'=>$request->status_kehadiran
                    ]);
        }else{
            // lakukan insert
            \DB::table('riwayat_kehadiran')
                    ->insert([
                            'nisn'=>$request->nisn,
                            'kehadiran_id'=>$request->id_kehadiran,
                            'status_kehadiran'=>$request->status_kehadiran,
                            'pertemuan_ke' => $request->pertemuan_ke
                            ]);
        }
        
    }
}
