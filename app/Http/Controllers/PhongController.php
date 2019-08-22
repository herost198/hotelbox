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

class PhongController extends Controller
{
    /*
    * --------- USER
    * */
    public function index($id, Request $request)
    {
        $user = Auth::guard('admin')->user();
        if($user->hotel_id != $id){
            return redirect('phong/'.$user->hotel_id)->withErrors(['error'=>'Bạn không có quyền truy cập vào phần này']);
        }
        $phong = $request->query('q');
        $phong  = trim($phong);

        $cumphong_id = $request->query('cumphong_id');
        $cumphong_id = trim($cumphong_id);

        $cumphongs = cumPhongModel::where([['hotel_id',$id]])->get();
        $data = array();

        if($phong !=null && $cumphong_id == null){
            $rooms = DB::table('tlhotel_phong')
                ->leftJoin('tlhotel_boxtv','tlhotel_boxtv.phong_id','=','tlhotel_phong.id')
                ->join('tlhotel_cumphong','tlhotel_cumphong.id','=','tlhotel_phong.cumphong_id')
                ->select('tlhotel_phong.*','tlhotel_cumphong.name as TenCPhong',DB::raw('count(tlhotel_boxtv.id) as SoLuong'),'tlhotel_cumphong.hotel_id as TenKS')
                ->where('tlhotel_cumphong.hotel_id',$id)
                ->where('tlhotel_phong.name','like','%'.$phong.'%')
                ->groupBy('tlhotel_phong.id')
                ->paginate(10);
            $rooms->setPath('/phong/'.$id.'?q='.$phong);
            $data['q'] = $phong;

        }else if($phong ==null && $cumphong_id != null){
            $rooms = DB::table('tlhotel_phong')
                ->leftJoin('tlhotel_boxtv','tlhotel_boxtv.phong_id','=','tlhotel_phong.id')
                ->join('tlhotel_cumphong','tlhotel_cumphong.id','=','tlhotel_phong.cumphong_id')
                ->select('tlhotel_phong.*','tlhotel_cumphong.name as TenCPhong',DB::raw('count(tlhotel_boxtv.id) as SoLuong'),'tlhotel_cumphong.hotel_id as TenKS')
                ->where('tlhotel_cumphong.hotel_id',$id)
                ->where('tlhotel_cumphong.id','=',$cumphong_id)
                ->groupBy('tlhotel_phong.id')
                ->paginate(10);
            $rooms->setPath('/phong/'.$id.'?cumphong_id='.$cumphong_id);
            $data['cumphong_id'] = $cumphong_id;
        }else if($phong !=null && $cumphong_id !=null){
            $rooms = DB::table('tlhotel_phong')
                ->leftJoin('tlhotel_boxtv','tlhotel_boxtv.phong_id','=','tlhotel_phong.id')
                ->join('tlhotel_cumphong','tlhotel_cumphong.id','=','tlhotel_phong.cumphong_id')
                ->select('tlhotel_phong.*','tlhotel_cumphong.name as TenCPhong',DB::raw('count(tlhotel_boxtv.id) as SoLuong'),'tlhotel_cumphong.hotel_id as TenKS')
                ->where('tlhotel_cumphong.hotel_id',$id)
                ->where('tlhotel_phong.name','like','%'.$phong.'%')
                ->where('tlhotel_cumphong.id','=',$cumphong_id)
                ->groupBy('tlhotel_phong.id')
                ->paginate(10);
            $rooms->setPath('/phong/'.$id.'?cumphong_id='.$cumphong_id.'&q='.$phong);
            $data['cumphong_id'] = $cumphong_id;
            $data['q'] = $phong;
        }
        else{
            $rooms = DB::table('tlhotel_phong')
                ->leftJoin('tlhotel_boxtv','tlhotel_boxtv.phong_id','=','tlhotel_phong.id')
                ->join('tlhotel_cumphong','tlhotel_cumphong.id','=','tlhotel_phong.cumphong_id')
                ->select('tlhotel_phong.*','tlhotel_cumphong.name as TenCPhong',DB::raw('count(tlhotel_boxtv.id) as SoLuong'),'tlhotel_cumphong.hotel_id as TenKS')
                ->where('tlhotel_cumphong.hotel_id',$id)
                ->groupBy('tlhotel_phong.id')
                ->paginate(10);
        }

        $data['rooms'] = $rooms;
        $data['cumphongs'] = $cumphongs;

        return view('content.phong.index', $data);
    }

