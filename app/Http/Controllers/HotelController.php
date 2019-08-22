<?php

namespace App\Http\Controllers;

use App\Model\AdminModel;
use App\Model\BackgroundModel;
use App\Model\BoxTvModel;
use App\Model\cumPhongModel;
use App\Model\InformationModel;
use App\Model\NotificationModel;
use App\Model\PhongModel;
use App\Model\PopUpModel;
use App\Model\ServiceModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    public function resetpw($id){
        $user  = Auth::guard('admin')->user();
        if($user != null && $user->permission == 'admin'){
            $item = AdminModel::where('hotel_id',$id)->first();
            $item->password = bcrypt('123456');
            $item->access_token = Str::random(30).time();
            $item->save();
            return 1;
        }
        return 0;

    }

    public function index(Request $request){
        $search = $request->query('q');
        $data = array();

        if (trim($search) != null){
            $item = InformationModel::where('name','like','%'.trim($search).'%')->paginate(5);
            $item->setPath('/hotel?q='.$search);

        }else{

            $item =InformationModel::paginate(10);
        }
        $data['hotels'] = $item;
//        dd($item->toArray());
        return    view('content.hotel.index',$data);
    }
    public function create(){
        return view('content.hotel.submit');
    }

    public function stored(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'username'=>'required',
            'logo'=>'mimes:jpeg,jpg,png|max:2048'
        ],[
            'name.required'=>'Không để trống input Tên Khách Sạn',
            'username.required'=>' Không để trống input Tài Khoản ',
            'logo.mimes'=>'Chỉ chấp nhận hình ảnh đuôi .jpg, .jpeg, .png',
            'logo.max'=>'kích thước Logo quá lớn',
        ]);
        $hotel_id =  "H00".time();
        $input = $request->all();
        $logo = $request['logo'];

        $item =new  InformationModel();
        $item->id = $hotel_id;
        $item->name =$input['name'];
        $path = '/images/logo/';
        $item->tittle = isset($input['tittle'])? $input['tittle']: '';
        if($request->hasFile('logo')){
            $imageName  = Str::random(3).time().$logo->getClientOriginalName();
            $path = $path.$imageName;
            $logo->move('images/logo',$imageName);
        }
        $item->logo = $request->hasFile('logo') ? $path: '';
        $item->save();

        /* tự động tạo mới User bảng User*/

        $user = new AdminModel();
        $user->username = $input['username'];
        $user->password = bcrypt('123456');
        $user->access_token = Str::random(30).time();
        $user->hotel_id = $hotel_id;
        $user->save();


        /* Tự động tạo  Cụm phòng Mặc định */
        $cumphong_id = 'CP00'. Str::random(10);

        $cumphong = new cumPhongModel();
        $cumphong->id = $cumphong_id;
        $cumphong->name = 'Mặc định';
        $cumphong->hotel_id =$hotel_id;
        $cumphong->check = 1;
        $cumphong->save();

        /* Tự động tạo Phòng Mặc định*/
        $phong_id = 'P00'.Str::random(8);

        $phong  = new PhongModel();
        $phong->id = $phong_id;
        $phong->name = 'Toàn bộ Phòng khách sạn';
        $phong->cumphong_id = $cumphong_id;
        $phong->check = 1;
        $phong->save();
        /* Tự động tạo Id trong Table backgorund*/
        $background = new BackgroundModel();
        $background->id = $hotel_id;
        $background->save();

        /* Tự động tạo Id trong Table PopUp*/
        $popup = new PopUpModel();
        $popup->id = $hotel_id;
        $popup->save();
        /* Tự động tạo trong Table Notification*/
        $notification = new NotificationModel();
        $notification->id = $phong_id;
        $notification->save();

        return redirect('/hotel/create')->with('success','Thêm mới thành công Hotel '. $item->name);
    }

    public function edit($id){
        $data = array();
        $item = InformationModel::find($id);
        $user = AdminModel::where('hotel_id',$item->id)->pluck('username')->first();
        $data['hotel'] = $item;
        $data['username'] = $user;
        return view('content.hotel.edit',$data);
    }
    public function updated(Request $request,$id){
        $this->validate($request,['name'=>'required']);
        $input =$request->all();
        $item = InformationModel::find($id);
        $logo = $request['logo'];
        $item->name = $input['name'];
        $path = '/images/logo/';
        $item->tittle =isset($input['tittle'])? $input['tittle'] : $item->tittle;
        if($request->hasFile('logo')){
            $imageName  = Str::random(3).time().$logo->getClientOriginalName();
            $path = $path.$imageName;
            $logo->move('images/logo',$imageName);
        }
        $item->logo = $request->hasFile('logo') ? $path: '';
        $item->save();
        return redirect('/hotel')->with('success','updated thành công');

    }

    public function destroy($id){
        $user  = Auth::guard('admin')->user();
        if($user != null && $user->permission == 'admin'){
            $userTable = AdminModel::where('hotel_id',$id)->first();
            $infomation = InformationModel::find($id);
            $background  = BackgroundModel::find($id);
            $popup = PopUpModel::find($id);

            $services = ServiceModel::where('hotel_id',$id)->get();
            $cumphongs = cumPhongModel::where('hotel_id',$id)->get();
            // xóa dịch vụ
            foreach($services as $service){
                if($service!=null)$service->delete();
            }
            if($background != null){
                $links = json_decode($background->link);
                if($links !=null){
                    foreach($links as $link){
                        if(file_exists(public_path() .$link)){
                            @unlink((public_path() . $link));
                        }
                    }
                }
                $background->delete();

            }
            if($popup != null){
                $links = json_decode($popup->link);
                if($links !=null){
                    foreach($links as $link){
                        if(file_exists(public_path() .$link)){
                            @unlink((public_path() . $link));
                        }
                    }
                }
                $popup->delete();

            }
            if($userTable != null)$userTable->delete();
            // xoa cum phong lien quan

            foreach($cumphongs as $cp){

                $phongs = PhongModel::where('cumphong_id',$cp->id)->get();
                foreach($phongs as $phong){
                    $notification = NotificationModel::find($phong->id);
                    if($notification !=null) $notification->delete();
                    $boxtvs = BoxTvModel::where('phong_id',$phong->id)->get();
                    foreach($boxtvs as $box){
                        if($box !=null)$box->delete();
                    }
                    if($phong !=null) $phong->delete();
                }
                if($cp !=null)$cp->delete();
            }
            $logo = $infomation->logo;
            if($logo != null){
                @unlink((public_path() . $logo));
            }
            $infomation->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
