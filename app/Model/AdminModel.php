<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminModel extends Authenticatable
{

    public $table = 'tlhotel_users';

    protected $fillable = [
        'username','password','permission'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];


    public function hotelInformation(){
        return $this->belongsTo('App\Model\InformationModel','hotel_id','id');
    }
}
