<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Order Detail</h1>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Customer Name: </label>
                    <span>{{$order->customer_name}}</span>
                </div>
                <div class="form-group">
                    <label>Customer Phone: </label>
                    <span>{{$order->customer_phone}}</span>
                </div>
                <div class="form-group">
                    <label>Customer Email: </label>
                    <span>{{$order->customer_email}}</span>
                </div>
                <div class="form-group">
                    <label>Order Date: </label>
                    <span>{{$order->created_at->format('d-m-Y')}}</span>
                </div>
                <div class="form-group">
                    <label>Delivery Address: </label>
                    <span>{{$order->delivery_address}}</span>
                </div>
                <div class="form-group">
                    <label>Payment: </label>
                    <span>
                        @if($order->payment == 1)
                            Thanh toán bằng tiền mặt khi nhận hàng
                            @elseif($order->payment == 2)
                            Thanh toán bằng cà thẻ khi nhận hàng
                            @elseif($order->payment == 0)
                            Chưa chọn hình thức thanh toán
                            @elseif($order->payment == 3)
                            Thanh toán qua thẻ ATM(Có Internet Banking)
                            @else
                            Thanh toán qua Paypal
                        @endif
                    </span>
                </div>
                <div class="form-group">
                    <label>Note: </label>
                    <span>{{$order->note}}</span>
                </div>
                <div class="form-group">
                    <label>Order Status: </label>
                    <span>{{$status->status_name}}</span>
                </div>
                <div class="form-group">
                    <label>Deliverer Name: </label>
                    <span>{{$deliverer->deliverer_name}}</span>
                </div>
                <div class="form-group">
                    <label>Deliverer Phone: </label>
                    <span>{{$deliverer->deliverer_phone}}</span>
                </div>
                <div class="table-responsive text-center">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th colspan="2">Action</th>
                        </tr>
                        </thead>
                        <tbody id="listItem">
                        @foreach($order_details as $order_detail)
                            <tr id="id_{{$order_detail->id}}">
                                <td id="order_detail_id_{{$order_detail->id}}">{{$order_detail->id}}</td>
                                <td id="product_id_{{$order_detail->id}}">{{$order_detail->name_phone}}</td>
                                <td id="color_id_{{$order_detail->id}}">{{$order_detail->color_name}}</td>
                                <td id="sale_quantity_{{$order_detail->id}}">{{$order_detail->sale_quantity}}</td>
                                <td id="price_{{$order_detail->id}}">{{number_format($order_detail->price)}}</td>
                                @can('order_detail-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-order_detail btn btn-success"
                                               data-id="{{$order_detail->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('order_detail-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-order_detail"
                                           data-id="{{$order_detail->id}}"
                                           class="btn btn-danger delete-order_detail">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"><b>Tổng tiền</b></td>
                            <td colspan="4"><b class="text-red">{{ number_format($total_price) }} VNĐ</b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('export_pdf',$order_detail->order_id) }}" class="btn btn-outline-success"
                   id="export-button">Export PDF </a>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>

