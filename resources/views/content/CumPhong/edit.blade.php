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

                <form id="TypeValidation" class="form-horizontal"
                      action="{{url('/cumphong/'.$cumphong->hotel_id.'/edit/'.$cumphong->id)}}" method="POST">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Sửa Cụm Phòng</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Tên Cụm Phòng
                                    <star class="star">*</star>
                                </label>

                                <div class="col-sm-9">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="text" name="name" required="true"
                                               placeholder="Cụm Vila" value="{{$cumphong->name}}"
                                        >
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Danh Sách Phòng:
                                </label>

                                <div class="col-sm-9 ">

                                        @foreach($phongs as $phong)
                                            <div class="row form-group ">
                                                <label class="col-sm-10 col-form-label">{{$phong->name}}</label>
                                                <input value="{{$phong->id}}" hidden  name="phong[]" placeholder="Tên Phòng">
                                                <a class="btn btn-warning remove-image col-sm-2">
                                                    <i class="fa fa-remove"></i> Gỡ
                                                </a>
                                            </div>

                                        @endforeach
{{--                                            <select name="cumphong_id" id="cumphong_id">--}}
{{--                                            </select>--}}
                                        <div class="row form-group">
                                            <button type="button" class="btn btn-primary col-sm-12 " id="plus-image">
                                                <i class="fa fa-plus"></i> Thêm phòng
                                            </button>
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
        $(document).ready(function () {
            var test ;
            $.get("/ajax/phong1/{{$cumphongMD}}" ,function(data){
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
                        html +=
                            // ' <div class="row form-group lfm-btn ">\n' +
                            // '                                <input class="col-sm-10 "  name="phong1[]" list="cumphong_id\'+next+\'">\n' +
                            // '                                 <datalist   id="cumphong_id\'+next+\'">\n' +
                            // '                                    </select>\n' +
                            // '                                  </datalist >\n' +
                            // '                                <a class="btn btn-warning remove-image col-sm-2">\n' +
                            // '                                <i class="fa fa-remove"></i> Xóa\n' +
                            // '                                </a>\n' +
                            // '                          </div>';

                            '<div class="row form-group lfm-btn ">\n' +
                            '                            <input class="col-sm-10 " name="phong1[]"  list="cumphong_id'+next+'">\n' +
                            '                           <datalist id="cumphong_id'+next+'"  >\n' +
                            '                           </datalist >\n' +
                            '                            <a class="btn btn-warning remove-image col-sm-2">\n' +
                            '                            <i class="fa fa-remove"></i> Gỡ\n' +
                            '                            </a>\n' +
                            '                      </div>';



                        // <div class="row form-group lfm-btn ">
                        //     <input class="col-sm-10 "  name="phong1[]" list="cumphong_id'+next+'">
                        //          <datalist   id="cumphong_id'+next+'">
                        //           </datalist >
                        //         <a class="btn btn-warning remove-image col-sm-2">
                        //         <i class="fa fa-remove"></i> Xóa
                        //         </a>
                        //
                        //   </div>

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