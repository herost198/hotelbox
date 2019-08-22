<?php

namespace App\Http\Controllers;

use App\Model\PopUpModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class popUpController extends Controller
{
    public function IndexAdmin()
    {
        $items = $items = DB::table('tlhotel_popup')
            ->join('tlhotel_information', 'tlhotel_information.id', '=', 'tlhotel_popup.id')
            ->select('tlhotel_popup.*', 'tlhotel_information.name as tenKS'
            )->paginate(7);
        $data = array();
        $data['popups'] = $items;
        return view('content.PopUp.indexAdmin', $data);
    }


    public function editAdmin($id)
    {
        $popup = DB::table('tlhotel_popup')
            ->join('tlhotel_information', 'tlhotel_information.id', '=', 'tlhotel_popup.id')
            ->where('tlhotel_information.id', $id)
            ->select('tlhotel_popup.*', 'tlhotel_information.name as tenKS')
            ->first();
        if ($popup != null) {
            $data = array();
            $data['popup'] = $popup;
            return view('content.PopUp.editAdmin', $data);
        } else {
            return redirect('popup')->withErrors(['error' => 'Không có Khách sạn mong đợi']);
        }

    }

    public function updatedAdmin($id, Request $request)
    {
        $user = Auth::guard('admin')->user();
        $time = $request->time;
        $images1 = $request->images1;
        $images = $request->images;

        $popup = PopUpModel::find($id);
        // lay ra tat ca anh trong Db
        $link = json_decode($popup->link);
        $path = [];
//       Upload   ẢNh into Stored
        if ($request->hasFile('images')) {
            foreach ($images as $image) {
                if($image != null){
                    $imageName = '/images/popup/' . Str::random(3) . time() . $image->getClientOriginalName();
                    array_push($path, $imageName);
                    $image->move('images/popup', $imageName);
                }

            }

//        dd($path);
            if ($images1 == null) {
                $deletes = $link;
            } else {
                $deletes = array_diff($link, $images1);
                $path = array_merge($path, $images1);
            }

            // Xóa ảnh
            if ($deletes != null) {
//            $url = '/images/popup/';
                foreach ($deletes as $delete) {
                    if (file_exists(public_path() . $delete)) {
                        @unlink((public_path() . $delete));
                    }
                }
            };
            $popup->duration = $time;
            $popup->link = json_encode($path);
            $popup->save();
            if ($user->permission === 'admin') {
                return redirect('popup')->with(['success' => 'Updated Thành cônng']);
            } else if ($user->permission === 'user') {
                return redirect('popup/edit/' . $id)->with(['success' => 'Updated Thành cônng']);
            }
        }else{
            $popup->duration = $time;
            $popup->save();
            if ($user->permission === 'admin') {
                return redirect('popup')->with(['success' => 'Updated Thành cônng']);
            } else if ($user->permission === 'user') {
                return redirect('popup/edit/' . $id)->with(['success' => 'Updated Thành cônng']);
            }
        }
    }
}
