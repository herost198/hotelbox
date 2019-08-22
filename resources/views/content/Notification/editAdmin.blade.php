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

                    <a href="{{url('notification/')}}">
                        <button type="" class="btn btn-info">
                            Trở về
                        </button>
                    </a>
                <form id="TypeValidation" class="form-horizontal" action="{{url('/notification/edit/')}}" method="POST"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Chỉnh sửa Thông báo</h4>
                        </div>

                        <div class="card-body ">

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
                                <label class="col-sm-2 col-form-label "> Khách sạn</label>
                                <div class="col-sm-2" style="    padding-top: 6px;">
                                    <div class="form-group">
                                        <select name="hotel_id" id="hotel_id"  >
                                            <option value="{{$hotels[0]->id}}"  selected>
                                                {{$hotels[0]->name}}
                                            </option>
                                            @for($i = 1 ; $i< count($hotels); $i++)

                                                <option value="{{$hotels[$i]->id}}" >
                                                    {{$hotels[$i]->name}}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label ">Cụm Phòng</label>

                                <div class="col-sm-4" style="    padding-top: 6px;">
                                    <div class="form-group">
                                        <select name="cumphong_id" id="cumphong_id">
                                            {{--     Code JQuery Line  112 - 139  --}}
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label "> Phòng</label>

                                <div class="col-sm-4" style="    padding-top: 6px;">
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
            var check = $("#hotel_id option:selected").val();
            $.get("/ajax/cumphong/" + check,function(data){
                let x = '<option value="0" selected >Tất cả</option>';
                $("#cumphong_id").html(x+data);
            }).then(function () {
                var check1 = $("#cumphong_id option:selected").val();
                $.get("/ajax/phong/" + check1,function(data){
                    $("#phong_id").html(data);
                });
            });
            $("#hotel_id").change(function(event) {
                var hotel_id = $(this).val();
                $.get("/ajax/cumphong/" + hotel_id,function(data){
                    let x = '<option value="0" selected >Tất cả</option>';
                    $("#cumphong_id").html(x+data);
                }).then(function(){
                    var check1 = $("#cumphong_id option:selected").val();
                    $.get("/ajax/phong/" + check1,function(data){
                        $("#phong_id").html(data);
                    });
                });
            });
            $("#cumphong_id").change(function (event) {
                var cumphong_id = $(this).val();
                $.get("/ajax/phong/" + cumphong_id, function (data) {
                    let x = '<option value="0" selected >Tất cả</option>';

                    $("#phong_id").html(x+data);
                });
            });


        });
    </script>
@endsection