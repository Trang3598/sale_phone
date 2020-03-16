<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update Order Detail</h1>
            </div>
            <div class="modal-body">
                <form id="update_order_detail_form"  class="form-horizontal"
                      action="{{route('update_order_detail',$order_detail->id)}}" method="POST"
                      enctype="multipart/form-data">
                    <input type="hidden" name="order_id" id="order_id" value="{{$order_detail->id}}">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Product</label>
                        <div class="col-sm-12">
                            {!! Form::select('product_id', ['' => 'Enter the product ...'] + $products,$order_detail->product_id,['class'=> 'form-control','id'=>'selectProduct']) !!}
                            <span class="text-danger">
                                <strong id="product_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Sale quantity</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="sale_quantity" name="sale_quantity"
                                   placeholder="Enter sale quantity"
                                   value="{{$order_detail->sale_quantity}}" required="">
                            <span class="text-danger">
                                <strong id="sale_quantity-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="price_order_detail" name="price"
                                   placeholder="Enter price"
                                   value="{{$order_detail->price}}" required="">
                            <span class="text-danger">
                                <strong id="price-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="update_order_detail" value="update_order_detail">Save
                    changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
