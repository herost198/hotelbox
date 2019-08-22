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

                <form id="TypeValidation" class="form-horizontal" action="{{url('/hotel/create')}}" method="POST"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Thêm Mới Khách Sạn</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Tên Khách sạn <star class="star">*</star></label>

                                <div class="col-sm-7">
                                    <div class="form-group ">
                                        <input id = "name" class="form-control" type="text" name="name" required="true" placeholder="Trường Lâm Hotel"
                                          autofocus     >
                                        </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Tittle</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input  id='tittle' class="form-control valid" type="text" name="tittle" placeholder="Chào mừng bạn đến với Khách Sạn" >
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Logo (link) :</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input id="thumbnail1" type="file" name="logo" value="{{ old('logo') }}" class="form-control1" id="focusedinput" placeholder="Default Input">
{{--                                        <input class="form-control valid" type="text" name="logo" placeholder="https://image.anninhthudo.vn/w700/uploaded/170/2018_05_18/logo.jpg" url="true">--}}
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Tài Khoản  <star class="star">*</star> </label>

                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control valid" type="text" name="username" placeholder="truonglamhotel" >
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

@endsection