<?php

namespace App\Exports;

use App\IndikatorTahfiz;
use App\NilaiIndikatorTahfiz;
use App\RapotTahfiz;
use Illuminate\Contracts\View\View;
use App\Tahfiz;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Siswa;
class RapotExport implements FromView, ShouldAutoSize
{

    protected $id;

    function __construct($id)
    {
        $this->id = $id;
    }
    public function view(): View
    {

        $siswa= Siswa::where('id', $this->id)->get()->first();
        
        $id = Auth()->user()->id_cardTahfiz;
        $tahfiz = Tahfiz::where([
            'id_cardTahfiz' => $id
        ])
            ->get()
            ->first();

        // $nilaiIndikators = DB::table('nilai_indikator_tahfiz')
        //     ->select('nilai_indikator_tahfiz.predikat', 'indikator_tahfiz.indikator','nilai_indikator_tahfiz.predikat')
        //     ->join('indikator_tahfiz', 'nilai_indikator_tahfiz.indikator_id', '=', 'indikator_tahfiz.id')
        //     ->where([
        //         'indikator_tahfiz.tahfiz_id' => $tahfiz->id,
        //         'nilai_indikator_tahfiz.siswa_id' => $siswa,
        //     ])->get();

        $nilaiIndikators= NilaiIndikatorTahfiz::where('siswa_id', $siswa->id)->get();

        $rapotTahfiz = RapotTahfiz::where([
            'siswa_id' => $siswa->id
        ])->get()->first();
        
        $indikators= IndikatorTahfiz::where('tahfiz_id', $tahfiz->id)->get();
        return view('tahfiz.rapot.cetak', [
            'nilais' => $nilaiIndikators,
            // 'predikat' => $nilaiIndikators->predikat,
            'nilaiRapot' => $rapotTahfiz,
            'indikators' => $indikators
        ]);
    }
}
