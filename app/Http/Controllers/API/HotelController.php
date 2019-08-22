<?php

namespace App\Http\Controllers\API;

use App\Model\AdminModel;
use App\Model\BackgroundModel;
use App\Model\BoxTvModel;
use App\Model\cumPhongModel;
use App\Model\NotificationModel;
use App\Model\PhongModel;
use App\Model\PopUpModel;
use App\Model\ServiceModel;
use http\Env\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->only('index');
    }
    public function getCPhong(Request $request){
        $id  = $request->query('id');
        if($id != null){
            $token = $request->header('token');
            $user = AdminModel::where([['access_token',$token],['hotel_id',$id]])->first();
            if($user == null){
                return response()->json([
                    'message'=>'bạn không được phép truy cập dữ liệu này '
                ],202);
            }
            $items =  cumPhongModel::where('hotel_id' , $id)->get();
            $data = [];
            foreach ($items as $item){
                unset($item['hotel_id']);
                array_push($data,$item);
            }
            return \response()->json([
                    'data'=>$data,
                    'message'=>"OK"
                ]
                ,200);
        }
        else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }
    }

    public function  getPhong(Request $request){
        $id  = $request->query('id');
        if($id != null){
            $token = $request->header('token');
            $user = AdminModel::where([['access_token',$token],['hotel_id',$id]])->first();
            if($user == null){
                return response()->json([
                    'message'=>'bạn không được phép truy cập dữ liệu này '
                ],202);
            }
            $items =  cumPhongModel::where('hotel_id' , $id)->get();

            $data = [];
            foreach ($items as $item){
                unset($item['hotel_id']);
                array_push($data,$item);
            }
            return \response()->json([
                    'data'=>$data,
                    'message'=>"OK"
                ]
                ,200);
        }
        else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }
    }

    public function getListRoomByIdCumPhong(Request $request){
        $idcp = $request->query('idcp');
        if($idcp != null){
            $token = $request->header('token');
            $user = AdminModel::where([['access_token',$token]])->first();
            if($user == null){
                return response()->json([
                    'message'=>'bạn không được phép truy cập dữ liệu này '
                ],202);
            }
            $items = PhongModel::where([['cumphong_id',$idcp]])->get();
            $data = [];
            foreach ($items as $item){

                array_push($data,$item);
            }
//            dd($data);
            return \response()->json(
                $data
                ,200);
        }else{
            return response()->json([
                'Fail'
            ]);
        }
    }

    public function storedCumPhong(Request $request){
        $token = $request->header('token');
//        $hotel_id = $request->query('hotel_id');
        $hotel_id = $request['id'];
        $nameCP = $request['name'];
        $user = AdminModel::where([['token',$token],['hotel_id',$hotel_id]]);
//        dd($user);
        if($user != null){
            $item = new cumPhongModel();
            $item->id = 'CP'.Str::random(7);
            $item->name = $nameCP;
            $item->hotel_id = $hotel_id;
            $item->save();
            return response()->json([
                'message'=>'OK'
            ],200);
        }else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }
    }


    public function storedPhong(Request $request){
        $token = $request->header('token');
        $nameP = $request['name'];
        $idCP = $request['cumphong_id'];
        $hotel_id = $request['id'];
        $check = PhongModel::where([['name', $nameP], ['cumphong_id', $idCP]])->get();
        $check1 = cumPhongModel::where([['id',$idCP], ['hotel_id', $hotel_id]])->get();
        $user = AdminModel::where([['token',$token],['hotel_id',$hotel_id]]);

        if(count($check) != 0 || count($check1) == 0){
            return response()->json([
                'message'=>'Fail'
            ]);
        }
        if ( $user !=null) {
            $item = new PhongModel();
            $item->id = 'P'.Str::random(7);
            $item->name = $nameP;
            $item->cumphong_id = $idCP;
            $item->save();
            return response()->json([
                'message'=>'OK'
            ],200);
        }else{
            return response()->json([
                'message'=>'Fail'
            ]);
        }

    }

    public function updatedPhong(Request $request){
        $token = $request->header('token');
        $idP = $request['phong_id'];
        $nameP = $request['name'];

        $phong = PhongModel::find($idP);
        $cumphong = cumPhongModel::find($phong->cumphong_id);

        $user = AdminModel::where([['token',$token],['hotel_id',$cumphong->hotel_id]]);

        $check = PhongModel::where([['name', trim($nameP)], ['cumphong_id', $phong->cumphong_id]])->get();


        if(count($check) > 0 || $user == null ){
            return response()->json([
                'message'=>'Fail'
            ],202);
        }
        if ( $user !=null) {
            $phong->name = trim($nameP);
            $phong->save();
            return response()->json([
                'message'=>'OK'
            ],200);
        }else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }
    }

    public function getBackground(Request $request){
        $token = $request->header('token');

        $hotel_id = $request->query('hotel_id');
        if($hotel_id != null){
            $item = BackgroundModel::find($hotel_id);

            if($item == null)return response()->json(
                 $item
            ,200);
//            $data = array();
//            $data['id'] = $item->id;
//            $data['link']= json_decode($item->link);
            $item->link = json_decode($item->link);

            return \response()->json(
                $item
                ,200);

        }
        else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }


    }

    public function updatedCumPhong(Request $request){
        $token = $request->header('token');
        $idCp = $request['cumphong_id'];
        $nameCP = $request['name'];

        $cumphong = cumPhongModel::find($idCp);
        $user = AdminModel::where([['access_token',$token]])->first();

        $check = cumPhongModel::where([['check',1],['id', $idCp]])->first();


        if($check != null  || $user == null ){
            return response()->json([
                'message'=>'Fail'
            ],202);
        }

        $check1 = cumPhongModel::where([['name',trim($nameCP)],['hotel_id',$user->hotel_id]])->get();
        if(count($check1) == 0){
            $cumphong->name = trim($nameCP);
            $cumphong->save();
            return response()->json([
                'message'=>'OK'
            ],200);
        }else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }

    }

    public function destroyedCumPhong(Request $request){
        $token = $request->header('token');
        $idCp  = $request['cumphong_id'];
        // get user
        $user = AdminModel::where([['access_token',$token]])->first();

        if($user !=null){
            // kiem tra xem user có Cụm phòng đó không
            $kiemtra  = cumPhongModel::where([['id',$idCp],['hotel_id',$user->hotel_id]])->first();
            if($kiemtra == null){
                return response()->json([
                    'message'=>'Fail'
                ],202);

            }else{
                // lay cum phong mac định không thể xóa trong Hotel đó

                $cumphong_macdinh = cumPhongModel::where([['check',1],['hotel_id',$user->hotel_id]])->first();
                // lkiem tra xem pohong dó co la phong mac định không
                $check = cumPhongModel::where([['check',1],['id',$idCp]])->first();

                if($check == null ){

                    $phongs = PhongModel::where([['cumphong_id',$idCp]])->get();
//                    dd($phongs);
                    foreach($phongs as $phong){
                        $phong->cumphong_id = $cumphong_macdinh->id;
                        $phong->save();

                    }
                    $kiemtra->delete();
                    return response()->json([
                        'message'=>'OK'
                    ],200);
                }else{
                    return response()->json([
                        'message'=>'Fail'
                    ],202);
                }
            }

        }else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }

    }

    public function destroyedPhong(Request $request){
        $token = $request->header('token');
        $idP  = $request['phong_id'];

        $user = AdminModel::where([['access_token',$token]])->first();
        if($user !=null){
            //lay ra phong caan delete
            $phong = PhongModel::find($idP);
            // kiem tra phong do co phai chu so huu can Xoas khong
            $kiemtra  = cumPhongModel::where([['id',$phong->cumphong_id],['hotel_id',$user->hotel_id]])->first();
            if($kiemtra == null){
                return response()->json([
                    'message'=>'Fail'
                ],202);

            }else{
                $cumphong_macdinh = cumPhongModel::where([['check',1],['hotel_id',$user->hotel_id]])->first();
                $phong_macdinh = PhongModel::where([['check',1],['cumphong_id',$cumphong_macdinh->id]])->first();

                $check = PhongModel::where([['check',1],['id',$idP]])->first();
                if($check == null ){

                    $notification = NotificationModel::find($idP);
                    if(($notification) != null){
                        $notification->delete();
                    }
                    $boxtvs  = BoxTvModel::where([['phong_id',$idP]])->get();
                    foreach($boxtvs as $boxtv){
                        $boxtv->phong_id = $phong_macdinh->id;
                        $boxtv->save();
                    }
                    $phong->delete();
                    return response()->json([
                        'message'=>'OK'
                    ],200);
                }else{
                    return response()->json([
                        'message'=>'Fail'
                    ],202);
                }
            }
        }else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }
    }

    public function deletePhoto(Request $request){
        $token = $request->header('token');
        $id  = $request['id'];
        $link = $request['link'];
        $user = AdminModel::where([['access_token',$token]])->first();
        if($user !=null){
            if($user->hotel_id == $id){
                $background = BackgroundModel::find($id);
                $images = $background->link;
                $images = json_decode($images);
                $images1 = [];
                foreach($images as $key=>$value){
                    if($link != $value)array_push($images1,$value);
                }

                $images1 = json_encode($images1);
                $background->link = $images1;
                $background->save();
                return response()->json([
                    'message'=>'OK'
                ],200);
            }else{
                return response()->json([
                    'message'=>'Fail'
                ],202);
            }
        }else {
            return response()->json([
                'message'=>'Fail'
            ],202);
        }

    }

    public function addPhoto(Request $request){
        $token = $request->header('token');
        $file = $request['image'];
        $id  = $request['id'];
        $user = AdminModel::where([['access_token',$token]])->first();

        if($user !=null && $request->hasFile('image') && $user->hotel_id == $id && $file !=null  ){
            $imageName  = '/images/background/'.Str::random(3).time().$file->getClientOriginalName();
            $background = BackgroundModel::find($id);
            $link = json_decode($background->link);
            array_push($link,$imageName);

            $file->move('images/background',$imageName);

            $background->link = json_encode($link);
            $background->save();

            return response()->json([
                'message'=>'OK'
            ],200);
        }else {
            return response()->json([
                'message'=>'Fail'
            ],202);
        }

//        if($request->hasFile('images')){
//            foreach($images as $image){
//                if($image != null){
//                    $imageName  = '/images/background/'.Str::random(3).time().$image->getClientOriginalName();
//                    array_push($path,$imageName);
//                    $image->move('images/background',$imageName);
//                }
//
//            }
//        }
    }

    public function getBox(Request $request){
        $token = $request->header('token');
        $idP  = $request->query('phong_id');

        $user = AdminModel::where([['access_token',$token]])->first();
        $idCp = PhongModel::find($idP)->cumphong()->first();

        if($user != null && $user->hotel_id == $idCp->hotel_id){
            $boxs = BoxTvModel::where([['phong_id',$idP]])->get();
            return response()->json(
                $boxs
            ,200);
        }else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }

    }

    public function updatedService(Request $request){
        $token = $request->header('token');
        $service_id = $request['id'];
        $tittle = $request['tittle'];
        $color_code = $request['color_code'];
        $icon_code = $request['icon_code'];

      $user = AdminModel::where([['access_token',$token]])->first();
        $service = ServiceModel::find($service_id);
          $hotel = $service->infomation()->first();
      if($user != null && $user->hotel_id == $hotel->id){
          $service->tittle = $tittle;
          $service->icon = $icon_code;
          $service->color_icon = $color_code;
          $service->save();
          return response()->json([
              'message'=>'OK'
          ],200);
      }else{
          return response()->json([
              'message'=>'Fail'
          ],202);
      }
    }

    public function getPopup(Request $request){
        $token = $request->header('token');

        $hotel_id = $request->query('hotel_id');
        if($hotel_id != null){
            $item = PopUpModel::find($hotel_id);

            if($item == null)return response()->json(
                $item
                ,200);
            $item->link = json_decode($item->link);

            return \response()->json(
                $item
                ,200);

        }
        else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }


    }

    public function deletePhotoPopup(Request $request){
        $token = $request->header('token');
        $id  = $request['id'];
        $link = $request['link'];
        $user = AdminModel::where([['access_token',$token]])->first();
        if($user !=null){
            if($user->hotel_id == $id){
                $popup = PopUpModel::find($id);
                $images = $popup->link;
                $images = json_decode($images);
                $images1 = [];
                foreach($images as $key=>$value){
                    if($link != $value)array_push($images1,$value);
                }

                $images1 = json_encode($images1);
                $popup->link = $images1;
                $popup->save();
                return response()->json([
                    'message'=>'OK'
                ],200);
            }else{
                return response()->json([
                    'message'=>'Fail'
                ],202);
            }
        }else {
            return response()->json([
                'message'=>'Fail'
            ],202);
        }

    }


    public function addPhotoPopup(Request $request){
        $token = $request->header('token');
        $file = $request['image'];
        $id  = $request['id'];
        $user = AdminModel::where([['access_token',$token]])->first();

        if($user !=null && $request->hasFile('image') && $user->hotel_id == $id && $file !=null  ){
            $imageName  = '/images/popup/'.Str::random(3).time().$file->getClientOriginalName();
            $popup = PopUpModel::find($id);
            $link = json_decode($popup->link);
            array_push($link,$imageName);

            $file->move('images/popup',$imageName);

            $popup->link = json_encode($link);
            $popup->save();

            return response()->json([
                'message'=>'OK'
            ],200);
        }else {
            return response()->json([
                'message'=>'Fail'
            ],202);
        }

    }

    public function editPopup(Request $request){
        $token = $request->header('token');
        $id  = $request['hotel_id'];
        $time =  $request['duration'];
        $user = AdminModel::where([['access_token',$token],['id',$id]])->first();
        if($user != null ){
            $popup = PopUpModel::find($id);
            $popup->duration = $time;
            $popup->save();
            return response()->json([
                'message'=>'OK'
            ],200);
        }else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }
    }

}
