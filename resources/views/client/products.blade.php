@extends('client.master')
@section('title','Product Portfolio')
@section('main')
    <link rel="stylesheet" href="{{asset('client/css/category.css')}}">
    <div id="wrap-inner">
        <div class="products">
            <h3></h3>
            <div class="product-list row">
                @foreach($products as $product)
                    <div class="product-item col-md-3 col-sm-6 col-xs-12">
                        <a href="#"><img src="{{asset('images/'.$product->thumbnail)}}" class="img-thumbnail"></a>
                        <p><a href="#">{{$product->name_phone}}</a></p>
                        <p class="price">{{number_format($product->price)}} ₫</p>
                        <div class="marsk">
                            <a href="{{route('product.detail',$product->id)}}">Xem chi tiết</a>
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
