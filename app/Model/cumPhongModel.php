<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class cumPhongModel extends Model
{

    protected $table = 'tlhotel_cumphong';
    protected $keyType = 'string';
    public $timestamps = false;
    public function hotelInformation(){
        return $this->belongsTo('App\Model\InformationModel','hotel_id','id');
    }

    public function phong(){
        return $this->hasOne('App\Model\PhongModel');
    }
}
