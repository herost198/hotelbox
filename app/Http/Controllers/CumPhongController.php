<?php

namespace App\Http\Controllers;

use App\Model\BoxTvModel;
use App\Model\cumPhongModel;
use App\Model\InformationModel;
use App\Model\NotificationModel;
use App\Model\PhongModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;

class CumPhongController extends Controller
{
    public function index($id){
        $item = DB::table('tlhotel_cumphong')
            ->join('tlhotel_information','tlhotel_information.id','=','tlhotel_cumphong.hotel_id')
            ->leftJoin('tlhotel_phong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
            ->where('tlhotel_information.id',$id)
            ->select('tlhotel_cumphong.*',DB::raw('count(tlhotel_phong.id) as total'))
            ->groupBy('tlhotel_cumphong.id')
            ->paginate(10);
        $data = array();
        $data['cumphongs']  = $item;
        return view('content.CumPhong.index',$data);
    }
    public function create($id){
        return view('content.CumPhong.submit');
    }

    public function stored($id, Request $request){
        $this->validate($request,[
            'name'=>'required'
        ],[
            'name.required'=>'Bạn phải nhập tên Cụm Phòng'
        ]);
        $user = Auth::guard('admin')->user();
        $hotel = InformationModel::find($id);
        $cumphongs = $hotel->cumphong()->get();
        $check = 0;
        foreach($cumphongs as $cumphong){
            if(trim($cumphong->name) === trim($request->name)){
                $check = 1;
                break;
            }
        }
        if($check == 1){
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Trùng Tên Cụm Phòng đã có sẵn']);
        }
        if($user->hotel_id === $id ){
            $name = $request->name;
            $item = new cumPhongModel();
            $item->id = 'CP'.Str::random(7);
            $item->name = $name;
            $item->hotel_id = $id;
            $item->save();
            return redirect('/cumphong/'.$id.'/create')->with('success','Thêm mới Cụm Phòng thành công');
        }else{
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Thêm mới cụm phòng không thành công :(']);
        }


    }
    public function edit($id, $idCp){
        $user = Auth::guard('admin')->user();
        $cumphong  = cumPhongModel::where([['id',$idCp],['hotel_id',$id]])->first();
        if($user->hotel_id === $id && $cumphong->check == 0  ){

            $phongs = PhongModel::where('cumphong_id',$cumphong->id)->get();

            $data = array();
            $data['cumphong'] = $cumphong;
            $data['phongs'] = $phongs;

            $cumphongMD = cumPhongModel::where([['hotel_id',$id],['check',1]])->first();
//            dd($cumphongMD)/
            $data['cumphongMD'] = $cumphongMD->id;
            return view('content.CumPhong.edit',$data);
        }else{
            return redirect('cumphong/'.$id)->withErrors(['error'=>'Bạn không có quyền truy cập vào phần này']);
        }
    }

    public function updated($id, $idCp, Request $request){
        $user = Auth::guard('admin')->user();
        $cumphong  = cumPhongModel::where([['id',$idCp],['hotel_id',$id]])->first();
//        $hotel = InformationModel::find($id);
//        $cumphongs = $hotel->cumphong()->get();
        $cumphongs = cumPhongModel::where([['hotel_id',$id]])->get();
        $check = 0;
        foreach($cumphongs as $cumphong1){
            if(trim($cumphong1->name) === trim($request->name) && $cumphong1->id != $cumphong->id){
                $check = 1;
                break;
            }
        }
        if($check == 1){
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Trùng Tên Cụm Phòng đã có sẵn']);
        }

        $phong = $request->phong;
        $phong1 = $request->phong1;

        // check xem va XÓa các phòng đã có trong Cụm phòng trước đó

        $cumphongMD = cumPhongModel::where([['hotel_id',$id],['check',1]])->first();

        $phongMD = PhongModel::where([['cumphong_id',$cumphongMD->id],['check',1]])->first();
        // lay tat ca danh sach phong
        $ps = PhongModel::where([['cumphong_id',$idCp]])->get();

        // nếu Xóa tất cả phòng

        if($phong1 != null){
            $phong1 = array_unique($phong1);
            foreach($phong1 as $p1){
                $item = PhongModel::where([['name',$p1]])->first();
                if($item ==null){
                    return redirect('cumphong/'.$id.'/edit/'.$idCp)->withErrors(['error'=>'Một trong những phòng thêm vào Cụm Phòng không tồn tại']);
                }
//                $item->cumphong_id = $idCp;
//                $item->save();
            }
        }

        if($user->hotel_id === $id && $cumphong->check == 0  ){

            if($phong == null){
                // kiêm tra xem List phòng
                if($ps != null){

                    foreach($ps as $p ){

                        $boxtvs  = BoxTvModel::where([['phong_id',$p->id]])->get();
                        foreach($boxtvs as $boxtv){
                            $boxtv->phong_id = $phongMD->id;
                            $boxtv->save();

                        }
                        $p->cumphong_id = $cumphongMD->id;
                        $p->save();
//                   dd($p->name);
                    }

                }

            }else {
                //  lay list ID cua Phong
                $idP =  PhongModel::where([['cumphong_id',$idCp]])->pluck('id')->toArray();

                if($ps != null){
                    // so sanh với List Phòng của Cụm Phòng đó
                    $different_phong = array_diff($idP, $phong);
                    if($different_phong != null){
                        foreach($different_phong as $p ){

                            $boxtvs  = BoxTvModel::where([['phong_id',$p]])->get();
                            foreach($boxtvs as $boxtv){
                                $boxtv->phong_id = $phongMD->id;
                                $boxtv->save();
                            }
                            $item = PhongModel::find($p);

                            $item->cumphong_id = $cumphongMD->id;
                            $item->save();
                        }
                    }

                }
            }
            if($phong1 != null){
                foreach($phong1 as $p1){
                    $item = PhongModel::where([['name',$p1]])->first();

                    $item->cumphong_id = $idCp;
                    $item->save();
                }
            }

            $item = cumPhongModel::find($idCp);
            $item->name = $request->name;
            $item->save();
            return redirect('/cumphong/'.$id)->with('success','Updated thành công');
        }else{
            return redirect('cumphong/'.$id)->withErrors(['error'=>'Bạn không có quyền truy cập vào phần này']);
        }
    }

    public function destroy($id, $idCp){
        $phongs = PhongModel::where([['cumphong_id',$idCp]])->get();
        // get cumphong_id have name = 'Mặc định' of CumPhong
        $cumphong = cumPhongModel::where([['hotel_id',$id],['check',1]])->first();
//        dd($cumphong);
        foreach($phongs as $phong){
            $phong->cumphong_id = $cumphong->id;
            $phong->save();
//            dd($phong->name);
        }
        $item = cumPhongModel::where([['id',$idCp],['hotel_id',$id]])->first();
        $item->delete();
        return redirect('cumphong/'.$id)->with('success','Deleted thành công');
    }

    /*
     * ------- Admin
     * */

    public function IndexAdmin(Request $request){

        $hotel_id = $request->query('hotel_id');
        $data = array();

        $hotels = InformationModel::all();
        $data['hotels'] = $hotels;
        if($hotel_id == null){
            $items = cumPhongModel::paginate(10);
            $data['cumphongs'] = $items;
        }else{
            $items = cumPhongModel::where('hotel_id',$hotel_id)->paginate(7);
            $items->setPath('/cumphong?hotel_id='.$hotel_id);
            $data['cumphongs'] = $items;
        }
        return view('content.CumPhong.indexAdmin',$data);
    }


    public function  createAdmin(){
        $hotels = InformationModel::all();
        $data = array();
        $data['hotels'] = $hotels;
        return view('content.CumPhong.submitAdmin',$data);
    }

    public function storedAdmin(Request $request){
        $this->validate($request,[
            'hotel_id'=>'required',
            'name'=>'required',
        ],[
            'hotel_id.required' => 'Bạn phải chọn Khách sạn',
            'name.required' => 'Bạn phải nhập tên Cụm Phòng',
        ]);
        $user = Auth::guard('admin')->user();
        $hotel = InformationModel::find($request->hotel_id);
        $cumphongs = $hotel->cumphong()->get();
        $check = 0;
        foreach($cumphongs as $cumphong){
            if(trim($cumphong->name) === trim($request->name)){
                $check = 1;
                break;
            }
        }
        if($check == 1){
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Trùng Tên Cụm Phòng đã có sẵn']);
        }
        if($user->permission == 'admin' && $hotel != null){
            $name = $request->name;
            $item = new cumPhongModel();
            $item->id = 'CP'.Str::random(7);
            $item->name = $name;
            $item->hotel_id = $request->hotel_id;
            $item->save();
            return redirect('/cumphong/create')->with('success','Thêm mới Cụm Phòng thành công');
        }else{
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Thêm mới cụm phòng không thành công :(']);
        }
    }

    public function editAdmin($id){
        $user = Auth::guard('admin')->user();
        $cumphong  = cumPhongModel::where([['id',$id]])->first();
        $hotel = $cumphong->hotelInformation()->first();

        if( $user->permission === 'admin' && $cumphong->check == 0 ){

            $data = array();
            $data['cumphong'] = $cumphong;
            $data['hotel']  = $hotel;
            return view('content.CumPhong.editAdmin',$data);
        }else{
            return redirect('cumphong/'.$id)->withErrors(['error'=>'Bạn không có quyền truy cập vào phần này']);
        }
    }

    public function updatedAdmin($id,Request $request){
        $user = Auth::guard('admin')->user();
        $cumphong1  = cumPhongModel::find($id);
        $hotel = $cumphong1->hotelInformation()->first();
        $cumphongs = $hotel->cumphong()->get();
        $check = 0;
        foreach($cumphongs as $cumphong){
            if(trim($cumphong->name) === trim($request->name) && $cumphong1->id != $cumphong->id){
                $check = 1;
                break;
            }
        }

        if($check == 1){
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Trùng Tên Cụm Phòng đã có sẵn']);
        }
        if($user->permission === 'admin' && $cumphong1->check == 0  ){
            $item = cumPhongModel::find($id);
            $item->name = $request->name;
            $item->save();
            return redirect('/cumphong')->with('success','Updated thành công');
        }else{
            return redirect('cumphong')->withErrors(['error'=>'Bạn không có quyền truy cập vào phần này']);
        }
    }

    public function destroyAdmin($id){
        $phongs = PhongModel::where([['cumphong_id',$id]])->get();
        $cumphong = cumPhongModel::where([['check',1]])->first();
        foreach($phongs as $phong){
            $phong->cumphong_id = $cumphong->id;
            $phong->save();
        }
        $item = cumPhongModel::find($id);
        $item->delete();
        return redirect('cumphong/')->with('success','Deleted thành công');
    }
}
