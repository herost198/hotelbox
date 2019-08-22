<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{--head--}}
@include('partials.head')

<body>
    <div class="wrapper">
        @include('partials.sidebar')
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg ">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
{{--                        <div class="navbar-minimize">--}}
{{--                            <button id="minimizeSidebar"--}}
{{--                                    class="btn btn-warning btn-fill btn-round btn-icon d-none d-lg-block">--}}
{{--                                <i class="fa fa-ellipsis-v visible-on-sidebar-regular"></i>--}}
{{--                                <i class="fa fa-navicon visible-on-sidebar-mini"></i>--}}
{{--                            </button>--}}
{{--                        </div>--}}
                        <?php
                            $user = \Illuminate\Support\Facades\Auth::guard('admin')->user();

                        ?>
                        <a class="navbar-brand" href="/"> <img src="{{asset('assets/img/hotelbox-logo.png')}}"  height="35px"> </a>
                    </div>
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                            aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                </div>
            </nav>
            <div class="content">
                @yield('content')
            </div>

        </div>
        @include('partials.footer')

    </div>
</body>
@include('partials.main-js')
</html>