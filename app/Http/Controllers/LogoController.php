<?php

namespace App\Http\Controllers;

use App\Model\BackgroundModel;
use App\Model\InformationModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LogoController extends Controller
{
    public function edit($id){
        $logo  =   InformationModel::find($id);
        $user = Auth::guard('admin')->user();
        if($logo != null && $user->hotel_id == $id){
            $data = array();
            $data['logo'] = $logo;
            return view('content.logo.editAdmin',$data);
        }else{
            return redirect('logo/edit/'.$id)->withErrors(['error'=>'Bạn không có quyền truy cập phần này']);
        }

    }

    public function updated($id, Request $request){
        $user = Auth::guard('admin')->user();
        $logo = $request->logo;
        $logo1 = $request->logo1;
        $path = 'images/logo/';
        if($logo == null && $logo1 ==null){
            return redirect('logo/edit/'.$id)->withErrors(['error'=>'Bạn chưa chọn ảnh để Chỉnh sửa']);
        }else if($logo == null && $logo1 != null){

            $item = InformationModel::find($id);
            if($item->logo){
                @unlink( $item->logo);
            }

            $imageName  = Str::random(3).time().$logo1->getClientOriginalName();
            $path = $path.$imageName;
            $logo1->move('images/logo',$imageName);
            $item->logo = $path;
            $item->save();
        }else if($logo !=null && $logo1 ==null){

        }else{
            return redirect('logo/edit/'.$id)->withErrors(['error'=>'ERROR, Không thể upload 2 ảnh logo ']);
        }
        return redirect('logo/edit/'.$id)->with(['sucess'=>'Cật nhật thành công']);
    }
}
