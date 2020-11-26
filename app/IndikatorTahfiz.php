<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndikatorTahfiz extends Model
{
    protected $table = 'indikator_tahfiz';

    protected $fillable=[
        'kelas_id',
        'mapel_id',
        'indikator'
    ];

    public function kelas(){
        return $this->belongsTo('App\Kelas', 'kelas_id');
    }

    public function mapel(){
        return $this->belongsTo('App\Mapel', 'mapel_id');
    }
}
