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
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
class RapotTahfizController extends Controller
{
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
    
}
