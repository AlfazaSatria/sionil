<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndikatorTahfiz extends Model
{
    protected $table = 'indikator_tahfiz';

    protected $fillable=[
        'id',
        'tahfiz_id',
        'indikator'
    ];

    public function nilai($siswa_id) {
        $nilai = NilaiIndikatorTahfiz::where([
            ['indikator_id', '=', $this->id],
            ['siswa_id', '=', $siswa_id],
        ])->get();
        return $nilai;
    }

}
