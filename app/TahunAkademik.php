<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $table='tahun_akademik';
    protected $fillable=['kode_tahun_akademik','tahun_akademik'
    ,'status','tanggal_awal_sekolah','tanggal_akhir_sekolah'
    ,'tanggal_awal_uts','tanggal_akhir_uts','tanggal_awal_uas'
    ,'tanggal_akhir_uas'];
}
