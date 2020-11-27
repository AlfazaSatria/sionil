<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    protected $fillable = [
        'id',
        'guru_id',
        'tipe',
        'indikator'
    ];

    public function nilai($siswa_id) {
        $nilai = NilaiIndikator::where([
            ['indikator_id', '=', $this->id],
            ['siswa_id', '=', $siswa_id],
        ])->get();
        return $nilai;
    }
}
