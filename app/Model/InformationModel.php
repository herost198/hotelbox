<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InformationModel extends Model
{
    protected  $table = 'tlhotel_information';
    protected $keyType = 'string';
    public function user(){
        return $this->hasOne('App\Model\AdminModel','hotel_id','id');
    }
    public function background(){
        return $this->hasOne('App\Model\BackgroundModel');
    }
    public function service(){
        return $this->hasOne('App\Model\ServiceModel');
    }
    public function cumphong(){
        return $this->hasOne('App\Model\cumPhongModel','hotel_id','id');
    }
    public $timestamps = false;
}
