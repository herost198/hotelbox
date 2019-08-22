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
                <?php
                    $user  = \Illuminate\Support\Facades\Auth::guard('admin')->user();
                ?>
                <form id="TypeValidation" class="form-horizontal" action="{{url('/changePassword/'.$user->hotel_id)}}" method="POST">
                    {{ csrf_field() }}
                    <div class="card ">
                        <div class="card-header ">
                            <h4 class="card-title">Thay đổi Password</h4>
                        </div>

                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Mật khẩu cũ:
                                    <star class="star">*</star>
                                </label>

                                <div class="col-sm-7">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="password" name="password" required="true"
                                              autofocus
                                        >
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">Mật khẩu mới:
                                    <star class="star">*</star>
                                </label>

                                <div class="col-sm-7">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="password" name="newpassword" required="true"
                                        >
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Xác nhân mật khẩu mới:
                                    <star class="star">*</star>
                                </label>

                                <div class="col-sm-7">
                                    <div class="form-group ">
                                        <input id="name" class="form-control" type="password" name="password_confirm" required="true"
                                        >
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
@endsection