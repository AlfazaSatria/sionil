<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use App\MataPelajaran;
use App\Guru;
use App\Ruangan;
use App\Jampelajaran;
use App\Jadwalpelajaran;

class JadwalpelajaranController extends Controller
{
    function index(Request $request){

        $kelas  = $request->get('kelas');
        $semester = $request->get('semester');


        $data['jadwal'] = \DB::table('jadwal_kuliah')
                    ->join('matapelajaran','matapelajaran.kode_mp','=','jadwal_kuliah.kode_mp')
                    ->join('guru','guru.kode_guru','=','jadwal_kuliah.kode_guru')
                    ->join('ruangan','ruangan.kode_ruangan','=','jadwal_kuliah.kode_ruangan')
                    ->join('jam_kuliah','jam_kuliah.id','=','jadwal_kuliah.jam')
                    ->where('jadwal_kuliah.kode_kelas',$kelas)
                    ->where('jadwal_kuliah.semester',$semester)
                    ->get();
        $data['kelas'] = Kelas::pluck('nama_kelas','kode_kelas');
        $data['kelas_terpilih'] = $kelas;
        $data['semester_terpilih'] = $semester;

        return view('jadwalpelajaran.index',$data);
    }


    function create(){
        $data['matapelajaran'] = Matapelajaran::pluck('nama_mp','kode_mp');
        $data['kelas'] = Kelas::pluck('nama_kelas','kode_kelas');
        $data['guru'] = Guru::pluck('nama','kode_guru');
        $data['ruangan'] = Ruangan::pluck('nama_ruangan','kode_ruangan');
        $data['jampelajaran'] = jampelajaran::pluck('jam','id');
        $data['hari'] = ['senin'=>'senin','selasa'=>'selasa','rabu'=>'rabu','kamis'=>'kamis','jumat'=>'jumat','sabtu'=>'sabtu','minggu'=>'minggu'];
        $data['tahun_akademik'] = \DB::table('tahun_akademik')->where('status','y')->first();
        return view('jadwalpelajaran.create',$data);
    }

    function store(request $request)
    {
        $jadwal = new jadwalPelajaran();
        $jadwal->create($request->all());
        return redirect('jadwalpelajaran')->with('status','Jadwal Kuliah Berhasil Di Input');
    }
}
