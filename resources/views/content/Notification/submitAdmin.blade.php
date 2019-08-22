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
                <form id="TypeValidation" class="form-horizontal" action="{{url('/notification/'.$result.'/create/')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Thêm Mới Thông báo</h4>
                        </div>

                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Tên
                                    <star class="star">*</star>
                                </label>

                                <div class="col-sm-7">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="text" name="name" required="true"
                                                autofocus
                                        >
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Tittle
                                    <star class="star">*</star>
                                </label>

                                <div class="col-sm-7">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="text" name="tittle" required="true"

                                        >
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Link
                                    <star class="star">*</star>
                                </label>

                                <div class="col-sm-7">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="text" name="link" required="true"
                                               placeholder="Cụm Vila"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Cụm Phòng
                                    <star class="star">*</star>
                                </label>
                                    <div class="col-sm-3">
                                        <select  name="cumphong_id" id="cumphong_id">
                                            <option value="0" selected >Tất cả</option>
                                            @foreach($cumphongs as $cumphong)
                                                <option value="{{$cumphong->id}}">{{$cumphong->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                <label class="col-sm-2 col-form-label "> Phòng</label>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select name="phong_id" id="phong_id">
                                            {{--           Code JQuery Line  112 - 139  --}}
                                        </select>
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
    <script>
        $(document).ready(function(){

                let check1 = $("#cumphong_id option:selected").val();
                if(check1 != 0 ){
                    $.get("/ajax/phong/" + check1,function(data){
                        $("#phong_id").html(data);
                    });
                }

            $("#cumphong_id").change(function (event) {
                let cumphong_id = $(this).val();
                if(cumphong_id != 0 ) {
                    $.get("/ajax/phong/" + cumphong_id, function (data) {
                        let x = '<option value="0" selected >Tất cả</option>';
                        $("#phong_id").html(x + data);
                    });
                }else{
                    $("#phong_id").html(' ');
                }
            });


        });
    </script>
@endsection