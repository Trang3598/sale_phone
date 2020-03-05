<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update Category</h1>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editForm" class="form-horizontal"
                      action="{{route('order.update',$order->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Customer Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                   placeholder="Enter Customer Name "
                                   value="{{$order->customer_name}}" required="">
                            <span class="text-danger">
                                <strong id="customer_name-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Customer Phone</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone"
                                   placeholder="Enter Customer Phone"
                                   value="{{$order->customer_phone}}" required="">
                            <span class="text-danger">
                                <strong id="customer_phone-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Customer Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="customer_email" name="customer_email"
                                   placeholder="Enter Customer Email "
                                   value="{{$order->customer_email}}" required="">
                            <span class="text-danger">
                                <strong id="customer_email-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Status</label>
                        <div class="col-sm-12">
                            {!! Form::select('status_id', ['' => 'Enter the status...'] + $status,$order->status_id,['class'=> 'form-control']) !!}
                            <span class="text-danger">
                                <strong id="status_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Deliverer</label>
                        <div class="col-sm-12">
                            {!! Form::select('deliverer_id', ['' => 'Enter the deliverer name...'] + $deliverers,$order->deliverer_id,['class'=> 'form-control']) !!}
                            <span class="text-danger">
                                <strong id="deliverer_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Total Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="total_price" name="total_price"
                                   placeholder="Enter total price"
                                   value="{{$order->total_price}}" required="">
                            <span class="text-danger">
                                <strong id="total_price-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Delivery Address</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="delivery_address" name="delivery_address"
                                   placeholder="Enter the shipping address"
                                   value="{{$order->delivery_address}}" required="">
                            <span class="text-danger">
                                <strong id="delivery_address-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Note</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="note" name="note"
                                   placeholder="Enter a note"
                                   value="{{$order->note}}" required="">
                            <span class="text-danger">
                                <strong id="note-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-savechanges" value="edit_order">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
