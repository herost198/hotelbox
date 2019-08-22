<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    //
    /*
     * Method này trả về View  đăng nhập cho admin
     * */
    public function login()
    {
        return view('auth.login');
    }


    /*
     *  method này trả về View đăng nhập cho admin
     * lấy information from form have Method is Post
     * */
    public function loginAdmin(Request $request)
    {
        $this->validate($request, array(
            'username' => 'required',
            'password' => 'required|min:6'
        ),[
            'username.required'=>'Bạn phải nhập tài khoản',
            'password.required'=>'Bạn phải nhập mật khẩu',
        ]);

        // Login
        if (Auth::guard('admin')->attempt(
            ['username' => $request->username , 'password' => $request->password]
        )) {

            return redirect()->route('home');
        }
        // nếu đăng nhập thất bại thì quay trở về Form Login
        // với giá trị  của 2 ô Input  cũ là email và remember
        return redirect('/login')->with('error1','Tài khoản hoặc Mật khẩu không đúng')
                                ->withInput(Input::all());
    }

    /*
     * Method này dùng để đăng xuất
     * */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('auth.login');
    }
}
