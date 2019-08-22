<?php

namespace App\Http\Controllers\API;

use App\Model\AdminModel;
use App\Model\BackgroundModel;
use App\Model\BoxTvModel;
use App\Model\cumPhongModel;
use App\Model\InformationModel;
use App\Model\NotificationModel;
use App\Model\PhongModel;
use App\Model\ServiceModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mockery\Generator\Method;

class UserController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('post')){
            $this->validate($request,[
                'username'=>'required',
                'password'=>'required'
            ]);
//            dd($request->header('Cookie'));
            $username = $request['username'];
            $password = $request['password'];
            if(Auth::guard('admin')->attempt(['username'=>$username,'password'=>$password])){
                $user =Auth::guard('admin')->user();
                if($user->permission == 'user'){
                    $info = $user->hotelInformation()->get();

//                ->set('token',$user['access_token']);
                    return response()->json([
                        'access_token'=>$user['access_token'],
                        'hotel_id'=>$user['hotel_id'],
                        'name'=>$info[0]['name'],
                        'logo'=>$info[0]['logo'],
                        'tittle'=>$info[0]['tittle'],
                        'type'=>$info[0]['type'],
                    ],200)
                        ->header('token',$user['access_token']);
                }else{
                    return response()->json([
                        'message'=>'Fail'
                    ],202);
                }

            }else{
                return response()->json([
                    'message'=>'Fail'
                ],202);
            }
        }else{
            return response()->json(['message'=>'Fail'],202);
        }

    }

//    public function getBackground(Request $request){
//
//        $id  = $request->query('id');
//
//        if($id != null){
//            $token = $request->header('token');
//            $user = AdminModel::where([['access_token',$token],['hotel_id',$id]])->first();
////                dd($user->hotelInfomation()->get()[0]['type']);
//            if($user == null){
//                return response()->json([
//                    'message'=>'bạn không được phép truy cập dữ liệu này '
//                ],202);
//            }else{
//                $type = $user->hotelInfomation()->get()[0]['type'];
//            }
//            $items =  BackgroundModel::where('hotel_id' , $id)->pluck('link')->all();
//            return \response()->json([
//                    'link'=>$items,
//                    'type'=>$type,
//                    'message'=>"OK Google"
//                ]
//                ,200);
//        }
//        else{
//            return response()->json([
//                'message'=>'Rất tiêc Thông tin này không tồn tại!!'
//            ],202);
//        }
//    }
    public function changePassword(Request $request){


        $password = $request['password'];
        $newpassword = $request['newpassword'];
        $token = $request->header('token');
        $username = $request['username'];
        if(strlen($newpassword) <6){
            return response()->json([
                'message'=>'Fail'
            ],202);
        }
        if( Auth::guard('admin')->attempt(['username'=>$username,'password'=>$password,'access_token'=>$token]) && $newpassword !=null ){
            $user =Auth::guard('admin')->user();
            $user->access_token = Str::random(30).time();
            $user->password = bcrypt($newpassword);
            $user->save();
            unset($user['password']);
            unset($user['remember_token']);
            unset($user['permission']);
            return response()->json([
                'user'=>$user
            ],200);
        }else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }
    }

    public function getService(Request $request){
        $id  = $request->query('id');
        if($id != null){
            $token = $request->header('token');
            $user = AdminModel::where([['access_token',$token],['hotel_id',$id]])->first();
            if($user == null){
                return response()->json([
                    'message'=>'Fail'
                ],202);
            }
            $items =  ServiceModel::where('hotel_id' , $id)->get();
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

    public function destroyService(Request $request){
        $token = $request->header('token');
        $idS  = $request->query('service_id');

        $user = AdminModel::where([['access_token',$token]])->first();

        if($user !=null){
            $kiemtra  = ServiceModel::where([['id',$idS],['hotel_id',$user->hotel_id]])->first();
            if($kiemtra == null){
                return response()->json([
                    'message'=>'Fail'
                ],202);

            }else{
                $kiemtra->delete();
                return response()->json([
                    'message'=>'OK'
                ],200);

            }

        }else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }
    }

    public function changeAvatar(Request $request){
        $token = $request->header('token');
        $id  = $request['id'];
        $logo = $request['image'];
        $path = 'images/logo/';
        $user = AdminModel::where([['access_token',$token],['hotel_id',$id]])->first();
        if($user !=null && $logo !=null){
            $item = InformationModel::find($id);
            if($item->logo){
                @unlink( $item->logo);
            }
            $imageName  = Str::random(3).time().$logo->getClientOriginalName();
            $path = $path.$imageName;
            $logo->move('images/logo',$imageName);
            $item->logo = $path;
            $item->save();
            return response()->json([
                'message'=>'ok'
            ],200);
        }else{
            return response()->json([
                'message'=>'Fail'
            ],202);
        }


    }
}
