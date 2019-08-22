<?php

namespace App\Http\Controllers;

use App\Model\BoxTvModel;
use App\Model\cumPhongModel;
use App\Model\PhongModel;
use Illuminate\Http\Request;

use App\Http\Requests;

class AjaxController extends Controller
{

    public function getCumPhong($hotel_id){
        $cumphongs = cumPhongModel::where('hotel_id',$hotel_id)->get();
//        echo "<option value='" .$cumphongs[0]->id ."' selected>" .$cumphongs[0]->name. "</option>";
        for($i = 0; $i< count($cumphongs); $i++){
            echo "<option value='" .$cumphongs[$i]->id ."'>" .$cumphongs[$i]->name. "</option>";
        }
    }
    public function getPhong($cumphong_id){
        $phongs = PhongModel::where('cumphong_id',$cumphong_id)->get();

        foreach($phongs as $phong){
            if($phong->check == 1)echo "<option value='" .$phong->id ."'selected>" .$phong->name. "</option>";
            else echo "<option value='" .$phong->id ."'>" .$phong->name. "</option>";

        }
    }
    public function getPhong1($cumphong_id){
        $phongs = PhongModel::where('cumphong_id',$cumphong_id)->get();

        foreach($phongs as $phong){
            if($phong->check != 1)
             echo "<option  >" .$phong->name. "</option>";

//             echo "<option data-value='" .$phong->id ."' value=".$phong->name.">";

        }
    }

    public function getCP($hotel_id, $cumphong_id){
        $cumphongs = cumPhongModel::where('hotel_id',$hotel_id)->get();

        foreach ($cumphongs as $cumphong){
            if($cumphong->id == $cumphong_id ){
                echo "<option value='" .$cumphong->id ."' selected>" .$cumphong->name. "</option>";
            }else{
                echo "<option value='" .$cumphong->id ."'>" .$cumphong->name. "</option>";
            }
        }
    }

    public function getP($cumphong_id, $phong_id){
        $phongs = PhongModel::where('cumphong_id',$cumphong_id)->get();

        foreach($phongs as $phong){
            if($phong->id == $phong_id){
                echo "<option value='" .$phong->id ."' selected>" .$phong->name. "</option>";
            }else {
                echo "<option value='" .$phong->id ."'>" .$phong->name. "</option>";

            }
        }
    }

    public function getBox($phong_id){
        $boxs = BoxTvModel::where('phong_id',$phong_id)->get();

        foreach($boxs as $box){
//                echo "<option value='" .$box->id ."'>" .$box->mac. "</option>";
                echo "<option >" .$box->mac. "</option>";
        }
    }
}
