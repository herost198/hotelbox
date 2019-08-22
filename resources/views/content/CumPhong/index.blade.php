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
                        <h4 class="card-title">Cụm Phòng </h4>
                        <a href="{{url('cumphong/'.Auth::guard('admin')->user()->hotel_id).'/create'}}"><button class="btn btn-success btn-wd">Add Cụm Phòng</button></a>
                    </div>
                    <div class="card-body table-full-width">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Số Lượng Phòng</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;
                            ?>
                                @foreach($cumphongs as $cumphong)

                                    <tr>
                                        <td class="text-center">{{$i++}}</td>
                                        <td class="text-center">{{$cumphong->name}}</td>
                                        <td class="text-center">{{$cumphong->total}}</td>

                                        <td class="td-actions ">
                                            @if($cumphong->check == 0)
                                                <a href="{{url('cumphong/'.$cumphong->hotel_id.'/edit/'.$cumphong->id)}}" rel="tooltip" title="" class="btn btn-success btn-link btn-xs" data-original-title="Edit Profile">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{url('cumphong/'.$cumphong->hotel_id.'/delete/'.$cumphong->id)}}" rel="tooltip" title="" class="btn btn-danger btn-link btn-xs" data-original-title="Remove">
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