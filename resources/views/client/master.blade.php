<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('admin/assets/images/favicon.png')}}">
    <title>Sky Shop - @yield('title')</title>
    <link rel="stylesheet" href="{{asset('client/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('client/css/home.css')}}">
    <script type="text/javascript" src="{{asset('client/js/jquery-3.2.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script type="text/javascript" src="{{asset('client/js/bootstrap.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript">
        $(function () {
            // var pull = $('#pull');
            menu = $('nav ul');
            menuHeight = menu.height();

            $(pull).on('click', function (e) {
                e.preventDefault();
                menu.slideToggle();
            });
        });

        $(window).resize(function () {
            var w = $(window).width();
            if (w > 320 && menu.is(':hidden')) {
                menu.removeAttr('style');
            }
        });
    </script>
    <style>
        .modal-backdrop {
            z-index: -1;
        }
    </style>
</head>
<body>
<!-- header -->
<header id="header">
    <div class="container">
        <div class="row">
            <div id="logo" class="col-md-3 col-sm-12 col-xs-12">
                <h1>
                    <a href="#"><img src="{{asset('client/img/home/logo.png')}}"></a>
                    <nav><a id="pull" class="btn btn-danger" href="#">
                            <i class="fa fa-bars"></i>
                        </a></nav>
                </h1>
            </div>
            <div id="search" class="col-md-7 col-sm-12 col-xs-12">
                <input type="text" name="text" value="Nhập từ khóa ...">
                <input type="submit" name="submit" value="Tìm Kiếm">
            </div>
            <div id="cart" class="col-md-2 col-sm-12 col-xs-12">
                <a class="display" href="#">Giỏ hàng</a>
                <a href="#">
                    @if(Session::has('cart')){{Session('cart')->totalQty}}
                    @else
                       0
                    @endif
                </a>
            </div>
        </div>
    </div>
</header><!-- /header -->
<!-- endheader -->

<!-- main -->
<section id="body">
    <div class="container">
        <div class="row">
            <div id="sidebar" class="col-md-3">
                <nav id="menu">
                    <ul>
                        <li class="menu-item">danh mục sản phẩm</li>
                        @foreach($categories as $category)
                            <li class="menu-item" id="product_{{$category->id}}"><a
                                    href="{{route('category.product',$category->id)}}" title=""
                                    data-id="{{$category->id}}">{{$category->category_name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <div id="banner-l" class="text-center">
                    <div class="banner-l-item">
                        <a href="#"><img src="{{asset('client/img/home/banner-l-1.png')}}" alt="" class="img-thumbnail"></a>
                    </div>
                    <div class="banner-l-item">
                        <a href="#"><img src="{{asset('client/img/home/banner-l-2.png')}}" alt="" class="img-thumbnail"></a>
                    </div>
                    <div class="banner-l-item">
                        <a href="#"><img src="{{asset('client/img/home/banner-l-3.png')}}" alt="" class="img-thumbnail"></a>
                    </div>
                    <div class="banner-l-item">
                        <a href="#"><img src="{{asset('client/img/home/banner-l-4.png')}}" alt="" class="img-thumbnail"></a>
                    </div>
                    <div class="banner-l-item">
                        <a href="#"><img src="{{asset('client/img/home/banner-l-5.png')}}" alt="" class="img-thumbnail"></a>
                    </div>
                    <div class="banner-l-item">
                        <a href="#"><img src="{{asset('client/img/home/banner-l-6.png')}}" alt="" class="img-thumbnail"></a>
                    </div>
                    <div class="banner-l-item">
                        <a href="#"><img src="{{asset('client/img/home/banner-l-7.png')}}" alt="" class="img-thumbnail"></a>
                    </div>
                </div>
            </div>
            <div id="main" class="col-md-9">
                <!-- main -->
                <!-- phan slide la cac hieu ung chuyen dong su dung jquey -->
                <div id="slider">
                    <div id="demo" class="carousel slide" data-ride="carousel">

                        <!-- Indicators -->
                        <ul class="carousel-indicators">
                            <li data-target="#demo" data-slide-to="0" class="active"></li>
                            <li data-target="#demo" data-slide-to="1"></li>
                            <li data-target="#demo" data-slide-to="2"></li>
                        </ul>

                        <!-- The slideshow -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{asset('client/img/home/slide-1.png')}}" alt="Los Angeles">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('client/img/home/slide-2.png')}}" alt="Chicago">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('client/img/home/slide-3.png')}}" alt="New York">
                            </div>
                        </div>

                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#demo" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#demo" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                </div>

                <div id="banner-t" class="text-center">
                    <div class="row">
                        <div class="banner-t-item col-md-6 col-sm-12 col-xs-12">
                            <a href="#"><img src="{{asset('client/img/home/banner-t-1.png')}}" alt=""
                                             class="img-thumbnail"></a>
                        </div>
                        <div class="banner-t-item col-md-6 col-sm-12 col-xs-12">
                            <a href="#"><img src="{{asset('client/img/home/banner-t-1.png')}}" alt=""
                                             class="img-thumbnail"></a>
                        </div>
                    </div>
                </div>
                @yield('main')
            </div>
        </div>
    </div>
</section>
<!-- endmain -->

<!-- footer -->
<footer id="footer-master">
    <div id="footer-t">
        <div class="container">
            <div class="row">
                <div id="logo-f" class="col-md-3 col-sm-12 col-xs-12 text-center">
                    <a href="#"><img src="{{asset('client/img/home/logo.png')}}"></a>
                </div>
                <div id="about" class="col-md-3 col-sm-12 col-xs-12">
                    <h3>About us</h3>
                    <p class="text-justify">Sky Shop thành lập năm 2020. Chúng tôi luôn đem đến chất lượng dịch vụ tốt
                        nhất và những chính sách ưu đãi cho quý khách</p>
                </div>
                <div id="hotline" class="col-md-3 col-sm-12 col-xs-12">
                    <h3>Hotline</h3>
                    <p>Phone Sale: (+84) 0357 589 900</p>
                    <p>Email: trangntk98@gmail.com</p>
                </div>
                <div id="contact" class="col-md-3 col-sm-12 col-xs-12">
                    <h3>Contact Us</h3>
                    <p>Address 1: 38 Phùng Khoang - Thanh Xuân - Hà Nội</p>
                    <p>Address 2: Thanh Phong - Thanh Liêm - Hà Nam</p>
                </div>
            </div>
        </div>
        <div id="footer-b">
            <div class="container">
                <div class="row">
                    <div id="footer-b-l" class="col-md-6 col-sm-12 col-xs-12 text-center">
                        <p>Đồ chơi công nghệ Sky Shop - www.skyshop.com.vn</p>
                    </div>
                    <div id="footer-b-r" class="col-md-6 col-sm-12 col-xs-12 text-center">
                        <p>© 2020 Sky Shop. All Rights Reserved</p>
                    </div>
                </div>
            </div>
            <div id="scroll">
                <a href="#"><img src="{{asset('client/img/home/scroll.png')}}"></a>
            </div>
        </div>
    </div>
</footer>
<!-- endfooter -->
<script src="{{asset('js/client/details.js')}}"></script>
<script src="{{asset('js/client/cart.js')}}"></script>
</body>
</html>
@yield('forminfor')
