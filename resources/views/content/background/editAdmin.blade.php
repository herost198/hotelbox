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
                    <?php
                    $user =Auth::guard('admin')->user();

                    ?>
                <form id="TypeValidation" class="form-horizontal" action="{{url('/background/edit/'.$background->id)}}" method="POST"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title text-center">Chỉnh Sửa Ảnh Nền</h4>
                        </div>
                        <div class="card-body ">
                            @if($user->permission === 'admin')
                            <div class="row">
                                <label class="col-sm-2 col-form-label"> Khách sạn
                                </label>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select name="hotel_id" id="hotel_id" disabled >
                                            <option value="{{$background->id}}"   selected>
                                                {{$background->tenKS}}
                                            </option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                            @endif
                            <?php
                                $images = $background->link ? json_decode($background->link) : array();
                                $i = 0;

                            ?>
                            @if($images != null)
                                @foreach($images as $image)
                                    <?php $i++ ?>
                                    <div class="form-group row lfm-btn">
                                        <label  class="col-sm-2 " style="line-height: 100px;">Ảnh {{ $i }}</label>
                                        <div class="col-sm-10">
                                            <input id="thumbnail{{$i}}" type="text" name="images1[]" hidden value="{{$image}}" class="form-control1" id="focusedinput" >
                                            <img id="holder{{ $i }}" src="{{ url($image) }}" style="margin-top:15px;max-height:100px;height: 100px; width: 150px">

                                            <a class="btn btn-warning remove-image">
                                                <i class="fa fa-remove"></i> Xóa
                                            </a>
    {{--                                                    <input id="thumbnail{{ $i }}" class="form-control" type="text" name="images[]" value="{{ $image }}" placeholder="Default Input">--}}

                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="row form-group">
                                <button type="button" class="btn btn-primary btn-lg btn-block" id="plus-image">
                                        <i class="fa fa-plus"></i> Thêm Ảnh
                                </button>
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
    <script type="text/javascript">
        $(document).ready(function () {
            // $('.lfm-btn').filemanager('image', {'prefix':'http://localhost/lar.tuto/authen/public/laravel-filemanager'});
            $('#plus-image').on('click', function (e) {
                e.preventDefault();
                var lfm_count = parseInt($('.lfm-btn').length);

                var next = lfm_count+1;
                var html = '';
                for(var i = 0; i < 1000; i++){

                    if ($('#lfm'+next).length < 1) {
                        // console.log(next);
                        html += '<div class=" row form-group lfm-btn">\n' +
                            '                    <label  class="col-sm-2 text-center ">Ảnh'+next+'</label>\n' +
                            '                    <div class="col-sm-8">\n' +
                            '                        <input id="thumbnail'+next+'" type="file" name="images[]" value="" class="form-control1" id="focusedinput" placeholder="Default Input">\n' +
                            '                            <a class="btn btn-warning remove-image">\n' +
                            '                           <i class="fa fa-remove"></i> Xóa\n' +
                            '                         </a>\n' +
                            '                    </div>\n' +
                            '                </div>';


                        break;
                    } else {
                        next++;
                    }

                }

                var box = $(this).closest('.form-group');
                $( html ).insertBefore( box );

            });

            $('body').on('click', '.remove-image', function (e) {
                e.preventDefault();
                $(this).closest('.form-group').remove();
            });


        });

    </script>
@endsection