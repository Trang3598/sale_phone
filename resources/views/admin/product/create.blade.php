<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Add New Product</h1>
            </div>
            <div class="modal-body">
                <form id="addForm" name="addForm" class="form-horizontal"
                      action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" id="product_id" value="">
                    <input type="hidden" name="_method" value="POST">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Product Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name_phone" name="name_phone"
                                   placeholder="Enter a phone name"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="name_phone-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Category Name</label>
                        <div class="col-sm-12">
                            {!! Form::select('id_cate', ['' => 'Enter the category...'] + $categories,'',['class'=> 'form-control']) !!}
                            <span class="text-danger">
                                <strong id="id_cate-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Title</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title"
                                   placeholder="Enter Title"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="title-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Description</label>
                        <div class="col-sm-12">
                            <textarea id="description" type="text" class="form-control" name="description"></textarea>
{{--                            <script>--}}
{{--                                CKEDITOR.replace('description');--}}
{{--                            </script>--}}
                            <span class="text-danger">
                                <strong id="description-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Quantity</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                   placeholder="Enter the quantity"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="quantity-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Detail</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="detail" name="detail"
                                   placeholder="Enter details about the product"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="detail-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="price" name="price"
                                   placeholder="Enter Price Of Product"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="price-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Size</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="size" name="size"
                                   placeholder="Enter Size Of Product "
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="size-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Memory</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="memory" name="memory"
                                   placeholder="Enter parameter of memory"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="memory-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Weight</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="weight" name="weight"
                                   placeholder="Enter parameter of weight"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="weight-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">CPU</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="cpu_speed" name="cpu_speed"
                                   placeholder="Enter parameter of CPU"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="cpu_speed-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">RAM</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="ram" name="ram"
                                   placeholder="Enter parameter of RAM "
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="ram-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Operating System</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="os" name="os"
                                   placeholder="Enter parameter of operating system"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="os-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Camera Primary</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="camera_primary" name="camera_primary"
                                   placeholder="Enter parameter of camera primary "
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="camera_primary-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Battery</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="battery" name="battery"
                                   placeholder="Enter parameter of battery"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="battery-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Warranty</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="warranty" name="warranty"
                                   placeholder="Enter the warranty"
                                   value="" required="">
                            <span class="text-danger">
                                <strong id="warranty-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Bluetooth</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="bluetooth" name="bluetooth"
                                   placeholder="Enter parameter of bluetooth"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="bluetooth-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Wlan</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="wlan" name="wlan"
                                   placeholder="Enter parameter of wlan"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="wlan-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Promotion Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="promotion_price" name="promotion_price"
                                   placeholder="Enter promotion price"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="promotion_price-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Start Promotion</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="start_promotion" name="start_promotion"
                                   placeholder="Enter the promotional start date"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="start_promotion-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date End Promotion</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="end_promotion" name="end_promotion"
                                   placeholder="Enter the promotional end date"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="end_promotion-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Condition of the item</label>
                        <div class="col-sm-12">
                            <div class="control">
                                <label class="radio">
                                    <input type="radio" name="sale_phone" value="1">
                                    Best Seller
                                </label>
                                <label class="radio">
                                    <input type="radio" name="sale_phone" value="2">
                                    Unmarketable
                                </label>
                            </div>
                            <span class="text-danger">
                                <strong id="sale_phone-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Created</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="created_at" name="created_at">
                            <span class="text-danger">
                                <strong id="created_at-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Updated</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="updated_at" name="updated_at">
                            <span class="text-danger">
                                <strong id="updated_at-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add_cate">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
