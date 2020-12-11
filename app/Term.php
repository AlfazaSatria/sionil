<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $table = 'term';
    protected $fillable=[
        'term',
        'semester',
        'kepsek',
        'delivered_on'
    ];

}