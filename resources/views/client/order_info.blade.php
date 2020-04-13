@extends('client.master')
@section('title','Thank')
@section('main')
    <link rel="stylesheet" href="{{asset('client/css/order_info.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="wrap-inner" class="container">
        <div class="picsuccess">
            <div class="notistatus"><i class="iconnoti iconsuccess"></i>Đặt hàng thành công</div>
        </div>
        <div class="thank">
            @if($customer_info)
                Cảm ơn <b>anh/chị {{$customer_info[0]['customer_name']}}</b> đã cho Sky Shop có cơ hội được phục vụ.
                Trong 10 phút, nhân viên Sky Shop sẽ <b>gửi tin nhắn hoặc gọi điện </b>xác nhận giao hàng cho anh/chị.
            @endif
        </div>
        <div class="titlebill">Thông tin đặt hàng:</div>
        <div class="infoorder">
            <div>Người nhận: <b>{{$customer_info[0]['customer_name']}}, {{$customer_info[0]['customer_phone']}}</b>
            </div>
            <div>Địa chỉ nhận hàng: <b>{{$order[0]->delivery_address}}.</b> (Nhân viên sẽ gọi xác nhận trước khi giao)
            </div>
            <div>Ghi chú: <b>{{$order[0]->note}}</b></div>
            <div>Tổng tiền: <strong>{{number_format($order[0]->total_price)}}₫</strong></div>
        </div>
        <div class="mess-payment" style="display: none;">
            <span>
                Bạn đã chọn thanh toán : <b>Tiền mặt khi nhận hàng</b>
            </span>
        </div>
        <div class="choosepayment" style="display: block">
            <div>
                <h3 style="font-size:17px">Chọn hình thức thanh toán :</h3>
            </div>
            <div>
                <a href="javascript:void(0)" class="payoffline" id="payoff">
                    <div>
                        <span>Tiền mặt khi nhận hàng</span>
                    </div>
                </a>
                <a href="javascript:void(0)" class="cathe">
                    <div>
                        <span>Cà thẻ khi nhận hàng</span>
                    </div>
                </a>
                <a href="javascript:void(0)" class="atm">
                    <div>
                <span>
                    Thanh toán thẻ
                </span>
                        <img src="{{asset('client/img/home/atm.png')}}" alt="Thanh toán qua thẻ ATM">
                    </div>
                    <p>(Có Internet Banking)</p>
                </a>
                <a href="javascript:void(0)" class="visa">

                    <div>
                        <span>Thanh toán thẻ </span>
                        <img src="{{asset('client/img/home/visa.png')}}"
                             alt="Thanh toán qua thẻ Visa, Master Card">
                        <img src="{{asset('client/img/home/master.png')}}"
                             alt="Thanh toán qua thẻ Visa, Master Card">
                    </div>
                </a>
                <input type="hidden" value="0" name="payment" class="payment">
            </div>
        </div>
        <div class="deleteOrder">
            <a href="javascript:void(0)">Hủy đơn hàng</a>
        </div>
        <div class="callship">
            Khi cần hỗ trợ vui lòng gọi <a href="tel:0357589900">035.758.9900</a> (7h30 - 22h)
{{--            <div class="link-csht">--}}
{{--                <a href="javascript:void(0)">Tham khảo chính sách hoàn tiền khi thanh toán online</a>--}}
{{--            </div>--}}
        </div>
        <div class="titlebill">Sản phẩm đã mua:</div>
        <ul class="listorder">
            @foreach($order_details as $order_detail)
                <li>
                    <div class="colimg">
                        <a href="{{route('product.detail',$order_detail->product_id)}}">
                            <img width="55" height="55"
                                 src="{{asset('images/'.$order_detail->product->thumbnail)}}">
                        </a>
                    </div>
                    <div class="colinfo">
                        <strong>{{number_format($order_detail->price)}}₫</strong>
                        <a href="{{route('product.detail',$order_detail->product_id)}}">{{$order_detail->product->name_phone}}</a>
                        <div class="onecolor">
                                    <span>
                                        Màu:
                                    </span> {{$order_detail->color->color_name}}
                        </div>
                        <div class="quan">
                            <span>Số lượng:</span> {{$order_detail->sale_quantity}}
                        </div>
                        <div class="promotion choose">
                            @if($order_detail->product->start_promotion<= \Carbon\Carbon::now() && \Carbon\Carbon::now() <= $order_detail->product->end_promotion)
                                <div class="title">
                                    <label>1 khuyến mãi</label>
                                </div>
                                <span>Giảm ngay {{number_format($order_detail->product->price - $order_detail->product->promotion_price)}}₫
                                    còn {{number_format($order_detail->product->promotion_price)}}₫
                                    (áp dụng đặt và nhận hàng từ {{date_format($order_detail->product->start_promotion,'d/m/Y')}}
                                    - {{date_format($order_detail->product->end_promotion,'d/m/Y')}})
                                </span>
                            @else
                                <span>Không có khuyến mại nào cho sản phẩm này</span>
                            @endif
                        </div>
                        <div class="clr"></div>
                        <div class="clr"></div>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="clr"></div>
        <a href="{{route('home.index')}}" class="buyother">Về trang chủ</a>
        <div class="clr"></div>
    </div>
@stop
