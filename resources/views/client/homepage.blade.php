@extends('client.master')
@section('title','Homepage')
@section('main')
    <div id="wrap-inner">
        <div class="products col-sm-12">
            <h3 style="color: grey; font-weight: bold">SẢN PHẨM NỔI BẬT</h3>
            <div class="col-sm-12" style="height: 3px; background-color: #2990ea;margin-bottom: 20px"></div>
            <div class="product-list row">
                @foreach($listProduct as $product)
                    <div class="product-item col-md-2 col-sm-12 col-xs-12" style="margin-top: 10px">
                        <a href="javascript:void(0)" class="img-product"><img src="{{asset('images/'.$product->thumbnail)}}"
                                                                              class="img-thumbnail"></a>
                        <div class="content-product">
                            <p style="height: 30px"><a href="javascript:void(0)" style="color: grey;">{{$product->name_phone}}</a></p>
                            @if($today >= $start['start_promotion'] && $today <= $end['end_promotion'])
                                <p><span class="price">{{number_format($product->promotion_price)}} ₫</span></p>
                            @else
                                <p>Chỉ: <span class="price">{{number_format($product->price)}} ₫</span></p>
                            @endif
                            <div class="single-item-caption">
                                <a class="add-to-cart pull-left" href="{{route('cart',$product->id)}}"><i
                                        class="fa fa-shopping-cart" style="font-size: 25px; color: #D60000"></i></a>
                                <a class="beta-btn primary" href="{{route('product.detail',$product->id)}}">Chi tiết <i
                                        class="fa fa-chevron-right" style="font-size: 10px"></i></a>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

        <div class="products" style="margin-bottom: 20px">
            <h3 style="color: grey; font-weight: bold">SẢN PHẨM MỚI</h3>
            <div class="col-sm-12" style="height: 3px; background-color: #2990ea;margin-bottom: 20px"></div>
            <div class="product-list row">
                @foreach($newProducts as $item)
                    <div class="product-item col-md-2 col-sm-6 col-xs-12" style="margin-top: 10px">
                        <a href="javascript:void(0)" class="img-product"><img src="{{asset('images/'.$item->thumbnail)}}"
                                                                              class="img-thumbnail"></a>
                        <div class="content-product">
                            <p style="height: 30px"><a href="javascript:void(0)" style="color: grey;">{{$item->name_phone}}</a></p>
                            <p class="price">{{number_format($item->price)}} VND</p>
                            <div class="single-item-caption">
                                <a class="add-to-cart pull-left" href="{{route('cart',$item->id)}}"><i
                                        class="fa fa-shopping-cart" style="font-size: 25px; color: #D60000"></i></a>
                                <a class="beta-btn primary" href="{{route('product.detail',$item->id)}}">Details <i
                                        class="fa fa-chevron-right" style="font-size: 10px"></i></a>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
