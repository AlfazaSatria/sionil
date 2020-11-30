<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ulangan extends Model
{
    protected $table = 'ulangan';
    protected $fillable = [
        'id', 'siswa_id', 'kelas_id', 'guru_id', 'mapel_id',
        'uts', 'tipe_uts',
        'uas', 'tipe_uas'
    ];
}
