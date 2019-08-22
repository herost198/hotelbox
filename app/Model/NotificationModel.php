<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    protected $table = 'tlhotel_notification';
    protected $keyType = 'string';
    public $timestamps = false;

    public function phong(){
        return $this->hasOne('App\Model\PhongModel','id','id');
    }
}
