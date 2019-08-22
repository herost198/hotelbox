<?php

namespace App\Http\Controllers;

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

class NotificationController extends Controller
{
    /*
     * ------------ USER
     * */
    public function index($id)
    {
        $items = cumPhongModel::where('hotel_id', $id)->get();
        $data = array();

        $notifications = array();
        foreach ($items as $item) {
            $phongs = PhongModel::where('cumphong_id', $item->id)->get();

            foreach ($phongs as $phong) {
                $notification = NotificationModel::find($phong->id);
                if($notification != null){
                    array_push($notifications, $notification);
                }

            }
        }
        $data['notifications'] = $notifications;
//        dd($notifications);
        return view('content.Notification.index', $data);
    }


    public function edit($id)
    {
        $data = array();
        $cumphongs = cumPhongModel::where([['hotel_id', $id]])->get();
        $data['cumphongs'] = $cumphongs;
        return view('content.Notification.edit', $data);
    }


    public  function editData($phongs,$request){
        $logo = $request->link;
        $path = 'images/link/';
        if($request->hasFile('link')){
            $imageName  = Str::random(3).time().$logo->getClientOriginalName();
            $path = $path.$imageName;
            $logo->move('images/link',$imageName);
        }

        foreach($phongs as $phong){

            $item =  NotificationModel::find($phong->id);
            if($item !=null){
                $item->tittle = $request->tittle;
                $item->link = $request->hasFile('link') ? $path: '';
                $item->save();
            }

        }
    }
    public  function editData1($phongs,$request){


        foreach($phongs as $phong){

            $item =  NotificationModel::find($phong->id);
            if($item !=null){
                $item->tittle = $request->tittle;
                $item->save();
            }

        }
    }


