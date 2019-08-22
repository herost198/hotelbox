<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PopUpModel extends Model
{
    protected  $table = 'tlhotel_popup';
    protected $keyType = 'string';
    public $timestamps = false;

    public function hotelInformation(){
        return $this->belongsTo('App\Model\InformationModel','hotel_id','id');
    }
}
