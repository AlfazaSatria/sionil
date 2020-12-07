<?php

namespace App\Http\Controllers;

use App\IndikatorTahfiz;
use App\NilaiIndikatorTahfiz;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Siswa;
use Illuminate\Support\Facades\Auth;
class PdfController extends Controller
{
  public function PDFTahfiz()
  {
    $siswa = Siswa::firstwhere('no_induk', Auth::user()->no_induk)->first();
    // $nilai= NilaiIndikatorTahfiz::where('siswa_id', $siswa->id);
    $nilai=DB::table('nilai_indikator_tahfiz')
    ->select(
      'nilai_indikator_tahfiz.id' ,'nilai_indikator_tahfiz.indikator_id','nilai_indikator_tahfiz.siswa_id'
      ,'nilai_indikator_tahfiz.predikat','indikator_tahfiz.indikator'
    )
    ->join('indikator_tahfiz','indikator_tahfiz.id','=','nilai_indikator_tahfiz.indikator_id')
    ->where([
      'nilai_indikator_tahfiz.siswa_id' => $siswa->id
    ])
    ->get();
    // $indikatorTahfiz=IndikatorTahfiz::where('id', $nilai->indikator_id)->get();
    // $indikator = IndikatorTahfiz::firstwhere('id', $nilai->indikator_id);


    return view('RapotTahfiz', compact('siswa','nilai'));
    $data = ['title' => 'Raport Tahfiz'];
        $pdf = PDF::loadView('RapotTahfiz', $data);
  
        return $pdf->download('RapotTahfizMumtaz.pdf');
  }

}

