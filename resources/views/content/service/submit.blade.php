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
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                                <i class="nc-icon nc-simple-remove"></i>
                            </button>
                            <span>
                            <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                             </ul>
                        </span>
                        </div>
                @endif

                <form id="TypeValidation" class="form-horizontal" action="{{url('/service/'.$hotel_id.'/create')}}" method="POST"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Thêm Mới Dịch vụ</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">
                                    <span>
                                    Lựa chọn Icon (
                                    <a href="https://fontawesome.com/icons?d=gallery" target="_blank">Tại đây</a>
                                         )</span>
                                </label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input id='tittle' class="form-control valid" type="text" name="icon">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">
                                    <span>
                                    Lựa chọn Màu Sắc Icon (
                                    <a href="https://www.google.com.vn/search?q=color+picker" target="_blank">Tại đây</a>
                                         )</span>
                                </label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input id='tittle' class="form-control valid" type="text" name="color_icon">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">
                                    <span>
                                   Tittle
                                         </span>
                                </label>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input id='tittle' class="form-control valid" type="text" name="tittle">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">
                                    <span>
                                        Link
                                    </span>
                                </label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <textarea name="link" id="txtarea1" cols="50" rows="10" class="form-control1 mytinymce">

                                        </textarea>
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
        $(document ).ready(function(){
            var template = " <div class=\"main\">\n" +
                "                                                    <div class=\"title\">\n" +
                "                                                    <h1>PH&Ograve;NG TẬP GYM ĐẲNG CẤP</h1>\n" +
                "                                                    </div>\n" +
                "                                                    <table>\n" +
                "                                                    <tbody>\n" +
                "                                                    <tr>\n" +
                "                                                    <th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\"><img src=\"http://localhost:8000/photos/1/7.png\" width=\"400\" height=\"300\" /></th>\n" +
                "                                                    <th class=\"intro\">Với lối b&agrave;i tr&iacute; nhẹ nh&agrave;ng lấy hoa sen l&agrave;m chủ đạo, kết hợp kiến tr&uacute;c hiện đại với phong c&aacute;ch cổ điển đậm chất thiền nhưng kh&ocirc;ng k&eacute;m phần sang trọng, ấm c&uacute;ng &ndash; Sen Spa tựa như một resort y&ecirc;n b&igrave;nh v&agrave; mộc mạc giữa S&agrave;i G&ograve;n n&aacute;o nhiệt, hứa hẹn sẽ mang đến cho bạn những giờ ph&uacute;t thư gi&atilde;n tuyệt vời để chăm s&oacute;c sức khỏe v&agrave; l&agrave;n da của bạn.</th>\n" +
                "                                                    </tr>\n" +
                "                                                    </tbody>\n" +
                "                                                    </table>\n" +
                "                                                    <table style=\"margin-top: 20px;\">\n" +
                "                                                    <tbody>\n" +
                "                                                    <tr>\n" +
                "                                                    <th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\n" +
                "                                                    <th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\n" +
                "                                                    <th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\n" +
                "                                                    <th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\n" +
                "                                                    </tr>\n" +
                "                                                    <tr>\n" +
                "                                                    <th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\">Oasis (1.5h) <br />1.100.000đ</th>\n" +
                "                                                    <th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\">Oasis (1.5h) <br />1.100.000đ</th>\n" +
                "                                                    <th>Oasis (1.5h) <br />1.100.000đ</th>\n" +
                "                                                    <th>Oasis (1.5h) <br />1.100.000đ</th>\n" +
                "                                                    </tr>\n" +
                "                                                    </tbody>\n" +
                "                                                    </table>\n" +
                "                                                    </div>";
            $('#txtarea1').val(template);
        });
    </script>
@endsection