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

                        <div class="row justify-content-between">
                            <a href="{{url('notification/edit')}}">
                                <button class="btn btn-success btn-wd">Chỉnh sửa Thông báo
                                </button>
                            </a>
                            <div class="col-sm-3 ">
                                <form action="{{url('/notification')}}" id="searchform" method="get">
                                    <select name="hotel_id" id="hotel_id" style="height: 28px;" >
                                        <option value=""  selected >

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
                                    <input type="submit" value="Search" id="searchsubmit"/>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-full-width">
                        <table class="table"   >
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tittle</th>
                                <th class="text-center">Phòng</th>
                                <th class="text-center">Cụm Phòng</th>
                                <th class="text-center">Khách sạn</th>
                                {{--                                <th>Actions</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                             $i = 1;
                            ?>
                            @foreach($notifications as $notification)
                                <tr >
                                    <td class="text-center" >{{$i++}}</td>
                                    <td class="pl-2 text-center"  >
                                        {{strlen($notification->tittle) > 50 ? substr($notification->tittle,0,30).'...': $notification->tittle}}
                                    </td>

                                    <td class="pl-2  text-center ">  {{$notification->tenPhong}}</td>
                                    <td class="pl-2 text-center">{{$notification->tenCumPhong}}</td>
                                    <td class="pl-2 text-center">{{$notification->TenKS}}</td>


                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection