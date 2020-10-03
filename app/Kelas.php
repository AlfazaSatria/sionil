<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table="kelas";

    protected $fillable=['kode_kelas','nama_kelas','kode_jenjang'];
}
