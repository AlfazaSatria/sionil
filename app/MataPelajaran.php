<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'matapelajaran';

    protected $fillable=['kode_mp','nama_mp','jml_jam'];
}
