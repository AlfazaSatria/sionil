<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BimbinganKonseling extends Model
{
    protected $table = 'bk';

    protected $fillable=[
        'name',
        'id_cardBK',
        'jk',
        'foto',
    ];
}
