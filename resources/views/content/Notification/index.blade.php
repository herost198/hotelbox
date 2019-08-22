@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                <div class="alert alert-success">
                       {{session('success')}}
                    <br>
                </div>
                @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                        </div>
                    @endif
                <div class="card table-with-links" >

                    <div class="card-header ">
                        <h4 class="card-title"> Danh sách Thông báo </h4>
                        <a href="{{url('notification/'.Auth::guard('admin')->user()->hotel_id).'/edit'}}">
                            <button class="btn btn-success btn-wd">Chỉnh sửa Thông báo
                            </button>
                        </a>
                    </div>
                    <div class="card-body table-full-width">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tittle</th>
                                <th class="text-center">Phòng</th>
                                <th class="text-center">Cụm Phòng</th>
{{--                                <th>Actions</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;
//                                $value =  $_SERVER['REQUEST_URI'];
//                                $arr = explode('/',$value);
//                                $result = $arr[count($arr)-1];
                            ?>
                                @foreach($notifications as $notification)
{{--                                    {{dd( $notification->phong()->first()->cumphong()->first())}}--}}
                                    <tr >
                                        <td class="text-center" >{{$i++}}</td>
                                        <td class="text-center"  >
                                            {{strlen($notification->tittle) > 50 ? substr($notification->tittle,0,30).'...': $notification->tittle}}
                                        </td>

                                        <td class="text-center">  {{$notification->phong()->first()->name}}</td>
                                        <td class="text-center">
                                            {{$notification->phong()->first()->cumphong()->first()->name}}
                                        </td >


                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection