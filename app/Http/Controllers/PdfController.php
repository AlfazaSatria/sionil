<?php

namespace App\Http\Controllers;

use App\IndikatorTahfiz;
use App\NilaiIndikatorTahfiz;
use Illuminate\Http\Request;
use PDF;
use App\Siswa;
use Illuminate\Support\Facades\Auth;
class PdfController extends Controller
{
  public function PDFTahfiz()
  {
    $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
    $nilaiIndikator= NilaiIndikatorTahfiz::firstwhere('siswa_id', $siswa->id);
    $indikatorTahfiz=IndikatorTahfiz::where('id', $nilaiIndikator->indikator_id)->get();
    $indikator = IndikatorTahfiz::firstwhere('id', $nilaiIndikator->indikator_id);
    return view('RapotTahfiz', compact('siswa','nilaiIndikator','indikatorTahfiz','indikator'));
    $data = ['title' => 'Raport Tahfiz'];
        $pdf = PDF::loadView('RapotTahfiz', $data);
  
        return $pdf->download('RapotTahfizMumtaz.pdf');
  }

}

