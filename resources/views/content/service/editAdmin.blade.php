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

                <form id="TypeValidation" class="form-horizontal" action="{{url('/service/edit/'.$service->id)}}" method="POST"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Chỉnh sửa Dịch vụ</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label"> Khách sạn
                                </label>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select name="hotel_id" id="hotel_id" disabled >
                                            <option value="{{$hotel->id}}"   selected>
                                                {{$hotel->name}}
                                            </option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">
                                    <span>
                                    Lựa chọn Icon (
                                    <a href="https://fontawesome.com/icons?d=gallery" target="_blank">Tại đây</a>
                                         )</span>
                                </label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input id='tittle' class="form-control valid" type="text" name="icon" value="{{$service->icon}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">
                                    <span>
                                    Lựa chọn Màu Sắc Icon (
                                    <a href="https://www.google.com.vn/search?q=color+picker" target="_blank">Tại đây</a>
                                         )</span>
                                </label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input id='tittle' class="form-control valid" value="{{$service->color_icon}}" type="text" name="color_icon">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">
                                    <span>
                                   Tittle
                                         </span>
                                </label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input id='tittle' class="form-control valid" type="text" name="tittle" value="{{$service->tittle}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">
                                    <span>
                                        Link
                                    </span>
                                </label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <textarea name="link" id="txtarea1" cols="50" rows="30" class="form-control1 mytinymce">{{$service->link}}</textarea>
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
    </div>
@endsection