<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BoxTvModel extends Model
{

    protected $table = 'tlhotel_boxtv';
    protected $keyType = 'string';
    public $timestamps = false;

    public function phong(){
        return $this->belongsTo('App\Model\PhongModel','phong_id','id');
    }
}
