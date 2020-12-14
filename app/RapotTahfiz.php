<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RapotTahfiz extends Model
{
    protected $table = 'rapot_tahfiz';

    protected $fillable=[
        'tahfiz_id',
        'siswa_id',
        'membaca',
        'mendengarkan',
        'mengikuti',
        'menghafal',
        'membaca',
        'mendengarkan',
        'mengikuti',
        'menghafal',  
    ];


    public function siswa(){
        return $this->hasOne('App\Siswa', 'siswa_id');
    }
    
    public function nilai($siswa_id) {
        $nilai = NilaiIndikatorTahfiz::where([
            ['indikator_id', '=', $this->id],
            ['siswa_id', '=', $siswa_id],
        ])->get();
        return $nilai;
    }
    
}
