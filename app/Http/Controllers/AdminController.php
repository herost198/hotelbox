<?php

namespace App\Http\Controllers;

use App\Model\AdminModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function user(){

        $user = Auth::guard('admin')->user();

    }
    public function create(){
        $user = Auth::guard('admin')->user();
        return view('content.users.submit');

    }

    public function changePassword($id){
        $user = Auth::guard('admin')->user();

        if($user->hotel_id === $id){
            return view('content.users.submitChangePassword');
        }else{
            return redirect('/')->with('error','Bạn không có quyền truy cập phần này');
        }
    }

    public function submitChangePassword($id,Request $request){
        $user = Auth::guard('admin')->user();
        if($user->hotel_id === $id){
            $this->validate($request,[
                'password' => 'required',
                'newpassword' => 'required|min:6',
                'password_confirm' => 'required|same:newpassword',
            ],[
                'password.required'=>'Bạn chưa nhập mật khẩu cũ',
                'passwnewpasswordord.required'=>'Bạn chưa nhập mật khẩu mới',
                'password_confirm.required'=>'Bạn chưa nhập mật khẩu mới',
                'password_confirm.same'=>'Bạn nhập  Xác nhận mật khẩu mới không trùng khớp',
                'newpassword.min'=>'Mật khẩu có độ dài lớn hơn 6'
            ]);
            $item = AdminModel::where('hotel_id',$id)->first();
            $item->password = bcrypt($request->newpassword);
            $item->access_token = Str::random(30).time();
            $item->save();
            return redirect('/changePassword/'.$id)->with('success','Thay đổi password thành công');
        }else{
            return redirect('/')->with('error','Bạn không có quyền truy cập phần này');
        }
    }

}
