<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Add New Order Detail</h1>
            </div>
            <div class="modal-body">
                <form id="addForm" name="addForm" class="form-horizontal"
                      action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="order_detail_id" id="order_detail_id" value="">
                    <input type="hidden" name="_method" value="POST">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Order Code</label>
                        <div class="col-sm-12">
                            {!! Form::select('order_id', ['' => 'Enter the order code ...'] + $orders,'',['class'=> 'form-control']) !!}
                            <span class="text-danger">
                                <strong id="order_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Product</label>
                        <div class="col-sm-12">
                            {!! Form::select('product_id', ['' => 'Enter the product ...'] + $products,'',['class'=> 'form-control']) !!}
                            <span class="text-danger">
                                <strong id="product_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Color</label>
                        <div class="col-sm-12">
                            {!! Form::select('color_id', ['' => 'Enter the color ...'] + $colors,'',['class'=> 'form-control']) !!}
                            <span class="text-danger">
                                <strong id="color_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Sale quantity</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="sale_quantity" name="sale_quantity"
                                   placeholder="Enter sale quantity"
                                   value="" required="">
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
                                   value="" required="">
                            <span class="text-danger">
                                <strong id="price-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add_order_detail">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
