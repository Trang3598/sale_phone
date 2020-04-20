@extends('client.master')
@section('title','Result Search')
@section('main')
    <div id="wrap-inner">
        <div class="products">
            <h3>Tìm kiếm với từ khóa: <span>{{$key}}</span></h3>
            <div class="product-list row">
                @foreach($result_search as $product)
                    <div class="product-item col-md-3 col-sm-6 col-xs-12">
                        <a href="#"><img src="{{asset('images/'.$product->thumbnail)}}"
                                         class="img-thumbnail"></a>
                        <p><a href="#">{{$product->name_phone}}</a></p>
                        @if($today >= $start['start_promotion'] && $today <= $end['end_promotion'])
                            <p><span class="price">{{number_format($product->promotion_price)}} ₫</span></p>
                        @else
                            <p>Chỉ: <span class="price">{{number_format($product->price)}} ₫</span></p>
                        @endif
                        <div class="single-item-caption">
                            <a class="add-to-cart pull-left" href="{{route('cart',$product->id)}}"><i
                                    class="fa fa-shopping-cart"></i></a>
                            <a class="beta-btn primary" href="{{route('product.detail',$product->id)}}">Details <i
                                    class="fa fa-chevron-right"></i></a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
@stop
