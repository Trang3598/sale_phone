@extends('client.master')
@section('title','Cart')
@section('main')
    <link rel="stylesheet" href="{{asset('client/css/order_info.css')}}">
    <div id="wrap-inner" class="container">
        <div class="picsuccess">
            <div class="notistatus"><i class="iconnoti iconsuccess"></i>Đặt hàng thành công</div>
        </div>
        <div class="thank">
            @if($customer_info)
                Cảm ơn <b>anh/chị {{$customer_info[0]['customer_name']}}</b> đã cho Sky Shop có cơ hội được phục vụ.
                Trong 10 phút, nhân viên Sky Shop sẽ <b>gửi
                    tin nhắn hoặc gọi điện </b>xác nhận giao hàng cho chị.
            @endif
        </div>
        <div class="titlebill">Thông tin đặt hàng:</div>
        <div class="infoorder">

            <div>Người nhận: <b>{{$customer_info[0]['customer_name']}}, {{$customer_info[0]['customer_phone']}}</b>
            </div>
            <div>Địa chỉ nhận hàng: <b>{{$order[0]->delivery_address}}.</b> (Nhân viên sẽ gọi xác
                nhận
                trước
                khi giao)
            </div>
            <div>Ghi chú: <b>{{$order[0]->note}}</b></div>
            <div>Tổng tiền: <strong>{{number_format($order[0]->total_price)}}₫</strong></div>
        </div>
        <div class="choosepayment">
            <div>
                <h3>Chọn hình thức thanh toán :</h3>
            </div>
            <div>
                <a href="javascript:void(0)" class="payoffline">
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

            </div>
        </div>
        <div class="deleteOrder">
            <a href="javascript:void(0)">Hủy đơn hàng</a>
        </div>
        <div class="callship">
            Khi cần hỗ trợ vui lòng gọi <a href="tel:0357589900">0357589900</a> (7h30 - 22h)
            <div class="link-csht">
                <a href="javascript:void(0)">Tham khảo chính sách hoàn tiền khi thanh toán online</a>
            </div>
        </div>
        <div class="titlebill">Sản phẩm đã mua:</div>
        <ul class="listorder">
            <li>
                <div class="colimg">
                    <a href="/dtdd/xiaomi-redmi-note-9s">
                        <img width="55" height="55"
                             src="//cdn.tgdd.vn/Products/Images/42/214924/xiaomi-redmi-note-9s-4gb-green-200x200-180x125.png">
                    </a>
                </div>
                <div class="colinfo">
                    <strong>5.990.000₫</strong>
                    <a href="/dtdd/xiaomi-redmi-note-9s">Xiaomi Redmi Note 9S</a>
                    <div class="onecolor">
                                    <span>
                                        Màu:
                                    </span> Xanh lá
                    </div>
                    <div class="quan">
                        <span>Số lượng:</span> 1
                    </div>
                    <div class="promotion choose">
                        <div class="title">
                            <label>1 khuyến mãi</label>
                        </div>
                        <span>Tặng 2 suất mua Đồng hồ thời trang giảm 40% (không áp dụng thêm khuyến mãi khác) <a
                                href="https://www.thegioididong.com/tin-tuc/dong-ho-giam-gia-thang-moi-1246102"
                                target="_blank">(click xem chi tiết)</a>
</span>
                    </div>
                    <div class="clr"></div>
                    <div class="clr"></div>
                </div>
            </li>
        </ul>
        <div class="clr"></div>
        <a href="/" class="buyother">Về trang chủ</a>
        <div class="clr"></div>

    </div>
@stop
