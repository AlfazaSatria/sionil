<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiIndikatorTahfiz extends Model
{
    protected $table = 'nilai_indikator_tahfiz';
    protected $fillable = [
        'id', 'indikator_id', 'siswa_id', 'nilai_indikator'
    ];
}
