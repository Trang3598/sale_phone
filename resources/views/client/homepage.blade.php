@extends('client.master')
@section('title','Homepage')
@section('main')
    <div id="wrap-inner">
        <div class="products">
            <h3>sản phẩm nổi bật</h3>
            <div class="product-list row">
                @foreach($listProduct as $product)
                    <div class="product-item col-md-3 col-sm-6 col-xs-12">
                        <a href="#"><img src="{{asset('images/'.$product->thumbnail)}}"
                                         class="img-thumbnail"></a>
                        <p><a href="#">{{$product->name_phone}}</a></p>
                        @if($today >= $start['start_promotion'] && $today <= $end['end_promotion'])
                            <p><span class="price">{{number_format($product->promotion_price)}} ₫</span></p>
                        @else
                            <p>Chỉ: <span class="price">{{number_format($product->price)}} ₫</span></p>
                        @endif
                        <div class="marsk">
                            <a href="{{route('product.detail',$product->id)}}">Xem chi tiết</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="products">
            <h3>sản phẩm mới</h3>
            <div class="product-list row">
                @foreach($newProducts as $item)
                    <div class="product-item col-md-3 col-sm-6 col-xs-12">
                        <a href="#"><img src="{{asset('images/'.$item->thumbnail)}}"
                                         class="img-thumbnail"></a>
                        <p><a href="#">{{$item->name_phone}}</a></p>
                        <p class="price">{{number_format($item->price)}} VND</p>
                        <div class="marsk">
                            <a href="{{route('product.detail',$item->id)}}">Xem chi tiết</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
