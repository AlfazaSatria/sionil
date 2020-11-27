<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Tahfiz extends Model
{
    use SoftDeletes;

    protected $fillable = ['id_cardTahfiz', 'nip', 'nama_tahfiz', 'mapel_id', 'kode', 'jk', 'telp', 'tmp_lahir', 'tgl_lahir', 'foto'];

    public function mapel()
    {
        return $this->belongsTo('App\Mapel')->withDefault();
    }

    // public function dsk($id)
    // {
    //     $dsk = Nilai::where('tahfiz_id', $id)->first();
    //     return $dsk;
    // }

    protected $table = 'tahfiz';
}
