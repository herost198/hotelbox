@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="TypeValidation" class="form-horizontal" action="{{url('/background/create')}}" method="POST"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Thêm Mới Ảnh nền</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label"> Khách sạn
                                </label>

                                <div class="col-sm-2">
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

                            </div>


                            <div class="row form-group">

                                <label class="col-sm-2  ">Ảnh</label>
                                <div class="col-sm-8">

                                    <input id="thumbnail1" type="file" name="images[]" value="{{ old('images') }}" class="form-control1" id="focusedinput" placeholder="Default Input">
                                    <a class="btn btn-warning remove-image">
                                        <i class="fa fa-remove"></i> Xóa
                                    </a>
{{--                                    <img id="holder1" style="margin-top:15px;max-height:100px;">--}}

                                </div>
                            </div>

                            <div class="row form-group">
                                <label  class="col-sm-2 "></label>
                                <div class="col-sm-8">
                                    <a id="plus-image" class="btn btn-success">
                                        <i class="fa fa-plus"></i> Thêm Ảnh
                                    </a></div>
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

                        html += '<div class=" row form-group">\n' +
                            '                    <label  class="col-sm-2 ">Images</label>\n' +
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