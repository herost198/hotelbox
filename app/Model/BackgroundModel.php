<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BackgroundModel extends Model
{
    protected  $table = 'tlhotel_background';
    protected $keyType = 'string';
    public $timestamps = false;

    public function hotelInformation(){
        return $this->belongsTo('App\Model\InformationModel','hotel_id','id');
    }
}
