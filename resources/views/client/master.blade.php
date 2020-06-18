<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('admin/assets/images/favicon.png')}}">
    <title>Sky Shop - @yield('title')</title>
    <link rel="stylesheet" href="{{asset('client/css/bootstrap.min.css')}}">
    {{--    <link rel="stylesheet" href="{{asset('client/css/home.css')}}">--}}
    <link rel="stylesheet" href="{{asset('client/css/search.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script type="text/javascript" src="{{asset('client/js/jquery-3.2.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script type="text/javascript" src="{{asset('client/js/bootstrap.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <div class="col-sm-12">
        <div class="row header-content"
             style="display: flex;flex-direction: row;justify-content: center;padding: 20px 0">
            <div id="logo" class="col-md-3 col-sm-12 col-xs-12">
                <h1>
                    <a href="#"><img src="{{asset('client/img/home/shop.png')}}"></a>
                    <nav><a id="pull" class="btn btn-danger" href="#">
                            <i class="fa fa-bars"></i>
                        </a></nav>
                </h1>
            </div>
            <div class="col-md-7  header-middle" style="display: flex;flex-direction: column;flex-wrap: wrap">
                <div class="list-items"
                     style="height: 50%; display: flex;flex-direction: row;flex-wrap: wrap; align-items: center">
                    <div class="item-1" style="margin-left: 5%;">
                        <i class="fas fa-truck-moving" style="font-size: 20px;"></i> <span class="c-1">GIAO HÀNG MIỄN PHÍ</span>
                    </div>
                    <div class="item-1" style="margin-left: 5%;">
                        <i class="fas fa-money-bill-alt" style="font-size: 20px;"></i> <span class="c-1">THANH TOÁN LINH HOẠT</span>
                    </div>
                    <div class="item-1" style="margin-left: 5%;">
                        <i class="fas fa-sync-alt" style="font-size: 20px;"></i> <span class="c-1">TRẢ HÀNG TRONG 30 NGÀY</span>
                    </div>
                </div>
                <div class="search-form" style="height: 50%">
                    <form action="{{route('search-product')}}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-8" style="display: flex;flex-direction: row">
                                <input type="text" class="form-control" id="search-data" value=""
                                       placeholder="Bạn tìm gì..." name="searchData">
                                <button type="submit" class="btn col-sm-2"
                                        style="height: 45px;background-color: #00BCD4"><i class="fa fa-search "></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="cart" class="col-md-2 col-sm-12 col-xs-12"
                 style="display: flex;align-items: center;flex-direction: row">
                <a class="display" href="#">
                    <i class="fas fa-shopping-cart" style="font-size: 50px; color: #00BCD4"></i></a>
                <a href="{{route('order.item')}}" style="margin-left: -25px;margin-top: -37px;color: white">
                    @if(Session::has('cart')){{Session('cart')->totalQty}}
                    @else
                        0
                    @endif
                </a>
            </div>
        </div>
    </div>
</header><!-- /header -->
<section class="menu-bar">
    {{--    <div class="col-sm-12">--}}
    <div class="menu-bar-content "
         style="display: flex;flex-direction: row;flex-wrap: wrap; background-color: #2990ea; padding: 0 10px;color: white;height: 60px">
        <div class="m-1 list-products col-sm-3" style="margin: 0 !important;">
            <div style="background-color: #1f6fb2;padding: 19px 20px;">
                <i class="fas fa-bars"></i> Danh mục sản phẩm
            </div>
        </div>
        <div class="m-1 homepage col-sm-2 text-center" style="margin: 0 !important; padding: 0">
            <div style=";padding: 19px 20px;border-right: 0.1px solid white">
                <a href="{{route('home.index')}}" style="text-decoration: none;color: white">Trang chủ</a>
            </div>

        </div>
        <div class="m-1 about col-sm-2 text-center" style="margin: 0 !important;padding: 0">
            <div style="padding: 19px 20px;border-right: 0.1px solid white">
                Giới thiệu
            </div>

        </div>
        <div class="m-1 contact col-sm-2 text-center" style="margin: 0 !important;padding: 0">
            <div class="" style="padding: 19px 20px;border-right: 0.1px solid white">
                Liên hệ
            </div>

        </div>
    </div>
    {{--    </div>--}}
</section>
<section id="body">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12" style="display: flex;flex-direction: row">
                <div id="sidebar" class="col-sm-3">
                    <nav id="menu">
                        <ul>
                            @foreach($categories as $category)
                                <li class="menu-item" id="product_{{$category->id}}"><a
                                        href="{{route('category.product',$category->id)}}" title=""
                                        data-id="{{$category->id}}">{{$category->category_name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <div id="main" class="col-sm-9" style="margin-top: 30px">
                    <div id="slider">
                        <div id="demo" class="carousel slide" data-ride="carousel">
                            <ul class="carousel-indicators">
                                <li data-target="#demo" data-slide-to="0" class="active"></li>
                                <li data-target="#demo" data-slide-to="1"></li>
                                <li data-target="#demo" data-slide-to="2"></li>
                            </ul>
                            <div class="carousel-inner"
                                 style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                <div class="carousel-item active">
                                    <img src="{{asset('images/' .$slides[0]->image)}}" alt="Los Angeles"
                                         style="width: 100%">
                                </div>
                                @for($i = 0;$i<sizeof($slides);$i++)
                                    <div class="carousel-item">
                                        <img src="{{asset('images/'.$slides[$i]->image)}}" alt="New York"
                                             style="width: 100%">
                                    </div>
                                @endfor
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
                </div>
            </div>
            <div class="col-sm-12" style="margin-top: 10px; display: flex;flex-direction: row;flex-wrap: wrap">
                <div class="col-sm-6 sale">
                    <img src="{{asset('client/img/home/banner-t-1.png')}}" alt="Los Angeles" style="width: 100%"
                         class="">
                </div>
                <div class="col-sm-6 sale">
                    <img src="{{asset('client/img/home/banner-t-2.png')}}" alt="Los Angeles" style="width: 100%">
                </div>
            </div>
            <div class="col-sm-12">
                @yield('main')
            </div>
        </div>
    </div>
</section>
<!-- endmain -->

<!-- footer -->
<footer id="footer-master" style="background-color: #2990ea ; color: white">
    <div class="col-sm-12" style="padding:10px">
        <div class="footer-list" style="display: flex;flex-direction: row;align-items: baseline; ">
            <div id="logo" class="col-sm-3 text-center">
                <a href="#"><img src="{{asset('client/img/home/logo1.png')}}"></a>
            </div>
            <div class="col-sm-3">
                <h3>Về chúng tôi</h3>
                <p class="text-justify">Sky Shop thành lập năm 2020. Chúng tôi luôn đem đến chất lượng dịch vụ tốt
                    nhất và những chính sách ưu đãi cho quý khách</p>
            </div>
            <div class="col-sm-3">
                <h3>Liên hệ</h3>
                <p>Phone Sale: (+84) 0357 589 900</p>
                <p>Email: trangntk98@gmail.com</p>
            </div>
            <div class="col-sm-3">
                <h3>Địa chỉ</h3>
                <p>Address 1: 38 Phùng Khoang - Thanh Xuân - Hà Nội</p>
                <p>Address 2: Thanh Phong - Thanh Liêm - Hà Nam</p>
            </div>
        </div>
    </div>
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                xfbml: true,
                version: 'v7.0'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <!-- Your Chat Plugin code -->
    <div class="fb-customerchat"
         attribution=setup_tool
         page_id="105324574561145"
         theme_color="#0084ff"
         logged_in_greeting="Sky Shop xin chào quý khách !"
         logged_out_greeting="Sky Shop xin chào quý khách !">
    </div>
</footer>
<!-- endfooter -->
<script src="{{asset('js/client/details.js')}}"></script>
<script src="{{asset('js/client/cart.js')}}"></script>
<script src="{{asset('js/client/order_success.js')}}"></script>
<script src="{{asset('js/client/search.js')}}"></script>
</body>
</html>
@yield('forminfor')
