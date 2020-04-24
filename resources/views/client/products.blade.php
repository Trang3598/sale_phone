@extends('client.master')
@section('title','Product Portfolio')
@section('main')
    <link rel="stylesheet" href="{{asset('client/css/category.css')}}">
    <div id="wrap-inner">
        <div class="products">
            <h3></h3>
            <div class="product-list row">
                @foreach($products as $product)
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
        <div id="pagination">
            <ul class="pagination pagination-lg justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item disabled"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@stop
