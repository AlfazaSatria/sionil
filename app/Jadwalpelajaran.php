<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwalpelajaran extends Model
{
    protected $table=('jadwal_pelajaran');

    protected $fillable=['hari','kode_mp','kode_guru','kode_kelas'
    ,'kode_ruangan','kode_tahun_akademik','semester'];
}
