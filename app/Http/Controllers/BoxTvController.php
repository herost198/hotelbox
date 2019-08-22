<?php

namespace App\Http\Controllers;

use App\Model\BoxTvModel;
use App\Model\InformationModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Excel;
class BoxTvController extends Controller
{
    public function indexAdmin(Request $request){
        $data = array();

        $mac = $request->query('q');
        $mac  = trim($mac);

        $hotel_id = $request->query('hotel_id');
        $hotel_id = trim($hotel_id);

        if ($mac != null && $hotel_id == null ){
            $boxs = DB::table('tlhotel_boxtv')
                ->join('tlhotel_phong','tlhotel_boxtv.phong_id','=','tlhotel_phong.id')
                ->join('tlhotel_cumphong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                ->join('tlhotel_information','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                ->select('tlhotel_boxtv.id AS box_id', 'tlhotel_boxtv.serial','tlhotel_boxtv.mac','tlhotel_boxtv.is_active','tlhotel_boxtv.tv_package_name',
                    'tlhotel_boxtv.phong_id','tlhotel_phong.name AS tenPhong','tlhotel_phong.cumphong_id','tlhotel_cumphong.name AS tenCumPhong',
                    'tlhotel_cumphong.hotel_id','tlhotel_cumphong.check','tlhotel_information.name AS TenKS'
                )
                ->where('tlhotel_boxtv.mac', 'like', '%'.$mac.'%')
                ->paginate(10);
            $boxs->setPath('/box?q='.$mac);
            $data['q'] = $mac;
        }else if($mac == null && $hotel_id != null){
            $boxs = DB::table('tlhotel_boxtv')
                ->join('tlhotel_phong','tlhotel_boxtv.phong_id','=','tlhotel_phong.id')
                ->join('tlhotel_cumphong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                ->join('tlhotel_information','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                ->select('tlhotel_boxtv.id AS box_id', 'tlhotel_boxtv.serial','tlhotel_boxtv.mac','tlhotel_boxtv.is_active','tlhotel_boxtv.tv_package_name',
                    'tlhotel_boxtv.phong_id','tlhotel_phong.name AS tenPhong','tlhotel_phong.cumphong_id','tlhotel_cumphong.name AS tenCumPhong',
                    'tlhotel_cumphong.hotel_id','tlhotel_cumphong.check','tlhotel_information.name AS TenKS'
                )
                ->where('tlhotel_information.id', $hotel_id)
                ->paginate(10);
            $boxs->setPath('/box?hotel_id='.$hotel_id);
            $data['hotel_id'] = $hotel_id;
        }else if($mac !=null && $hotel_id !=null){
            $boxs = DB::table('tlhotel_boxtv')
                ->join('tlhotel_phong','tlhotel_boxtv.phong_id','=','tlhotel_phong.id')
                ->join('tlhotel_cumphong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                ->join('tlhotel_information','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                ->select('tlhotel_boxtv.id AS box_id', 'tlhotel_boxtv.serial','tlhotel_boxtv.mac','tlhotel_boxtv.is_active','tlhotel_boxtv.tv_package_name',
                    'tlhotel_boxtv.phong_id','tlhotel_phong.name AS tenPhong','tlhotel_phong.cumphong_id','tlhotel_cumphong.name AS tenCumPhong',
                    'tlhotel_cumphong.hotel_id','tlhotel_cumphong.check','tlhotel_information.name AS TenKS'
                )
                ->where('tlhotel_information.id', $hotel_id)
                ->where('tlhotel_boxtv.mac', 'like', '%'.$mac.'%')
                ->paginate(10);
            $boxs->setPath('/box?hotel_id='.$hotel_id);
            $data['hotel_id'] = $hotel_id;
            $data['q'] = $mac;
        }else {
            $boxs = DB::table('tlhotel_boxtv')
                ->join('tlhotel_phong','tlhotel_boxtv.phong_id','=','tlhotel_phong.id')
                ->join('tlhotel_cumphong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
                ->join('tlhotel_information','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
                ->select('tlhotel_boxtv.id AS box_id', 'tlhotel_boxtv.serial','tlhotel_boxtv.mac','tlhotel_boxtv.is_active','tlhotel_boxtv.tv_package_name',
                    'tlhotel_boxtv.phong_id','tlhotel_phong.name AS tenPhong','tlhotel_phong.cumphong_id','tlhotel_cumphong.name AS tenCumPhong',
                    'tlhotel_cumphong.hotel_id','tlhotel_cumphong.check','tlhotel_information.name AS TenKS'
                )
                ->paginate(10);
        }

        $hotels = Informationmodel::all();
        $data['hotels'] = $hotels;
        $data['boxs'] = $boxs;
        return view('content.boxtv.indexAdmin',$data);
    }
    public function create(){
        $hotels = InformationModel::all();
        $data = array();
        $data['hotels']= $hotels;
        return view('content.boxtv.submit',$data);
    }

    public function stored(Request $request){
        $this->validate($request,[

            'file'=>'mimes:xls,xlsx',
            'hotel_id'=>'required',
            'cumphong_id'=>'required',
            'phong_id'=>'required',
        ],[
            'file.mimes' => 'File không hợp lệ. vui lòng nhập file: .xls, xlsx',
            'hotel_id.required' => 'Bạn phải chọn Khách sạn',
            'cumphong_id.required' => 'Bạn phải chọn Cụm Phòng',
            'phong_id.required' => 'Bạn phải chọn Phòng',
        ]);

        $input = $request->all();

        $file = $request->file;
        $mac = $request->mac;
        if($mac == null && $file == null || $mac != null && $file != null){
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Thêm mới BoxTv không thành công :(. Vui lòng nhập Mac']);
        }else if($mac!= null && $file == null){


            $check  = BoxTvModel::where([['mac',$input['mac']]])->get();

            if(count($check) == 0){
                $item = new BoxTvModel();
                $item->id = "TV00".Str::random(7);
                $item->serial = $input['serial'];
                $item->mac = $input['mac'];
                $item->is_active = $input['is_active'];
                $item->tv_package_name = $input['tv_package_name'];
                $item->phong_id = $input['phong_id'];
                $item->save();
                return redirect('box/create/')->with('success','Thêm mới BoxTv thành công ');
            }else{
                return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Thêm mới BoxTv không thành công :(']);
            }
        }else{

            $path = $file->getRealPath();
            $data = Excel::selectSheets('Sheet1')->load($path)->get();
//            dd($data->toArray());
            if($data->count() > 0){
                $kiemtra = 0;
                foreach($data->toArray() as $key=>$value){
                    foreach($value as $row){
                         $item =  BoxTvModel::where([['mac',$row]])->first();
                         if($item != null){
                             $kiemtra = 1;
                             break;
                         }

                    }
                }
                if($kiemtra == 1){
                    return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Thêm mới BoxTv không thành công :(. Serial bị trùng']);
                }else{
                    foreach($data->toArray() as $key=>$value){
                        foreach($value as $row){
                            $item = new BoxTvModel();
                            $item->id = "TV00".Str::random(7);
                            $item->serial = $input['serial'];
                            $item->mac = (string)$row;
                            $item->is_active = $input['is_active'];
                            $item->tv_package_name = $input['tv_package_name'];
                            $item->phong_id = $input['phong_id'];
                            $item->save();
                        }
                    }
                    return redirect('box/create/')->with('success','Thêm mới BoxTv thành công ');
                }

            }else{
                return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Thêm mới BoxTv không thành công :(']);
            }
        }




    }

    public function editAdmin($id){
        $data = array();
        $box = BoxTvModel::find($id);
        $phong   =  $box->phong()->first();
        $cumphong = $phong->cumphong()->first();
        $hotel  = $cumphong->hotelInformation()->first();
        $data['box'] = $box;
        $data['phong'] = $phong;
        $data['cumphong'] = $cumphong;
        $data['hotel'] = $hotel;
        return view('content.boxtv.editAdmin',$data);
    }

    public function updatedAdmin($id, Request $request){
        $this->validate($request,[
            'mac'=>'required',
            'cumphong_id'=>'required',
            'phong_id'=>'required',
        ],[
            'mac.required' => 'Bạn phải nhập  mac',
            'cumphong_id.required' => 'Bạn phải chọn Cụm Phòng',
            'phong_id.required' => 'Bạn phải chọn Phòng',
        ]);
        $input =$request->all();
        $item = BoxTvModel::find($id);

        if(count($item->toArray()) == 0){
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Sửa BoxTv không thành công :(']);
        }

        $item->serial = $input['serial'];
        $item->mac = $input['mac'];
        $item->is_active = $input['is_active'];
        $item->tv_package_name = $input['tv_package_name'];
        $item->phong_id = $input['phong_id'];
        $item->save();
        return redirect('box/')->with('success','Sửa BoxTv thành công ');

    }

    public function destroy($id){
        $user = Auth::guard('admin')->user();
        if($user->permission =='admin'){
            $item = BoxTvModel::find($id);
            $item->delete();
            return 1;
//            return redirect('box')->with('success','Xóa Thành công ');
        }else{
            return 0;
//            return redirect('box/' . $id)
//                ->withErrors(['error' => 'Bạn không có quyền truy cập vào phần này']);
        }
    }


    public function index($id){
        $user = Auth::guard('admin')->user();

        $data = array();
        $boxs = DB::table('tlhotel_boxtv')
            ->join('tlhotel_phong','tlhotel_boxtv.phong_id','=','tlhotel_phong.id')
            ->join('tlhotel_cumphong','tlhotel_phong.cumphong_id','=','tlhotel_cumphong.id')
            ->join('tlhotel_information','tlhotel_cumphong.hotel_id','=','tlhotel_information.id')
            ->where('tlhotel_information.id',$id)
            ->select('tlhotel_boxtv.id AS box_id', 'tlhotel_boxtv.serial','tlhotel_boxtv.mac','tlhotel_boxtv.is_active','tlhotel_boxtv.tv_package_name',
                'tlhotel_boxtv.phong_id','tlhotel_phong.name AS tenPhong','tlhotel_phong.cumphong_id','tlhotel_cumphong.name AS tenCumPhong',
                'tlhotel_cumphong.hotel_id','tlhotel_cumphong.check','tlhotel_information.name AS TenKS'
            )
            ->paginate(7);
        $data['boxs']= $boxs;

        return view('content.boxtv.index',$data);

    }

    public function edit($id, $box){
        $data = array();
        $box = BoxTvModel::find($box);
        $phong   =  $box->phong()->first();
        $cumphong = $phong->cumphong()->first();
        $hotel  = $cumphong->hotelInformation()->first();

        $data['box'] = $box;
        $data['phong'] = $phong;
        $data['cumphong'] = $cumphong;
        $data['hotel'] = $hotel;
        return view('content.boxtv.edit',$data);
    }

    public function updated($id, $box, Request $request){
        $this->validate($request,[
            'cumphong_id'=>'required',
            'phong_id'=>'required',
        ],[
            'cumphong_id.required' => 'Bạn phải chọn Cụm Phòng',
            'phong_id.required' => 'Bạn phải chọn Phòng',
        ]);
        $input =$request->all();
        $item = BoxTvModel::find($box);
        if(count($item->toArray()) == 0){
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Sửa BoxTv không thành công :(']);
        }
        if(Auth::guard('admin')->user()->hotel_id == $id){
            $item->phong_id = $input['phong_id'];
            $item->save();
            return redirect('box/'.$id)->with('success','Sửa BoxTv thành công ');
        }else{
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Sửa BoxTv không thành công :(']);
        }

    }
}
