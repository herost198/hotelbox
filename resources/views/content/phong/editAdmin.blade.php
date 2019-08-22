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
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="TypeValidation" class="form-horizontal" action="{{url('/phong/edit/'.$phong->id)}}" method="POST">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Sửa Phòng</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label text-center">Tên Phòng
                                    <star class="star">*</star>
                                </label>

                                <div class="col-sm-7">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="text" name="name" required="true"
                                               placeholder="Cụm Vila" value="{{$phong->name}}"
                                        >
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label text-center">Khách sạn</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select name="hotel_id" id="hotel_id" disabled >
                                            <option value="{{$hotel->id}}"  selected>
                                                {{$hotel->name}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label ">Cụm Phòng</label>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <select name="cumphong_id" id="cumphong_id">
                                            {{--     Code JQuery Line  112 - 139  --}}
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>


    <script>
        $(document).ready(function(){
            var check = $("#hotel_id option:selected").val();

            $.get("/ajax/cumphong/" + check +"/{{$cumphong->id}}" ,function(data){
                $("#cumphong_id").html(data);
            });

            // $("#cumphong_id").change(function (event) {
            //     var cumphong_id = $(this).val();
            //     $.get("/ajax/phong/" + cumphong_id, function (data) {
            //         $("#phong_id").html(data);
            //     });
            // });


        });
    </script>
@endsection