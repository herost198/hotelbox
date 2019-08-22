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

                    <div class="card-header ">
                        <h4 class="card-title">Danh sách Khách sạn</h4>
                        <div class="row justify-content-between">
                            <a class="col-sm-3" href="{{url('hotel/create')}}"><button class="btn btn-success btn-wd">Thêm Khách sạn</button></a>

                            <div class="col-sm-4 ">
                                <form action="{{url('/hotel')}}" id="searchform" method="get">
                                    <input type="text" id="s" name="q" value="" placeholder="Tên Khách sạn"/>
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
                                <th class="text-center">Name</th>
                                <th class="text-center">Tittle</th>
                                <th class="text-center">User Name</th>
                                <th class="text-center">Logo</th>
                                <th class="text-center">Actions</th>
                                <th class="text-center">Reset Password</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;
                            ?>
                                @foreach($hotels as $hotel)

                                    <tr>
                                        <td class="text-center">{{$i++}}</td>
                                        <td class="text-center">{{$hotel->name}}</td>
                                        <td class="text-center">{{$hotel->tittle}}</td>
                                        <td class="text-center">{{$hotel->user()->first()['username']}}</td>
                                        <td class="text-center">
                                            <img  height="50px" width="50px" src={{url($hotel->logo)}} >
                                            </td>
                                        <td class="td-actions text-center ">
                                            <a href="{{url('hotel/edit/'.$hotel->id)}}" rel="tooltip" title="" class="btn btn-success btn-link btn-xs" data-original-title="Edit Profile">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-link btn-xs" onclick="demo.showSwal('warning-message-and-cancel','hotel','{{$hotel->id }}')">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                        <td  class="text-center">
                                            <a onclick="demo.showSwal('warning-message-and-cancel','resetPassword','{{$hotel->id }}')" rel="tooltip" title="" class="btn btn-danger btn-link btn-xs" data-original-title="Reset Password">
                                                <i class="fas fa-redo"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        {{ $hotels->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection