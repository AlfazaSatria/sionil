<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Nilai;
use App\Tahfiz;
use App\Siswa;
use App\Kelas;
use App\JadwalTahfiz;
use App\RapotTahfiz;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RapotExport;
use App\NilaiIndikatorTahfiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
class RapotTahfizController extends Controller
{

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

   

    public function input_nilai(Request $request)
    {
        
        RapotTahfiz::updateOrCreate(
            [
            'tahfiz_id' => $request->tahfiz_id,
            'siswa_id' => $request->siswa_id,
            'membaca' => $request->membaca,
            'mendengarkan' => $request->mendengarkan,
            'menghafal' => $request->menghafal,
            'mengikuti' => $request->mengikuti,
        ]);
        return redirect()->back()->with('success', 'Success!');
    }

    public function datakelas(){
        $tahfiz = Tahfiz::where('id_cardTahfiz', Auth::user()->id_cardTahfiz)->first();
        $jadwal = JadwalTahfiz::where('tahfiz_id', $tahfiz->id)->orderBy('kelas_id')->get();
        $kelas = $jadwal->groupBy('kelas_id');
        return view('tahfiz.rapot.datakelas', compact('kelas', 'tahfiz'));
    }
    
    public function datasiswa($encryption){
        $decrypt = Crypt::decrypt($encryption);
        $id = $decrypt['id'];
        $tahfiz = Tahfiz::where('id_cardTahfiz', Auth::user()->id_cardTahfiz)->first();
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::where('kelas_id', $id)->get();
        return view('tahfiz.rapot.datasiswa', compact('tahfiz', 'kelas', 'siswa'));
    }

    public function export_excel($encryption)
    {
        $id= Crypt::decrypt($encryption);
        return Excel::download(new RapotExport($id), 'RaportTahfiz.xlsx');
    }
    
}
