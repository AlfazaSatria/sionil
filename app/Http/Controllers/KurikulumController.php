<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use App\MataPelajaran;
use App\Kurikulum;

class KurikulumController extends Controller
{
    function index(Request $request){
        $kelas = $request->get('kelas');
        
        $data['kurikulum'] =  \DB::table('kurikulum')
                             ->join('matapelajaran','matapelajaran.kode_mp','=','kurikulum.kode_mp')
                             ->join('kelas','kelas.kode_kelas','=','kurikulum.kode_kelas')
                             ->where('kurikulum.kode_kelas',$kelas)
                             ->get();


        $data['kelas'] = Kelas::pluck('nama_kelas','kode_kelas');
        $data['kelas_terpilih'] = $kelas;
        return view('kurikulum.index',$data);
    }


    function create(){
        $data['kelas'] = Kelas::pluck('nama_kelas','kode_kelas');
        $data['matapelajaran'] = Matapelajaran::pluck('nama_mp','kode_mp');
        return view('kurikulum.create',$data);
    }

    function store(Request $request){
        $kurikulum = new Kurikulum();
        $kurikulum->create($request->all());
        return redirect('kurikulum')->with('status','Input Data Kurikulum Berhasil');
    }

    function destroy($id){
        $kurikulum = Kurikulum::find($id);
        $kurikulum->delete();
        return redirect('kurikulum')->with('status','Data Kurikulum Berhasil Dihapus');
    }
}
