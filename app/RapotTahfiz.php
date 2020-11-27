<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RapotTahfiz extends Model
{
    protected $table = 'rapot_tahfiz';

    protected $fillable=[
        'nilai_tahfiz_id',
        'name_abilities',
        'type',
        'nilai_abilities',
        'rapot',
        'nilai_rapot',
    ];

    public function nilaitahfiz(){
        return $this->hasOne('App\NilaiTahfiz', 'nilai_tahfiz_id');
    }

    
}
