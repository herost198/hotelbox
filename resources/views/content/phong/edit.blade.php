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
                <?php
                    $value =  $_SERVER['REQUEST_URI'];
                    $arr = explode('/',$value);
                    $id = $arr[count($arr)-3];
                ?>
                <form id="TypeValidation" class="form-horizontal" action="{{url('/phong/'.$id.'/edit/'.$phong->id)}}" method="POST">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Sửa Phòng</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Tên Phòng
                                    <star class="star">*</star>
                                </label>

                                <div class="col-sm-9">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="text" name="name" required="true"
                                               placeholder="Cụm Vila" value="{{$phong->name}}"
                                        >
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Cụm Phòng
                                    <star class="star">*</star>
                                </label>
                                <div class="col-sm-9" style="line-height: 35px;">
                                    <select  name="cumphong_id">
                                        @foreach($cumphongs as $cumphong)

                                            <option value="{{$cumphong->id}}"
                                            <?php
                                                if($cumphong->id == $phong->cumphong_id)echo 'selected';
                                            ?>
                                            >{{$cumphong->name}}</option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Danh Sách Box(MAC):
                                </label>

                                <div class="col-sm-9 ">

                                    @foreach($boxs as $box)
                                        <div class="row form-group ">
                                            <label class="col-sm-10 col-form-label">{{$box->mac}}</label>
                                            <input value="{{$box->id}}" hidden  name="box[]" >
                                            <a class="btn btn-warning remove-image col-sm-2">
                                                <i class="fa fa-remove"></i> Gỡ
                                            </a>
                                        </div>

                                    @endforeach
                                    <div class="row form-group">
                                        <button type="button" class="btn btn-primary col-sm-12 " id="plus-image">
                                            <i class="fa fa-plus"></i> Thêm Box
                                        </button>
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
        $(document).ready(function () {
            var test ;
            $.get("/ajax/box/{{$phongMD->id}}" ,function(data){
                test = data;
            }).then(function(){
            });
            $('#plus-image').on('click', function (e) {
                e.preventDefault();

                var lfm_count = parseInt($('.lfm-btn').length);

                var next = lfm_count+1;
                var html = '';
                for(var i = 0; i < 1000; i++){

                    if ($('#lfm'+next).length < 1) {
                        // console.log(next);
                        html +=
                            // '<div class="row form-group lfm-btn ">\n' +
                            // '                                <select class="col-sm-10 " name="box1[]" id="cumphong_id'+next+'">\n' +
                            // '                                </select>\n' +
                            // '                                <a class="btn btn-warning remove-image col-sm-2">\n' +
                            // '                                <i class="fa fa-remove"></i> Xóa\n' +
                            // '                                </a>\n' +
                            // '                            </div>';

                        '<div class="row form-group lfm-btn ">\n' +
                        '                            <input class="col-sm-10 " name="box1[]"  list="cumphong_id'+next+'">\n' +
                        '                           <datalist id="cumphong_id'+next+'"  >\n' +
                        '                           </datalist >\n' +
                        '                            <a class="btn btn-warning remove-image col-sm-2">\n' +
                        '                            <i class="fa fa-remove"></i> Gỡ\n' +
                        '                            </a>\n' +
                        '                      </div>';
                        break;
                    } else {
                        next++;
                    }

                }
                var box = $(this).closest('.form-group');
                $( html ).insertBefore( box );
                $("#cumphong_id"+next).html(test);
            });
        });


        $('body').on('click', '.remove-image', function (e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();

        });
        $("input").click(function(){
            $(this).next().show();
            $(this).next().hide();
        });
    </script>
@endsection