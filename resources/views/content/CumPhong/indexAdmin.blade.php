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
                        <h4 class="card-title">Cụm Phòng </h4>
                        <div class="row justify-content-between">
                            <a href="{{url('cumphong/create')}}"><button class="btn btn-success btn-wd">Thêm Cụm Phòng</button></a>
                            <div class="col-sm-3 ">
                                <form action="{{url('/cumphong')}}" id="searchform" method="get">
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
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>Khách sạn</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            ?>
                            @foreach($cumphongs as $cumphong)
                                <?php
                                    $name = $cumphong->hotelInformation()->first();
                                ?>
                                <tr>

                                    <td class="text-center">{{$i++}}</td>
                                    <td>{{$cumphong->name}}</td>
                                    <td>{{$name->name}}</td>
                                    <td class="td-actions ">
                                        @if($cumphong->check == 0)
                                            <a href="{{url('cumphong/edit/'.$cumphong->id)}}" rel="tooltip" title="" class="btn btn-success btn-link btn-xs" data-original-title="Edit Profile">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{url('cumphong/delete/'.$cumphong->id)}}" rel="tooltip" title="" class="btn btn-danger btn-link btn-xs" data-original-title="Remove">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {{ $cumphongs->links() }}
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection