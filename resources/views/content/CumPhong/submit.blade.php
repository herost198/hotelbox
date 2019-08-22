@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                        <br>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{$errors->first('error')}}
                    </div>
                @endif
                <?php
                    $value =  $_SERVER['REQUEST_URI'];
                    $arr = explode('/',$value);
                    $result = $arr[count($arr)-2];
                    ?>
                <form id="TypeValidation" class="form-horizontal" action="{{url('/cumphong/'.$result.'/create/')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Thêm Mới Cụm Phòng</h4>
                        </div>

                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Tên Cụm Phòng
                                    <star class="star">*</star>
                                </label>

                                <div class="col-sm-7">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="text" name="name" required="true"
                                               placeholder="Cụm Vila" value="{{old('name')}}" autofocus
                                        >
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