<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ekstrakulikuler extends Model
{
    protected $table ='ekstrakulikuler';

    protected $fillable=[
        'siswa_id',
        'mapel_id',
        'mapel_name',
        'score',
        'description'
    ];

    
}