    public function create($id)
    {
        $user = Auth::guard('admin')->user();
        if($user->hotel_id != $id){
            return redirect('phong/'.$user->hotel_id)->withErrors(['error'=>'Bạn không có quyền truy cập vào phần này']);
        }
        $data = array();
        $cumphongs = cumPhongModel::where([['hotel_id', $id]])->get();
        $data['cumphongs'] = $cumphongs;

        return view('content.phong.submit', $data);
    }

    public function stored($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ], [
            'name.required' => 'Bạn phải nhập tên Phòng'
        ]);
        $user = Auth::guard('admin')->user();
        $check = PhongModel::where([['name', $request->name], ['cumphong_id', $request->cumphong_id]])->get();
        $check1 = cumPhongModel::where([['id', $request->cumphong_id], ['hotel_id', $id]])->get();

        if (count($check) != 0 || count($check1) == 0) {
            return redirect()->back()->withInput(Input::all())
                ->withErrors(['error' => 'room is exists ']);
        }
        if ($user->hotel_id === $id ) {
            $name = trim($request->name);
            $cumphong_id = $request->cumphong_id;
            $item = new PhongModel();
            $phong_id = 'P' . Str::random(7);
            $item->id = $phong_id;
            $item->name = $name;
            $item->cumphong_id = $cumphong_id;
            $item->save();

            $notification = new NotificationModel();
            $notification->id = $phong_id;
            $notification->save();
            return redirect('/phong/' . $id.'/create')->with('success',"Thêm mới phòng Thành công");
        } else {
            return redirect()->back()->withInput(Input::all())
                ->withErrors(['error' => 'Thêm mới phòng không thành công :(']);
        }
    }


    public function edit($id, $room)
    {
        $data = array();
        $user = Auth::guard('admin')->user();
        if ($user->hotel_id == $id || $user->permission === 'admin') {
            $data['phong'] = PhongModel::find($room);
            $cumphongs = cumPhongModel::where([['hotel_id', $id]])->get();
            $data['cumphongs'] = $cumphongs;
            $boxs = BoxTvModel::where([['phong_id',$room]])->get();

            $cumphongMD = cumPhongModel::where([['hotel_id',$id],['check',1]])->first();
            $phongMD = PhongModel::where([['cumphong_id',$cumphongMD->id],['check',1]])->first();
            $data['phongMD'] = $phongMD;
            $data['boxs'] = $boxs;
            return view('content.phong.edit', $data);
        } else {
            return redirect('phong/' . $id)
                ->withErrors(['error' => 'Bạn không có quyền truy cập vào phần này']);
        }

    }


    public function updated($id, $room, Request $request)
    {
        $user = Auth::guard('admin')->user();
        $phong = PhongModel::find($room);
        $cumphong = $phong->cumphong()->first();
        $check = 0;
        $phongs = PhongModel::where([['cumphong_id',$cumphong->id]])->get();
        foreach($phongs as $phong1){
            if(trim($phong1->name) === trim($request->name) && $phong1->id != $phong->id){
                $check = 1;
                break;
            }
        }
        if($check == 1){
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Trùng Tên  Phòng đã có sẵn']);
        }

        $box = $request->box;
        $box1 = $request->box1;


        // lấy ra cụm phòng mặc định và Phòng Mặc định
        $cumphongMD = cumPhongModel::where([['hotel_id',$id],['check',1]])->first();

        $phongMD = PhongModel::where([['cumphong_id',$cumphongMD->id],['check',1]])->first();
        // lay ra tat ca Box của phòng cần sửa
        $bs = BoxTvModel::where([['phong_id',$room]])->get();
        // nếu chuyển tất cả các box


        if($box1 !=null){
            $box1 = array_unique($box1);
            foreach($box1 as $b1){
                $item = BoxTvModel::where([['mac',$b1]])->first();
                if($item == null){
                    return redirect('phong/'.$id.'/edit/'.$room)->withErrors(['error'=>'Một trong những BOX thêm vào Phòng không tồn tại']);
                }
            }
        }

        if (($user->hotel_id === $id && $phong->check == 0)) {
            if($box == null){
                // kiểm tra xe box trong phòng đó có Box nào không
                if($bs !=null){
                    foreach($bs as $b){
                        $b->phong_id = $phongMD->id;
                        $b->save();
                    }
                }
            }else{
                // Chuyển 1 Số Box trong phòng đố
                $idB = BoxTvModel::where([['phong_id',$room]])->pluck('id')->toArray();
                if($bs != null){
                    // so sánh box cần chuyển với List box trong phòng đó
                    $different_box = array_diff($idB, $phong);
                    if($different_box != null){
                        foreach($different_phong as $b ){
                            $boxtv->phong_id = $phongMD->id;
                            $boxtv->save();
                        }
                    }
                }
            }

            if($box1 !=null){
                foreach($box1 as $b1){
                    $item = BoxTvModel::where([['mac',$b1]])->first();
                    $item->phong_id = $room;
                    $item->save();
                }
            }
            $item = PhongModel::find($room);

            $item->name = $request->name;
            $item->cumphong_id = $request->cumphong_id;
            $item->save();
            return redirect('/phong/' . $id)
                ->with('success', 'Updated thành công');
        } else {
            return redirect('phong/' . $id)
                ->withErrors(['error' => 'Bạn không có quyền truy cập vào phần này']);
        }
    }


    public function destroy($id, $room)
    {
        $cumphong = cumPhongModel::where([['hotel_id',$id],['check',1]])->first();
        $phong = PhongModel::where([['cumphong_id',$cumphong->id],['check',1]])->first();
        $notification = NotificationModel::find($room);
        if(($notification) != null){
            $notification->delete();
        }
        $boxtvs  = BoxTvModel::where([['phong_id',$room]])->get();
        foreach($boxtvs as $boxtv){
            $boxtv->phong_id = $phong->id;
            $boxtv->save();
        }

        $item = PhongModel::where([['id', $room]])->first();
        $item->delete();
        return redirect('phong/' . $id)
            ->with('success', 'Deleted thành công');
    }

    /*
     * --------- Admin
     * */
