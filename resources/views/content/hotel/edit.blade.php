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
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="TypeValidation" class="form-horizontal" action="{{url('/hotel/edit/'.$hotel->id)}}" method="POST"  enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Sửa Thông tin</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Tên Khách sạn <star class="star">*</star></label>

                                <div class="col-sm-7">
                                    <div class="form-group ">
                                        <input id = "name" class="form-control" type="text" name="name" required="true" placeholder="Trường Lâm Hotel"
                                                value="{{$hotel->name}}"
                                        >
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Tittle</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input  id='tittle' class="form-control valid" type="text" name="tittle" placeholder="Chào mừng bạn đến với Khách Sạn" value="{{$hotel->tittle}}" >
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Logo (link) :</label>
                                <div class="col-sm-7 image">
                                    <div class="form-group">
                                        <input class="form-control valid" type="text"  hidden name="logo" id ="anh" placeholder="https://image.anninhthudo.vn/w700/uploaded/170/2018_05_18/logo.jpg" url="true" value="{{$hotel->logo}}">
                                        <img id='setanh'src="{{asset($hotel->logo)}}" width="70px" height="70px">
                                        <a class="btn btn-warning remove-image">
                                            <i class="fa fa-remove"></i> Xóa
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Tài Khoản  <star class="star">*</star> </label>

                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control valid" type="text" name="username" placeholder="truonglamhotel" value="{{$username}}"   disabled>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var url = location).attr('hostname');
            $('#anh').change(function () {
                console.log($('#anh').val());

                $('#setanh').attr("src",url+$('#anh').val());
            })
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function () {


            $('body').on('click', '.remove-image', function (e) {
               var html ="<div class=\"form-group\">\n" +
                   "                                        <input id=\"thumbnail1\" type=\"file\" name=\"logo\" value=\"\" class=\"form-control1\" id=\"focusedinput\" placeholder=\"Default Input\">\n" +
                   "                                    </div>";
                e.preventDefault();
                $(this).closest('.form-group').remove();

                $('.image').append(html);
            });


        });

    </script>
@endsection