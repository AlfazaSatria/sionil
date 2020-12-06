<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affective extends Model
{
    protected $table = 'affective';
    protected $fillable = [
        'id',
        'siswa_id',
        'spiritual',
        'social',
        'created_at',
        'updated_at',
    ];

    public function siswa()
    {
        return $this->belongsTo('App\Siswa', 'siswa_id');
    }
}
