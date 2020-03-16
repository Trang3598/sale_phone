<!DOCTYPE html>
<html dir="ltr" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="{{asset('')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('admin/assets/images/favicon.png')}}">
    <title>Admin</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('admin/assets/libs/flot/css/float-chart.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('admin/dist/css/style.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/dist/css/image.css')}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
        }

        /*design button*/
        a.btn:hover {
            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
            -o-transform: scale(1.1);
        }

        a.btn {
            -webkit-transform: scale(0.8);
            -moz-transform: scale(0.8);
            -o-transform: scale(0.8);
            -webkit-transition-duration: 0.5s;
            -moz-transition-duration: 0.5s;
            -o-transition-duration: 0.5s;
        }

        .list-group {
            overflow-y: scroll;
            height: 300px;
        }
    </style>
</head>
<body>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<div id="main-wrapper">
    <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header" data-logobg="skin5">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                        class="ti-menu ti-close"></i></a>
                <a class="navbar-brand" href="index.html">
                    <!-- Logo icon -->
                    <b class="logo-icon p-l-10">
                        <img src="{{asset('admin/assets/images/logo-icon.png')}}" alt="homepage" class="light-logo"/>
                    </b>
                    <span class="logo-text">
                        <img src="{{asset('admin/assets/images/logo-text.png')}}" alt="homepage"
                             class="light-logo"/>
                    </span>
                </a>
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                   data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                   aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
            </div>
            @include('admin.layout.navbar')
        </nav>
    </header>
    @include('admin.layout.left_sidebar')
    <div class="page-wrapper">
        @yield('content')
        <footer class="footer text-center">
            All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
        </footer>
    </div>
</div>
<script src="{{asset('admin/assets/libs/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{asset('admin/assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{asset('admin/assets/extra-libs/sparkline/sparkline.js')}}"></script>
<!--Wave Effects -->
<script src="{{asset('admin/dist/js/waves.js')}}"></script>
<!--Menu sidebar -->
<script src="{{asset('admin/dist/js/sidebarmenu.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{asset('admin/dist/js/custom.min.js')}}"></script>
<!--This page JavaScript -->
<!-- Charts js Files -->
<script src="{{asset('admin/assets/libs/flot/excanvas.js')}}"></script>
<script src="{{asset('admin/assets/libs/flot/jquery.flot.js')}}"></script>
<script src="{{asset('admin/assets/libs/flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('admin/assets/libs/flot/jquery.flot.time.js')}}"></script>
<script src="{{asset('admin/assets/libs/flot/jquery.flot.stack.js')}}"></script>
<script src="{{asset('admin/assets/libs/flot/jquery.flot.crosshair.js')}}"></script>
<script src="{{asset('admin/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{asset('admin/dist/js/pages/chart/chart-page-init.js')}}"></script>
<script src="{{asset('js/admin/update_account.js')}}"></script>
<script src="{{asset('js/admin/order_detail.js')}}"></script>
</body>
</html>
@yield('form-add')
@yield('show-image')
