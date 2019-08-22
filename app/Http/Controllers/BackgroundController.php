<?php

namespace App\Http\Controllers;

use App\Model\BackgroundModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BackgroundController extends Controller
{
    /*
     * --------- USER


    /*
     * --------- ADMIN
     * */

    public function IndexAdmin(){
         $items = DB::table('tlhotel_background')
            ->join('tlhotel_information','tlhotel_information.id','=','tlhotel_background.id')
            ->select('tlhotel_background.*','tlhotel_information.name as tenKS'
            )->paginate(7);
        $data = array();
        $data['backgrounds'] = $items;
        return view('content.background.indexAdmin',$data);
    }

//    public function editAdmin1(){
//        $hotels = InformationModel::all();
//        $data = array();
//        $data['hotels']= $hotels;
//        return view('content.background.editAdmin1',$data);
//    }

//    public function createAdmin(){
//        $hotels = InformationModel::all();
//        $data = array();
//        $data['hotels']= $hotels;
//        return view('content.background.submitAdmin',$data);
//    }


//    public function storedAdmin(Request $request){
//        $this->validate($request,[
//                'images.*'=>'mimes:jpeg,jpg,png|max:2048'
//             ],
//            [
//                'images.mimes'=>'Chỉ chấp nhận hình ảnh đuôi .jpg, .jpeg, .png',
//            ]);
//        $hotel_id = $request['hotel_id'];
//        $path = [];
//        $images = $request['images'];
//
//        if($request->hasFile('images')){
//            foreach($images as $image){
//               $imageName  = Str::random(3).time().$image->getClientOriginalName();
//               array_push($path,$imageName);
//               $image->move('images/background',$imageName);
//            }
//        }
////        dd(json_encode($path));
//        $item = new BackgroundModel();
//        $item->id = $hotel_id;
//        $item->link = json_encode($path);
//        $item->save();
//
//
//    }


    public function editAdmin($id){

        $background  =   DB::table('tlhotel_background')
            ->join('tlhotel_information','tlhotel_information.id','=','tlhotel_background.id')
            ->where('tlhotel_information.id',$id)
            ->select('tlhotel_background.*','tlhotel_information.name as tenKS')
            ->first();
        $user = Auth::guard('admin')->user();
        if($background != null  && $user->hotel_id == $id ||  $background != null  && $user->permission == 'admin'){
            $data = array();
            $data['background'] = $background;
//            dd($background);
            return view('content.background.editAdmin',$data);
        }else{
            if($user->permission == 'admin'){
                return redirect('background')->withErrors(['error'=>'Không có Khách sạn mong đợi']);
            }else{
                return redirect('background/edit/'.$id)->withErrors(['error'=>'Bạn không có quyền truy cập phần này']);
            }
        }

    }

    public function updatedAdmin($id, Request $request){
        $user = Auth::guard('admin')->user();

        $images1 = $request->images1;
        $images = $request->images;

        $background = BackgroundModel::find($id);
        // lay ra tat ca anh trong Db
        $link = json_decode($background->link);
        $path = [];
//       Upload   ẢNh into Stored
        if($request->hasFile('images')){
            foreach($images as $image){
                if($image != null){
                    $imageName  = '/images/background/'.Str::random(3).time().$image->getClientOriginalName();
                    array_push($path,$imageName);
                    $image->move('images/background',$imageName);
                }

            }
        }
//        dd($path);
        if($images1 == null){
            $deletes = $link;
        }else{
            $deletes = array_diff($link,$images1);
            $path = array_merge($path,$images1);
        }

        // Xóa ảnh
        if($deletes != null){

            foreach($deletes as $delete){
                if(file_exists(public_path() .$delete)){
                    @unlink((public_path() . $delete));
                }
            }
        };
        $background->link = json_encode($path);
        $background->save();
        if($user->permission === 'admin'){
            return redirect('background')->with(['success'=>'Updated Thành cônng']);
        }else if($user->permission === 'user'){
            return redirect('background/edit/'.$id)->with(['success'=>'Updated Thành cônng']);
        }
    }
}
