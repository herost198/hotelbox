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
                        <div class="row justify-content-between">
                            <div class="col-sm-6">
                                <a href="{{url('box/create')}}"><button class="btn btn-success btn-wd">Thêm Box Tv</button></a>
                            </div>


                            <div class="col-sm-5 ">
                                <form action="{{url('/box')}}" id="searchform" method="get">
                                    <select name="hotel_id" id="hotel_id" style="height: 28px;" >
                                        <option value=""  selected>

                                        </option>
                                        @for($i = 0 ; $i< count($hotels); $i++)
                                            @if( isset($hotel_id) && $hotel_id == $hotels[$i]->id )
                                                <option value="{{$hotels[$i]->id}}"  selected>
                                                    {{$hotels[$i]->name}}
                                                </option>
                                            @else
                                                <option value="{{$hotels[$i]->id}}" >
                                                    {{$hotels[$i]->name}}
                                                </option>
                                            @endif
                                        @endfor
                                    </select>
                                    <input type="text" id="s" name="q"
                                           value="<?php echo  isset($q) ?  $q : '';?>"
                                           placeholder="Mac"/>
                                    <input type="submit" value="Search" id="searchsubmit"/>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-full-width">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Serial</th>
                                <th class="text-center">Mac</th>
                                <th class="text-center">is_active</th>
                                <th class="text-center">tv_package_name</th>
                                <th class="text-center">Phòng</th>
                                <th class="text-center">Cụm Phòng</th>
                                <th class="text-center">Khách sạn</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;
                            ?>
                            @foreach($boxs as $box)
                                <tr>
                                    <td class="text-center">{{$i++}}</td>
                                    <td class="text-center">{{$box->serial}}</td>
                                    <td class="text-center">{{$box->mac}}</td>
                                    <td class="text-center">{{$box->is_active}}</td>
                                    <td class="text-center">{{$box->tv_package_name}}</td>
                                    <td class="text-center">{{$box->tenPhong}}</td>
                                    <td class="text-center">{{$box->tenCumPhong}}</td>
                                    <td class="text-center">{{$box->TenKS}}</td>
                                    <td class="td-actions  text-center" >

                                            <a href="{{url('box/edit/'.$box->box_id)}}" rel="tooltip" title="" class="btn btn-success btn-link btn-xs" data-original-title="Edit Profile">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        <a class="btn btn-danger btn-link btn-xs" onclick="demo.showSwal('warning-message-and-cancel','boxtv','{{$box->box_id }}')">
                                            <i class="fa fa-times"></i>
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