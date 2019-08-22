<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServiceModel extends Model
{
    protected $table='tlhotel_service';
    protected $keyType = 'string';
    public function information(){
        return $this->belongsTo('App\Model\InformationModel','hotel_id','id');
    }
    public $timestamps = false;
}
