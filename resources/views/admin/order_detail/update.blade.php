<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update Category</h1>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editForm" class="form-horizontal"
                      action="{{route('order_detail.update',$order_detail->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="order_detail_id" id="order_detail_id" value="{{$order_detail->id}}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Order Code</label>
                        <div class="col-sm-12">
                            {!! Form::select('order_id', ['' => 'Enter the order code ...'] + $orders,$order_detail->order_id,['class'=> 'form-control']) !!}
                            <span class="text-danger">
                                <strong id="order_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Product</label>
                        <div class="col-sm-12">
                            {!! Form::select('product_id', ['' => 'Enter the product ...'] + $products,$order_detail->product_id,['class'=> 'form-control']) !!}
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
                                   value="{{$order_detail->sale_quantity}}"  required="">
                            <span class="text-danger">
                                <strong id="sale_quantity-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="price" name="price"
                                   placeholder="Enter price"
                                   value="{{$order_detail->price}}"  required="">
                            <span class="text-danger">
                                <strong id="price-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Created</label>
                        <div class="col-sm-12">
                            {!! Form::date('created_at',$order_detail->created_at,['class'=>'form-control','id'=>'created_at']) !!}
                            <span class="text-danger">
                                <strong id="created_at-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Updated</label>
                        <div class="col-sm-12">
                            {!! Form::date('updated_at',$order_detail->created_at,['class'=>'form-control','id'=>'updated_at']) !!}
                            <span class="text-danger">
                                <strong id="updated_at-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-savechanges" value="edit_order_detail">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
