<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapel extends Model
{
    use SoftDeletes;

    protected $fillable = ['id', 'nama_mapel' , 'kelompok'];


    public function sikap($id)
    {
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $nilai = Sikap::where('siswa_id', $siswa->id)->where('mapel_id', $id)->first();
        return $nilai;
    }

    public function cekSikap($id)
    {
        $data = json_decode($id, true);
        $sikap = Sikap::where('siswa_id', $data['siswa'])->where('mapel_id', $data['mapel'])->first();
        return $sikap;
    }

    protected $table = 'mapel';

    public function nilaitahfiz(){
        return $this->hasOne('App\NilaiTahfiz');
    }

    public function nilai($siswa_id) {
        $nilai = Ekstrakulikuler::where([
            ['siswa_id', '=', $siswa_id],
        ])->get();
        return $nilai;
    }

    public function nilaiAchiev($siswa_id) {
        $nilai = Achievement::where([
            ['mapel_id', '=', $this->id],
            ['siswa_id', '=', $siswa_id],
        ])->get();
        return $nilai;
    }
}
