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
                <div class="card table-with-links">

                    <div class="card-header ">
                        <h4 class="card-title">Danh sách BoxTv</h4>

                    </div>
                    <div class="card-body table-full-width">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Serial</th>
                                <th class="text-center">Mac</th>
                                <th class="text-center">Phòng</th>
                                <th class="text-center">Cụm Phòng</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;
                                $value =  $_SERVER['REQUEST_URI'];
                                $arr = explode('/',$value);
                                $id = $arr[count($arr)-1];
                            ?>
                            @foreach($boxs as $box)
                                <tr>
                                    <td class="text-center">{{$i++}}</td>
                                    <td class="text-center">{{$box->serial}}</td>
                                    <td class="text-center">{{$box->mac}}</td>
                                    <td class="text-center">{{$box->tenPhong}}</td>
                                    <td class="text-center">{{$box->tenCumPhong}}</td>
                                    <td class="td-actions  text-center" >

                                            <a href="{{url('box/'.$box->hotel_id.'/edit/'.$box->box_id)}}" rel="tooltip" title="" class="btn btn-success btn-link btn-xs" data-original-title="Edit Profile">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $boxs->links() }}
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection