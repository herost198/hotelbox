<?php

namespace App\Http\Controllers;

use App\Model\InformationModel;
use App\Model\ServiceModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ServiceController extends Controller
{

    public function indexAdmin(Request $request){
        $search = $request->query('q');
        $search = trim($search);
        $data = array();
        if($search != null){
            $services = DB::table('tlhotel_service')
                ->join('tlhotel_information','tlhotel_information.id','=','tlhotel_service.hotel_id')
                ->where('tlhotel_information.name','like','%'.trim($search).'%')
                ->select('tlhotel_service.*','tlhotel_information.name as tenKS')
                ->paginate(7);
            $services->setPath('/service?q='.$search);
            $data['q'] = $search;
            $data['services'] = $services;
        }else{
            $services = DB::table('tlhotel_service')
                ->join('tlhotel_information','tlhotel_information.id','=','tlhotel_service.hotel_id')
                ->select('tlhotel_service.*','tlhotel_information.name as tenKS')
                ->get();
            $data['services'] = $services;
        }

        return view('content.service.indexAdmin',$data);
    }

    public function createAdmin(){
        $hotels = InformationModel::all();
        $data = array();
        $data['hotels'] = $hotels;

        return view('content.service.submitAdmin',$data);
    }


    public function storedAdmin(Request $request){
        $this->validate($request,[
            'hotel_id'=>'required',
            'icon'=>'required|size|4',
            'color_icon'=>'required|size:7',
            'tittle'=>'required',
        ],[
            'hotel_id.required'=>'Bạn phải chọn Khách sạn',
            'icon.required'=>'Bạn phải nhập Icon',
            'icon.size'=>'Độ dài Icon không đúng',
            'color_icon.size'=>'Độ dài Color không đúng',
            'color_icon.required'=>'Bạn phải nhập mã Màu',
            'tittle.required'=>'Bạn phải nhập Tittle',
        ]);
        $user = Auth::guard('admin')->user();
        if($user != null){
            $item = new ServiceModel();
            $item->id = 'SV00'.time();
            $item->icon = $request->icon;
            $item->color_icon = $request->color_icon;
            $item->tittle = $request->tittle;
            $item->link = $request->link ? $request->link : '';
            $item ->hotel_id = $request->hotel_id;
            $item->save();
            return redirect('service/create')->with('success','Thêm mới Service thành công ');
        }else{
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Thêm Serivice không thành công :(']);
        }
    }

    public function editAdmin($id){
        $data = array();
        $service = ServiceModel::find($id);
        $hotel = $service->information()->first();
        $data['service'] = $service;
        $data['hotel'] = $hotel;
        return view('content.service.editAdmin',$data);
    }

    public function updatedAdmin(Request $request ,$id){
        $this->validate($request,[
            'icon'=>'required|size:4',
            'color_icon'=>'required|size:7',
            'tittle'=>'required',
        ],[
            'icon.required'=>'Bạn phải nhập Icon',
            'icon.size'=>'Độ dài Icon không đúng',
            'color_icon.size'=>'Độ dài Color không đúng',
            'color_icon.required'=>'Bạn phải nhập mã Màu',
            'tittle.required'=>'Bạn phải nhập Tittle',
        ]);
        $item = ServiceModel::find($id);
        $item->icon = $request->icon;
        $item->color_icon = $request->color_icon;
        $item->tittle = $request->tittle;
        $item->link = $request->link ? $request->link : '';
        $item->save();
        return redirect('service')->with('success','Sửa Service thành công ');

    }

    public function destroyAdmin($id){
        $user = Auth::guard('admin')->user();
        if($user->permission =='admin'){
            $item = ServiceModel::find($id);
            $item->delete();
            return redirect('service')->with('success','Xóa Thành công ');
        }else{
            return redirect('service')
                ->withErrors(['error' => 'Bạn không có quyền truy cập vào phần này']);
        }
    }

    public function index($id){
        $services = DB::table('tlhotel_service')
            ->join('tlhotel_information','tlhotel_information.id','=','tlhotel_service.hotel_id')
            ->select('tlhotel_service.*','tlhotel_information.name as tenKS')
            ->where('tlhotel_information.id',$id)
            ->get();
        $data['hotel_id'] = $id;
        $data['services'] = $services;

        return view('content.service.index',$data);
    }

    public function create($id){
        $data = array();
        $data['hotel_id'] = $id;
        return view('content.service.submit',$data);
    }

    public function stored(Request $request, $id){
        $this->validate($request,[
            'icon'=>'required|size:4',
            'color_icon'=>'required|size:7',
            'tittle'=>'required',
        ],[
            'icon.required'=>'Bạn phải nhập Icon',
            'icon.size'=>'Độ dài Icon không đúng',
            'color_icon.size'=>'Độ dài Color không đúng',
            'color_icon.required'=>'Bạn phải nhập mã Màu',
            'tittle.required'=>'Bạn phải nhập Tittle',
        ]);
        $user = Auth::guard('admin')->user();
        if($user != null && $user->hotel_id == $id){
            $item = new ServiceModel();
            $item->id = 'SV00'.time();
            $item->icon = $request->icon;
            $item->color_icon = $request->color_icon;
            $item->tittle = $request->tittle;
            $item->link = $request->link ? $request->link : '';
            $item ->hotel_id = $id;
            $item->save();
            return redirect('service/'.$id.'/create')->with('success','Thêm mới Service thành công ');
        }else{
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Thêm Serivice không thành công :(']);
        }
    }

    public function edit($id, $idS){
        $data = array();

        $service = ServiceModel::find($idS);
        $hotel = $service->hotelInformation()->first();
        if($hotel->id == $id){
            $data['service'] = $service;
            $data['hotel'] = $hotel;
            return view('content.service.edit',$data);
        }else{
            return redirect('service/'.$id)->withErrors(['error'=>'Bạn không có quyền truy cập vào phần này']);
        }

    }

    public function updated($id, $idS, Request $request){
        $this->validate($request,[
            'icon'=>'required|size:4',
            'color_icon'=>'required|size:7',
            'tittle'=>'required',
        ],[
            'icon.required'=>'Bạn phải nhập Icon',
            'icon.size'=>'Độ dài Icon không đúng',
            'color_icon.size'=>'Độ dài Color không đúng',

            'color_icon.required'=>'Bạn phải nhập mã Màu',
            'tittle.required'=>'Bạn phải nhập Tittle',
        ]);
        $item = ServiceModel::find($idS);
        if($item->hotel_id == $id){
            $item->icon = $request->icon;
            $item->color_icon = $request->color_icon;
            $item->tittle = $request->tittle;
            $item->link = $request->link ? $request->link : '';
            $item->save();
            return redirect('service/'.$id)->with('success','Sửa Service thành công ');
        }else{
            return redirect()->back()->withInput(Input::all())->withErrors(['error'=>'Sửa Serivice không thành công :(']);
        }
    }

    public function destroy($id, $idS){
        $user = Auth::guard('admin')->user();
        if($user->hotel_id == $id){
            $item = ServiceModel::find($idS);
            $item->delete();
            return redirect('service')->with('success','Xóa Thành công ');
        }else{
            return redirect('service')
                ->withErrors(['error' => 'Bạn không có quyền truy cập vào phần này']);
        }
    }
}
