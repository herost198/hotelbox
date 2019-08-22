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
                <form id="TypeValidation" class="form-horizontal" action="{{url('/logo/edit/'.$logo->id)}}" method="POST"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header  ">
                            <h4 class="card-title  text-center">LOGO</h4>
                        </div>
                        <div class="card-body ">

                                    <div class=" row lfm-btn">

                                        <div class="col-sm-12 form-group text-center">
                                            <input id="thumbnail" type="text" name="logo" hidden value="{{$logo->logo}}" class="form-control1" id="focusedinput" >
                                            <img id="holder" src="{{ url($logo->logo) }}"
                                                 style="margin-top:15px;max-height:100px;height: 100px; width: 150px"
                                            >

                                            <a class="btn btn-warning remove-image">
                                                <i class="fa fa-remove"></i> Xóa
                                            </a>

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
    <script type="text/javascript">
        $(document).ready(function () {

            $('body').on('click', '.remove-image', function (e) {
                e.preventDefault();
                $(this).closest('.form-group').remove();
                var html =
                    '                    <div class="col-sm-12 form-group text-center">\n' +
                    '                        <input id="thumbnail" type="file" name="logo1" value="" class="form-control1" id="focusedinput" placeholder="Default Input">\n' +
                    '                            <a class="btn btn-warning remove-image">\n' +
                    '                           <i class="fa fa-remove"></i> Xóa\n' +
                    '                         </a>\n' +
                    '                    </div>\n' +
                    '                </div>';
                console.log(html);
                $(".lfm-btn").append(html);
            });


        });

    </script>
@endsection