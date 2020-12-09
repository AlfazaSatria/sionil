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

    public function tahfiz(){
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
       
        $nilai= DB::table('nilai_indikator_tahfiz')
        ->select(
            'nilai_indikator_tahfiz.id','nilai_indikator_tahfiz.nilai_indikator',
            'nilai_indikator_tahfiz.predikat','indikator_tahfiz.indikator'
        )
        ->join('indikator_tahfiz','indikator_tahfiz.id','=','nilai_indikator_tahfiz.indikator_id')
        ->where([
            'nilai_indikator_tahfiz.siswa_id'=>$siswa->id
        ])
        ->get();


        $h = "<!DOCTYPE html>";
            $h .= "<html>";
            $h .= "<body>";
            $h .= "<h2 style='margin-bottom: 0;text-align: center;'>Rapor " . $nilai->predikat . " Semester</h2>";
            
            
            $h .= "</table>";

            $h .= "</body>";
            $h .= "</html>";

            $pdf = new Dompdf();
            $pdf->loadHtml($h);
            $pdf->set_option('isRemoteEnabled', true);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            $pdf->stream("RaporTahfiz" . $siswa->nama_siswa . ".pdf");
    }

    public function input_nilai(Request $request)
    {
        
        RapotTahfiz::updateOrCreate(
            [
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
        return Excel::download(new RapotExport($id), 'test.xlsx');
    }
    
}
