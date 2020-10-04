<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table="siswa";

    protected $fillable=['nisn','nama_siswa','email','password','kode_kelas','alamat','kode_tahun_akademik','semester_aktif','password'];
}
