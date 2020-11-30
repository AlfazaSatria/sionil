<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tahfiz;
use App\Siswa;
use App\Kelas;
use App\JadwalTahfiz;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class DataTahfizController extends Controller
{
    public function index()
    {
        $tahfiz = Tahfiz::where('id_cardTahfiz', Auth::user()->id_cardTahfiz)->first();
        $jadwal = JadwalTahfiz::where('tahfiz_id', $tahfiz->id)->orderBy('kelas_id')->get();
        $kelas = $jadwal->groupBy('kelas_id');
        return view('tahfiz.data', compact('kelas', 'tahfiz'));
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $tahfiz = Tahfiz::where('id_cardTahfiz', Auth::user()->id_cardTahfiz)->first();
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::where('kelas_id', $id)->get();
        return view('tahfiz.data', compact('tahfiz', 'kelas', 'siswa'));
    }
}
