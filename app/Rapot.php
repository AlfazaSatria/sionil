<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rapot extends Model
{
    protected $fillable = ['tipe_rapot', 'siswa_id', 'kelas_id', 'guru_id', 'mapel_id', 'p_nilai', 'p_predikat', 'p_deskripsi', 'k_nilai', 'k_predikat', 'k_deskripsi'];

    protected $table = 'rapot';

    public function guru()
    {
        return Guru::where([
            'id' => $this->guru_id,
        ])->get()->first();
    }

    public function mapel()
    {
        return Mapel::where([
            'id' => $this->mapel_id,
        ])->get()->first();
    }

    public function nilai()
    {
        return Nilai::where([
            'guru_id' => $this->guru()->id,
        ])->get()->first();
    }
}
