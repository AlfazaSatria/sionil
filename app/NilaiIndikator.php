<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiIndikator extends Model
{
    protected $table = 'nilai_indikators';
    protected $fillable = [
        'id', 'indikator_id', 'siswa_id', 'nilai_indikator'
    ];
}
