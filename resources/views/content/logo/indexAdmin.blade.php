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

                        <h4 class="card-title">Danh sách Ảnh Nền</h4>
{{--                        <a href="{{url('background/create')}}"><button class="btn btn-success btn-wd">Add BackGround</button></a>--}}
                    </div>
                    <div class="card-body table-full-width">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center" style="width: 120px !important;">Tên Khách sạn</th>
                                <th class="text-center" style="width: 600px !important;" >Ảnh</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            ?>
                            @foreach($backgrounds as $background)

                                <tr>
                                    <td class="text-center">{{$i++}}</td>
                                    <td class="text-center">{{$background->tenKS}}</td>
                                    <td>
                                        <?php
                                        $images = isset($background->link) ? json_decode($background->link) : array();
                                        ?>
                                        @if(!empty($images))
                                            @foreach($images as $image)
                                                <img src="{{ url($image) }}" style="margin-top:15px;max-height:100px;">
                                            @endforeach
                                        @endif
                                    </td>

                                    <td class="td-actions  text-center ">
                                        <a href="{{url('background/edit/'.$background->id)}}" rel="tooltip" title="" class="btn btn-success btn-link btn-xs" data-original-title="Edit Profile">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                    </td>
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