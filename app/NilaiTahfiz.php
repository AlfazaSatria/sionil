<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiTahfiz extends Model
{
    protected $table = 'nilai_tahfiz';

    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'siswa_id',
        'indikator_id',
        'indikator_name',
        'baris',
        'baris_salah',
        'nilai_abilities'
    ];

    public function kelas(){
        return $this->belongsTo('App\Kelas', 'kelas_id');
    }

    public function mapel(){
        return $this->hasOne('App\Mapel', 'mapel_id');
    }

    public function siswa(){
        return $this->hasMany('App\Siswa', 'siswa_id');
    }

    public function rapot(){
        return $this->hasOne('App\RapotTahfiz');
    }
}