    public function updated($id, Request $request)
    {
        $this->validate($request, [
            'tittle' => 'required',
        ], [
            'tittle.required' => 'Bạn phải nhập Tittle',
        ]);
        $user = Auth::guard('admin')->user();
        if ($user->hotel_id === $id || $user->permission === 'admin') {

            if($request->cumphong_id == '0'){
                // Thêm tất cả thông báo vào Khách sạn
                $phongs = DB::table('tlhotel_information')
                    ->join('tlhotel_cumphong','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                    ->join('tlhotel_phong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                    ->where('tlhotel_information.id', $id)
                    ->select('tlhotel_phong.*')->get();
                $this->editData1($phongs,$request);
                return redirect('/notification/' . $id.'/edit')->with('success','Thêm Thông báo thành công');
            }else if($request->cumphong_id != '0' && $request->phong_id == '0'){
                // Thêm thông báo vào tất cả các Phòng thuộc 1 cụm phòng trong Khách sạn
                $phongs = DB::table('tlhotel_information')
                    ->join('tlhotel_cumphong','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                    ->join('tlhotel_phong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                    ->where([['tlhotel_information.id', $id],['tlhotel_cumphong.id',$request->cumphong_id]])
                    ->select('tlhotel_phong.*')->get();
                $this->editData1($phongs,$request);
                return redirect('/notification/' . $id.'/edit')->with('success','Thêm Thông báo thành công');
            }else {
                // Thêm Thông báo Một  Phòng thuộc 1 cụm phòng trong Khách sạn
                $phongs = DB::table('tlhotel_information')
                    ->join('tlhotel_cumphong','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                    ->join('tlhotel_phong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                    ->where([['tlhotel_information.id', $id],['tlhotel_cumphong.id',$request->cumphong_id],['tlhotel_phong.id',$request->phong_id]])
                    ->select('tlhotel_phong.*')->get();
                $this->editData1($phongs,$request);
                return redirect('/notification/' . $id.'/edit')->with('success','Thêm Thông báo thành công');
            }

        } else {
            return redirect()->back()->withInput(Input::all())
                ->withErrors(['error' => 'Thêm mới phòng không thành công :(']);
        }
    }




    /*
     * ------------ Admin
     * */
    public function IndexAdmin(Request $request)
    {

        $hotel_id = $request->input('hotel_id');

        $data = array();
        $hotels = InformationModel::all();
        $data['hotels'] = $hotels;
        if($hotel_id == null){
            $items = DB::table('tlhotel_information')
                ->join('tlhotel_cumphong','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                ->join('tlhotel_phong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                ->join('tlhotel_notification','tlhotel_notification.id','=','tlhotel_phong.id')
                ->select('tlhotel_notification.id AS notification_id',
                    'tlhotel_notification.tittle',
                    'tlhotel_phong.name as tenPhong','tlhotel_cumphong.name as tenCumPhong','tlhotel_information.name AS TenKS'
                )->paginate(7);
//            dd($items);
        }else{
            $items = DB::table('tlhotel_information')
                ->join('tlhotel_cumphong','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                ->join('tlhotel_phong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                ->join('tlhotel_notification','tlhotel_notification.id','=','tlhotel_phong.id')
                ->where('tlhotel_information.id',$hotel_id)
                ->select('tlhotel_notification.id AS notification_id',
                    'tlhotel_notification.tittle',
                    'tlhotel_phong.name as tenPhong','tlhotel_cumphong.name as tenCumPhong','tlhotel_information.name AS TenKS'
                )->paginate(7);
            $items->setPath('/notification?hotel_id='.$hotel_id);
        }


        $data['notifications'] = $items;
        return view('content.Notification.indexAdmin', $data);
    }

    public function editAdmin(){
        $data = array();
        $hotels  = InformationModel::all();
//        dd($hotels);
//        $cumphongs = cumPhongModel::where([['hotel_id', $id]])->get();
        $data['hotels'] = $hotels;
        return view('content.Notification.editAdmin', $data);
    }

    public function updatedAdmin(Request $request){
        $this->validate($request, [
            'tittle' => 'required',
        ], [
            'tittle.required' => 'Bạn phải nhập Tittle',
        ]);
        $user = Auth::guard('admin')->user();
        if ( $user->permission === 'admin') {

            if($request->cumphong_id == '0'){
                // Thêm tất cả thông báo vào Khách sạn
                $phongs = DB::table('tlhotel_information')
                    ->join('tlhotel_cumphong','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                    ->join('tlhotel_phong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                    ->where('tlhotel_information.id', $request->hotel_id)
                    ->select('tlhotel_phong.*')->get();
//                dd($phongs);
                $this->editData1($phongs,$request);
                return redirect('notification/edit')->with('success','Thêm Thông báo thành công');
            }else if($request->cumphong_id != '0' && $request->phong_id == '0'){
                // Thêm thông báo vào tất cả các Phòng thuộc 1 cụm phòng trong Khách sạn
                $phongs = DB::table('tlhotel_information')
                    ->join('tlhotel_cumphong','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                    ->join('tlhotel_phong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                    ->where([['tlhotel_information.id', $request->hotel_id],['tlhotel_cumphong.id',$request->cumphong_id]])
                    ->select('tlhotel_phong.*')->get();
                $this->editData1($phongs,$request);
                return redirect('notification/edit')->with('success','Thêm Thông báo thành công');
            }else {
                // Thêm Thông báo Một  Phòng thuộc 1 cụm phòng trong Khách sạn
                $phongs = DB::table('tlhotel_information')
                    ->join('tlhotel_cumphong','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                    ->join('tlhotel_phong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                    ->where([['tlhotel_information.id', $request->hotel_id ],['tlhotel_cumphong.id',$request->cumphong_id],['tlhotel_phong.id',$request->phong_id]])
                    ->select('tlhotel_phong.*')->get();
                $this->editData1($phongs,$request);
                return redirect('notification/edit')->with('success','Thêm Thông báo thành công');
            }

        } else {
            return redirect()->back()->withInput(Input::all())
                ->withErrors(['error' => 'Thêm mới phòng không thành công :(']);
        }
    }
}