//    public function IndexAdmin()
//    {
//
//        $items = cumPhongModel::all();
//        $hotels = InformationModel::all();
//        $items = DB::table('hotel_phong')
//            ->join('tlhotel_cumphong','hotel_phong.cumphong_id','=','tlhotel_cumphong.id')
//            ->join('hotel_infomation','tlhotel_cumphong.hotel_id','=','hotel_infomation.id')
//            ->select('hotel_phong.id AS phong_id', 'hotel_phong.name as tenPhong',
//               'hotel_phong.cumphong_id','tlhotel_cumphong.name AS tenCumPhong',
//                'tlhotel_cumphong.hotel_id','hotel_phong.check','hotel_infomation.name AS TenKS'
//            )
//            ->paginate(7);
//        $data = array();
//        $data['phongs'] = $items;
//        $data['hotels'] = $hotels;
//        return view('content.phong.indexAdmin', $data);
//    }
    public function indexAdmin(Request $request){
        $phong = $request->query('q');
        $phong = trim($phong);

        $hotel_id = $request->query('hotel_id');
        $hotel_id = trim($hotel_id);
        $data = array();
        $hotels = InformationModel::all();
        if($phong != null && $hotel_id == null ){
            // Search Phòng

            $items = DB::table('tlhotel_phong')
                ->join('tlhotel_cumphong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                ->join('tlhotel_information','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                ->where('tlhotel_phong.name','like','%'.$phong.'%')
                ->select('tlhotel_phong.id AS phong_id', 'tlhotel_phong.name as tenPhong',
                    'tlhotel_phong.cumphong_id','tlhotel_cumphong.name AS tenCumPhong',
                    'tlhotel_cumphong.hotel_id','tlhotel_phong.check','tlhotel_information.name AS TenKS'
                )
                ->paginate(10);
            $items->setPath('/phong?q='.$phong);
            $data['q'] = $phong;
            $data['phongs'] = $items;
        }else if($phong == null &&$hotel_id != null){
            /*----- Search theo Khách sạn */
            $items = DB::table('tlhotel_phong')
                ->join('tlhotel_cumphong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                ->join('tlhotel_information','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                ->where('tlhotel_information.id','=',$hotel_id)
                ->select('tlhotel_phong.id AS phong_id', 'tlhotel_phong.name as tenPhong',
                    'tlhotel_phong.cumphong_id','tlhotel_cumphong.name AS tenCumPhong',
                    'tlhotel_cumphong.hotel_id','tlhotel_phong.check','tlhotel_information.name AS TenKS'
                )
                ->paginate(10);
            $items->setPath('/phong?q=&hotel_id='.$hotel_id);
            $data['hotel_id'] = $hotel_id;
            $data['phongs'] = $items;
        }else if($phong != null && $hotel_id != null){
            $items = DB::table('tlhotel_phong')
                ->join('tlhotel_cumphong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                ->join('tlhotel_information','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                ->where('tlhotel_information.id','=',$hotel_id)
                ->where('tlhotel_phong.name','like','%'.$phong.'%')
                ->select('tlhotel_phong.id AS phong_id', 'tlhotel_phong.name as tenPhong',
                    'tlhotel_phong.cumphong_id','tlhotel_cumphong.name AS tenCumPhong',
                    'tlhotel_cumphong.hotel_id','tlhotel_phong.check','tlhotel_information.name AS TenKS'
                )
                ->paginate(10);
            $items->setPath('/phong?q='.$phong.'&hotel_id='.$hotel_id);
            $data['q'] = $phong;
            $data['hotel_id'] = $hotel_id;
            $data['phongs'] = $items;
        }else{
            $items = DB::table('tlhotel_phong')
                ->join('tlhotel_cumphong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                ->join('tlhotel_information','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                ->select('tlhotel_phong.id AS phong_id', 'tlhotel_phong.name as tenPhong',
                    'tlhotel_phong.cumphong_id','tlhotel_cumphong.name AS tenCumPhong',
                    'tlhotel_cumphong.hotel_id','tlhotel_phong.check','tlhotel_information.name AS TenKS'
                )
                ->paginate(10);

            $data['phongs'] = $items;

        }
        $data['hotels'] = $hotels;
        return view('content.phong.indexAdmin', $data);
    }
    public function createAdmin(){
        $hotels = InformationModel::all();
        $data = array();
        $data['hotels']= $hotels;
        return view('content.phong.submitAdmin',$data);
    }


    public function storedAdmin(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'hotel_id'=>'required',
            'cumphong_id'=>'required',
        ],[
            'name.required' => 'Bạn phải nhập  Tên Phòng',
            'hotel_id.required' => 'Bạn phải chọn Khách sạn',
            'cumphong_id.required' => 'Bạn phải chọn Cụm Phòng',
        ]);
        $user = Auth::guard('admin')->user();
        $check = PhongModel::where([['name', trim($request->name)], ['cumphong_id', $request->cumphong_id]])->get();
        $check1 = cumPhongModel::where([['id', $request->cumphong_id], ['hotel_id', $request->hotel_id]])->get();
        if (count($check) != 0 || count($check1) == 0) {
            return redirect()->back()->withInput(Input::all())
                ->withErrors(['error' => 'room is exists ']);
        }
        if ( $user->permission === 'admin') {
            $name = trim($request->name);
            $cumphong_id = $request->cumphong_id;
            $phong = new PhongModel();
            $phong_id = 'P' . Str::random(7);

            $phong->id = $phong_id;
            $phong->name = $name;
            $phong->cumphong_id = $cumphong_id;
            $phong->save();

            $notification = new NotificationModel();
            $notification->id = $phong_id;
            $notification->save();

            return redirect('/phong/create')->with('success',"Thêm mới phòng Thành công");
        } else {
            return redirect()->back()->withInput(Input::all())
                ->withErrors(['error' => 'Thêm mới phòng không thành công :(']);
        }

    }

    public function editAdmin($id){

        $data = array();
        $phong = PhongModel::find($id);
        $cumphong = $phong->cumphong()->first();
        $hotel  = $cumphong->hotelInformation()->first();
        $data['phong'] = $phong;
        $data['cumphong'] = $cumphong;
        $data['hotel'] = $hotel;
        return view('content.phong.editAdmin',$data);
    }

    public function updatedAdmin(Request $request, $id){
        $user = Auth::guard('admin')->user();
        $cumphong  = cumPhongModel::find($request->cumphong_id);
        $phong = PhongModel::where([['name',trim($request->name)],['cumphong_id',$cumphong->id]])->first();

        if ( $user->permission === 'admin' && $phong == null  ) {
            $item = PhongModel::find($id);
            $item->name = $request->name;
            $item->cumphong_id = $request->cumphong_id;
            $item->save();
            return redirect('/phong/')
                ->with('success', 'Updated thành công');
        } else {
            return redirect('phong/')
                ->withErrors(['error' => 'Bạn không có quyền truy cập vào phần này']);
        }
    }

    public function destroyAdmin($id){
        // lay ra cum phong mac dinh khoi tao
        $item_phong = PhongModel::find($id);
        $item_cumphong = $item_phong->cumphong()->first();
        $cumphong = cumPhongModel::where([['hotel_id',$item_cumphong->hotel_id],['check',1]])->first();
        // lay ra phong mac dinh khoi tao
        $phong = PhongModel::where([['cumphong_id',$cumphong->id],['check',1]])->first();

        $notification = NotificationModel::find($id);
        if(($notification) != null){
            $notification->delete();
        }
        $boxtvs  = BoxTvModel::where([['phong_id',$id]])->get();
        foreach($boxtvs as $boxtv){
            $boxtv->phong_id = $phong->id;
            $boxtv->save();
        }

        $item_phong->delete();
        return redirect('phong/' )
            ->with('success', 'Deleted thành công');
    }
}
