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

                        <h4 class="card-title">Danh sách Dịch vụ</h4>
                        <div class="row justify-content-between">
                            <a class="col-sm-3" href="{{url('service/create')}}"><button class="btn btn-success btn-wd">Thêm Dịch vụ</button></a>
                            <div class="col-sm-4 ">
                                <form action="{{url('/service')}}" id="searchform" method="get">
                                    <input type="text" id="s" name="q"
                                           value="<?php echo  isset($q) ?  $q : '';?>"
                                           placeholder="Khách sạn"/>
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
                                <th class="text-center" >Icon</th>
                                <th class="text-center"  >Icon Color</th>
                                <th class="text-center" >Tittle</th>
{{--                                <th class="text-center"  >Link </th>--}}
                                <th class="text-center"  >Khách sạn</th>

                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;
                            ?>
                            @foreach($services as $service)

                                <tr>
                                    <td class="text-center">{{$i++}}</td>
                                    <td class="text-center">{{$service->icon}}</td>
                                    <td class="text-center">
                                            {{$service->color_icon}}
                                    </td >
                                    <td class="text-center">
                                        {{$service->tittle}}
                                    </td>
{{--                                    <td class="text-center">--}}
{{--                                        {{$service->link}}--}}
{{--                                    </td>--}}
                                    <td class="text-center">
                                        {{$service->tenKS}}
                                    </td>
                                    <td class="td-actions  text-center ">
                                        <a href="{{url('service/edit/'.$service->id)}}" rel="tooltip" title="" class="btn btn-success btn-link btn-xs" data-original-title="Edit Profile">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="{{url('service/delete/'.$service->id)}}" rel="tooltip" title="" class="btn btn-danger btn-link btn-xs" data-original-title="Remove">
                                            <i class="fa fa-times"></i>
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