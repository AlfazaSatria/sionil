<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $table= 'remark';

    protected $fillable=[
        'siswa_id',
        'note'
    ];
}
