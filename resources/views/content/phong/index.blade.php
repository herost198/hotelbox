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
                <div class="card table-with-links">

                    <div class="card-header  ">
                        <h4 class="card-title"> Danh sách Phòng </h4>
                        <?php
                            $user = \Illuminate\Support\Facades\Auth::guard('admin')->user();
                        ?>

                        <div class="row justify-content-between">
                            <a href="{{url('phong/'.$user->hotel_id).'/create'}}" class="col-sm-3">
                                <button class="btn btn-success btn-wd">Thêm Phòng
                                </button>
                            </a>

                            <div class="col-sm-5 ">
                                <form action="{{url('/phong/'.$user->hotel_id)}}" id="searchform" method="get">
                                    <select name="cumphong_id"  style="height: 28px;" >
                                        <option value=""  selected>

                                        </option>
                                        @for($i = 0 ; $i< count($cumphongs); $i++)
                                            @if( isset($cumphong_id) && $cumphong_id == $cumphongs[$i]->id )
                                                <option value="{{$cumphongs[$i]->id}}"  selected>
                                                    {{$cumphongs[$i]->name}}
                                                </option>
                                            @else
                                                <option value="{{$cumphongs[$i]->id}}" >
                                                    {{$cumphongs[$i]->name}}
                                                </option>
                                            @endif
                                        @endfor
                                    </select>
                                    <input type="text" id="s" name="q"
                                           value="<?php echo  isset($q) ?  $q : '';?>"
                                           placeholder="Phòng"/>
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
                                <th class="text-center"> Tên Phòng</th>
                                <th class="text-center"> Số lượng Box</th>
                                <th class="text-center">Cụm phòng</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;

                            ?>
                                @foreach($rooms as $room)

                                    <tr>
                                        <td class="text-center">{{$i++}}</td>
                                        <td class="text-center">{{$room->name}}</td>
                                        <td class="text-center">{{$room->SoLuong}}</td>
                                        <td class="pl-2 text-center">{{$room->TenCPhong}}</td>
                                        <td class="td-actions   text-center">
                                            @if($room->check == 0)
                                                <a href="{{url('phong/'.$room->TenKS.'/edit/'.$room->id)}}" rel="tooltip" title="" class="btn btn-success btn-link btn-xs" data-original-title="Edit Profile">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{url('phong/'.$room->TenKS.'/delete/'.$room->id)}}" rel="tooltip" title="" class="btn btn-danger btn-link btn-xs" data-original-title="Remove">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{ $rooms->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection