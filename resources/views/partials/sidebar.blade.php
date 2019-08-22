<div class="sidebar" data-color="orange" data-image="assets/img/sidebar-5.jpg">
    <?php
    $user = Auth::guard('admin')->user();
            $hotel =  \App\Model\InformationModel::find($user->hotel_id);

    ?>
    <div class="sidebar-wrapper">
        <div class="user">

            <div class="photo">
                @if($user->permission == 'user')
                    <img src="{{url($hotel->logo)}}"  height="46px">
                @else
                    <img src="{{asset('assets/img/truonglam-logo.jpg')}}"  height="46px">
                @endif
            </div>
            <div class="info ">
                <a href="{{route('home')}}" >
                            <span>
                                @if($user->permission === 'user')
                                    {{$hotel->name}}
                                @else
                                    {{'Admin'}}
                                @endif
                            </span>
                </a>
            </div>
        </div>

        <ul class="nav nav-mobile-menu"></ul><ul class="nav">
            <li class="nav-item ">
                @if($user->permission == 'user')
                    <a class="nav-link" href="{{url('/box/'.$user->hotel_id)}}">
                        <i class="fab fa-xbox"></i>

                        <span class="sidebar-normal"> Box </span>
                    </a>

                @endif

            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" href="#componentsExamples" aria-expanded="false">
{{--                    <i class="nc-icon nc-bell-55"></i>--}}
                    <i class="fas fa-bell"></i>
                    <p>
                        Thông báo
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="componentsExamples" style="">
                    <ul class="nav">
                        @if($user->permission == 'user')
                             <li class="nav-item ">

                                <a class="nav-link" href="{{url('/notification/'.$user->hotel_id)}}">
                                    <span class="sidebar-normal"> Thông báo</span>
                                </a>
                             </li>
                            <li class="nav-item ">
                                    <a class="nav-link" href="{{url('/popup/edit/'.$user->hotel_id)}}">
                                        <span class="sidebar-normal"> Pop Up</span>
                                    </a>
                            </li>
                        @else
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('/notification/')}}">
                                    <span class="sidebar-normal"> Thông báo</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('/popup/')}}">
                                    <span class="sidebar-normal"> Pop Up</span>
                                </a>
                            </li>
                        @endif



                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-toggle="collapse" href="#formsExamples" aria-expanded="false">
{{--                    <i class="nc-icon nc-notes"></i>--}}
                    <i class="fas fa-home"></i>
                    <p>
                        Quản lý phòng
                        <b class="caret"></b>
                    </p>
                </a>

                <div class="collapse" id="formsExamples" style="">
                    <ul class="nav">
                        <li class="nav-item ">
{{--                            <a class="nav-link" href="">--}}
{{--                                <span class="sidebar-normal">Phòng</span>--}}
{{--                            </a>--}}
                            @if($user->permission == 'user')
                                <a class="nav-link" href="{{url('/phong/'.$user->hotel_id)}}">
                                    <span class="sidebar-normal"> Phòng</span>
                                </a>
                            @else
                                <a class="nav-link" href="{{url('/phong/')}}">
                                    <span class="sidebar-normal"> Phòng</span>
                                </a>
                            @endif
                        </li>

                        <li class="nav-item ">

                            @if($user->permission == 'user')
                                <a class="nav-link" href="{{url('/cumphong/'.$user->hotel_id)}}">
                                    <span class="sidebar-normal">Cụm Phòng</span>
                                </a>
                            @else
                                <a class="nav-link" href="{{url('/cumphong/')}}">
                                    <span class="sidebar-normal">Cụm Phòng</span>
                                </a>
                            @endif
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#tablesExamples">
{{--                    <i class="nc-icon nc-paper-2"></i>--}}
                    <i class="fas fa-hotel"></i>
                    <p>
                        Thông tin Khách sạn
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="tablesExamples">
                    <ul class="nav">
                        @if($user->permission == 'user')
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('/background/edit/'.$user->hotel_id)}}">
                                    <span class="sidebar-normal"> Ảnh Nền</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('/service/'.$user->hotel_id)}}">
                                    <span class="sidebar-normal"> Dịch vụ</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('/logo/edit/'.$user->hotel_id)}}">
                                    <span class="sidebar-normal">Logo</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('/changePassword/'.$user->hotel_id)}}">
                                    <span class="sidebar-normal"> Đổi Mật Khẩu</span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('/service')}}">
                                    <span class="sidebar-normal"> Dịch vụ</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{url('/background')}}">
                                    <span class="sidebar-normal"> Ảnh Nền</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
            @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->permission == 'admin')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#mapsExamples" aria-expanded="false">
{{--                    <i class="nc-icon nc-pin-3"></i>--}}
                    <i class="fas fa-user-shield"></i>
                    <p>
                        Admin
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="mapsExamples" style="">
                    <ul class="nav">


                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/hotel')}}">
                                <span class="sidebar-normal">Quản lý Khách sạn</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/box')}}">
                                <span class="sidebar-normal">Box TV</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            @endif
            <li class="nav-item ">


                <a class="nav-link" href="{{route('auth.logout')}}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>

                <form id="logout-form" action="{{route('auth.logout')}}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
    <div class="sidebar-background" style="background-image: url({{asset('assets/img/sidebar-5.jpg')}}) "></div></div>