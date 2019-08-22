@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                @if(session('success'))
                    <div class="alert alert-success">
                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                            <i class="nc-icon nc-simple-remove"></i>
                        </button>
                        <span>
                            {{session('success')}}            </span>
                    </div>

                @endif
                @if ($errors->any())

                    <div class="alert alert-danger">
                        {{$errors->first('error')}}
                    </div>
                @endif

                <form id="TypeValidation" class="form-horizontal" action="{{url('/phong/create/')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Thêm Mới Phòng</h4>
                        </div>

                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Tên Phòng
                                    <star class="star">*</star>
                                </label>

                                <div class="col-sm-8">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="text" name="name" required="true"
                                               placeholder="203" autofocus
                                        >
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label ">Khách sạn</label>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select name="hotel_id" id="hotel_id" >
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

                                <div class="col-sm-2">
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
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function(){
            var check = $("#hotel_id option:selected").val();
            $.get("/ajax/cumphong/" + check,function(data){
                $("#cumphong_id").html(data);
            });
            $("#hotel_id").change(function(event) {
                var hotel_id = $(this).val();
                $.get("/ajax/cumphong/" + hotel_id,function(data){
                    $("#cumphong_id").html(data);
                });
            });



        });
    </script>
@endsection