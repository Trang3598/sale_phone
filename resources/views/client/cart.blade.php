@extends('client.master')
@section('title','Cart')
@section('main')
    <link rel="stylesheet" href="{{asset('client/css/cart.css')}}">
    <div id="wrap-inner">
        <h3>GIỎ HÀNG</h3>
        <div class="wrap_cart">
            <div class="bar-top">
                <a href="{{route('home.index')}}" class="buymore">Mua thêm sản phẩm khác</a>
                <div class="yourcart">Giỏ hàng của bạn</div>
            </div>
            <form id="formtest" novalidate="novalidate" action="{{route('send-order')}}">
                @csrf
                <div class="detail_cart">
                    <ul class="listorder">
                        @if(Session::has('cart'))
                            @foreach($product_cart as $cart)
                                <li class="item samsung justadded" id="item_{{$cart['item']['id']}}">
                                    <input type="hidden" name="product_id" value="{{$cart['item']['id']}}">
                                    <div class="colimg">
                                        <a href="#">
                                            <img width="55"
                                                 src="{{asset('images/'.$cart['item']['thumbnail'])}}">
                                        </a>
                                        <button type="button" class="delete" id="delete_product" onclick=""
                                                data-id="{{$cart['item']['id']}}"><span></span>Xóa
                                        </button>
                                    </div>
                                    <div class="colinfo">
                                        <strong>{{number_format($cart['item']['price'])}} ₫</strong>
                                        <a href="#">{{$cart['item']['name_phone']}}</a>
                                        <div class="promotion  webnote ">
                                            <div class="title">
                                                @if($cart['item']['start_promotion']<= \Carbon\Carbon::now() && \Carbon\Carbon::now() <= $cart['item']['end_promotion'])
                                                    <label>1 khuyến mãi áp dụng
                                                        đến {{date_format($cart['item']['end_promotion'],'d/m/Y')}}</label>
                                                @else
                                                    <label></label>
                                                @endif
                                            </div>
                                            @if($cart['item']['start_promotion']<= \Carbon\Carbon::now() && \Carbon\Carbon::now() <= $cart['item']['end_promotion'])
                                                <span>
                                                Giảm ngay {{number_format($cart['item']['price'] - $cart['item']['promotion_price'])}}₫
                                                    (áp dụng đặt và nhận hàng từ {{date_format($cart['item']['start_promotion'],'d/m/Y')}}
                                                    - {{date_format($cart['item']['end_promotion'],'d/m/Y')}})
                                                    <label
                                                        class="infoend">(đến {{date_format($cart['item']['end_promotion'],'d/m/Y')}})</label>
                                                </span>
                                            @else
                                                <span>Không có khuyến mại nào cho sản phẩm này</span>
                                            @endif
                                        </div>
                                        <div>
                                            @if($cart['item']['start_promotion']<= \Carbon\Carbon::now() && \Carbon\Carbon::now() <= $cart['item']['end_promotion'])
                                                <span>Giảm <strong
                                                        style="float: none; margin-right: 0;">{{number_format($cart['item']['price'] - $cart['item']['promotion_price'])}}₫</strong> còn <strong
                                                        style="float: none;">{{number_format($cart['item']['promotion_price'])}}₫</strong></span>
                                            @else
                                                <span></span>
                                            @endif
                                        </div>
                                        <div class="choosecolor drop-down closed">
                                            <select id="cars" class="form-control" name="color_id[]"
                                                    id="color_id_{{$cart['item']['id']}}">
                                                @foreach($cart['item']['color'] as $key => $color)
                                                    <option
                                                        value="{{$color->color_name}}">{{$color->color_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="color_id-error"></strong>
                                            </span>
                                        </div>
                                        <div class="choosenumber" id="choosenumber_{{$cart['item']['id']}}"
                                             data-id="{{$cart['item']['id']}}">
                                            @if($cart['item']['start_promotion']<= \Carbon\Carbon::now() && \Carbon\Carbon::now() <= $cart['item']['end_promotion'])
                                                <input type="hidden" class="discount"
                                                       value="{{$cart['item']['price'] - $cart['item']['promotion_price']}}"
                                                       data-value="{{$cart['item']['price'] - $cart['item']['promotion_price']}}"
                                                       id="discount_{{$cart['item']['id']}}">
                                            @else
                                                <input type="hidden" class="discount"
                                                       value="0">
                                            @endif
                                            <div class="abate" id="abate_{{$cart['item']['id']}}"
                                                 data-id="{{$cart['item']['id']}}">
                                            </div>
                                            <input type="hidden" value="{{$cart['item']['price']}}" name="price"
                                                   class="price" data-id="{{$cart['item']['id']}}"
                                                   data-value="{{$cart['item']['price']}}"
                                                   id="price_{{$cart['item']['id']}}">
                                            <input type="number" id="1" value="{{$cart['qty']}}" class="number" readonly/>
                                            <div class="augment" id="augment_{{$cart['item']['id']}}"
                                                 data-id="{{$cart['item']['id']}}">
                                            </div>
                                            <input type="hidden" id="sale_quantity_{{$cart['item']['id']}}"
                                                   value="{{$cart['qty']}}" class="sale_quantity"
                                                   name="sale_quantity[]" data-value="{{$cart['qty']}}"/>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    @if(Session::has('cart'))
                        <div class="area_total">
                            <div>
                                <div>
                                    <span>Tổng tiền:</span>
                                    <span class="total_price">{{number_format($totalPrice)}}₫</span>
                                </div>
                                <div>
                                    <span>Giảm:</span>
                                    <span class="total_discount">-{{number_format($totalDiscount)}}₫</span>
                                </div>
                                <div class="shipping_home" style="display: block;">
                                    <div class="total">
                                        <b>Cần thanh toán:</b>
                                        <strong class="pay_total">{{number_format($totalPrice-$totalDiscount)}}
                                            ₫</strong>
                                        <input type="hidden" name="total_price" value="{{$totalPrice-$totalDiscount}}"
                                               class="total_pay">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="infouser ">
                    <div class="malefemale">
                        <label>THÔNG TIN KHÁCH HÀNG</label>
                    </div>
                    @if($customer_info)
                        <div class="areainfo">
                            <span>Anh/Chị :
                                <strong>{{$customer_info[0]['customer_name']}} - {{$customer_info[0]['customer_phone']}}</strong>
                            </span>
                            <span class="change">Sửa</span>
                            <div class="infouser none" style="display: none;" id="updateInfor">
                                <div class="left">
                                    <input type="text" class="saveinfo" name="customer_name" placeholder="Họ và tên"
                                           maxlength="50" value="{{$customer_info[0]['customer_name']}}">
                                </div>
                                <div class="right">
                                    <input type="tel" class="saveinfo" name="customer_phone"
                                           placeholder="Số điện thoại" maxlength="10"
                                           value="{{$customer_info[0]['customer_phone']}}">
                                </div>
                                <div>
                                    <input type="text" class="saveinfo" name="customer_email"
                                           placeholder="Email" value="{{$customer_info[0]['customer_email']}}">
                                </div>
                            </div>
                            <input type="text" class="saveinfo" style="" id="note" name="note"
                                   placeholder="Yêu cầu khác (không bắt buộc)" maxlength="300">
                        </div>
                    @else
                        <div class="areainfo">
                            <div class="left">
                                <input type="text" class="saveinfo" name="customer_name" placeholder="Họ và tên"
                                       maxlength="50" value="">
                                <span class="text-danger">
                                <strong id="customer_name-error"></strong>
                            </span>
                            </div>
                            <div class="right">
                                <input type="tel" class="saveinfo" name="customer_phone"
                                       placeholder="Số điện thoại" maxlength="10" value="">
                                <span class="text-danger">
                                <strong id="customer_phone-error"></strong>
                            </span>
                            </div>
                            <div>
                                <input type="text" class="saveinfo" name="customer_email"
                                       placeholder="Email" value="">
                                <span class="text-danger">
                                <strong id="customer_email-error"></strong>
                            </span>
                            </div>
                            <input type="text" class="saveinfo" style="" id="note" name="note"
                                   placeholder="Yêu cầu khác (không bắt buộc)" maxlength="300">
                        </div>
                    @endif
                </div>
                <div class="area_other">
                    <div class="textnote"><b>Để được phục vụ nhanh hơn,</b> hãy vui lòng nhập chi tiết địa chỉ giao
                        hàng:
                    </div>
                    <div class="address">
                        <input type="text" class="saveinfo" style="" id="delivery_address" name="delivery_address"
                               placeholder="Nhập địa chỉ giao hàng" maxlength="300">
                        <span class="text-danger">
                                <strong id="delivery_address-error"></strong>
                        </span>
                    </div>
                    <div class="new-follow">
                        <div class="choosepayment">
                            <a href="javascript:void(0)" class="payoffline full">Đặt hàng</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

