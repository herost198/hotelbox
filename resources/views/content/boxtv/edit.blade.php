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

                <form id="TypeValidation" class="form-horizontal" action="{{url('/box/'.$hotel->id.'/edit/'.$box->id)}}" method="POST">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Sửa BoxTv</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">

                                <label class="col-sm-2 col-form-label">Serial
                                    <star class="star">*</star>
                                </label>
                                <div class="col-sm-2">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="text" name="serial" required="true" value="{{$box->serial}}"
                                               disabled>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Mac
                                    <star class="star">*</star>
                                </label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input id='tittle' class="form-control valid" type="text" name="mac" value="{{$box->mac}}" disabled>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <label class="col-sm-2 col-form-label ">Khách sạn</label>
                                <div class="col-sm-2" style="margin-top: 6px">
                                    <div class="form-group">
                                        <select name="hotel_id" id="hotel_id" disabled >
                                            <option value="{{$hotel->id}}"  selected>
                                                {{$hotel->name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label ">Cụm Phòng</label>

                                <div class="col-sm-4" style="margin-top: 6px">
                                    <div class="form-group" >
                                        <select name="cumphong_id" id="cumphong_id">
                                            {{--     Code JQuery Line  112 - 139  --}}
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label "> Phòng</label>

                                <div class="col-sm-4" style="margin-top: 6px">
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

            $.get("/ajax/cumphong/" + check +"/{{$cumphong->id}}" ,function(data){
                $("#cumphong_id").html(data);
            }).then(function () {
                var check1 = $("#cumphong_id option:selected").val();
                $.get("/ajax/phong/" + check1 +"/{{$phong->id}}"  ,function(data){
                    $("#phong_id").html(data);
                });
            });

            $("#cumphong_id").change(function (event) {
                var cumphong_id = $(this).val();
                $.get("/ajax/phong/" + cumphong_id, function (data) {
                    $("#phong_id").html(data);
                });
            });


        });
    </script>
@endsection