<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PhongModel extends Model
{
    protected $table = 'tlhotel_phong';
    protected $keyType = 'string';
    public $timestamps = false;
    public function cumphong(){
        return $this->belongsTo('App\Model\cumPhongModel','cumphong_id','id');
    }

    public function boxtv(){
        return $this->hasOne('App\Model\BoxTvModel');
    }

    public function notification(){
        return $this->hasOne('App\Model\NotificationModel','id','id');
    }
}
