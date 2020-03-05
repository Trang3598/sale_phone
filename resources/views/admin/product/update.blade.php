<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update Product</h1>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editForm" class="form-horizontal"
                      action="{{route('product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Product Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name_phone" name="name_phone"
                                   placeholder="Enter Phone Name"
                                   value="{{$product->name_phone}}" maxlength="50" required="">
                            <input type="hidden" value="{{$product->id}}" id="product_id_form" name="id">
                            <span class="text-danger">
                                <strong id="name_phone-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Category Name</label>
                        <div class="col-sm-12">
                            {!! Form::select('id_cate', ['' => 'Enter the category...'] + $categories,$product->id_cate,['class'=> 'form-control']) !!}
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
                                   value="{{$product->title}}" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="title-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Description</label>
                        <div class="col-sm-12">
                            <textarea id="description" type="text" class="form-control"
                                      name="description">{{$product->description}}</textarea>
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
                                   value="{{$product->quantity}}" maxlength="50" required="">
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
                                   value="{{$product->detail}}" maxlength="50" required="">
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
                                   value="{{$product->price}}" maxlength="50" required="">
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
                                   value="{{$product->size}}" maxlength="50" required="">
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
                                   value="{{$product->memory}}" maxlength="50" required="">
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
                                   value="{{$product->weight}}" maxlength="50" required="">
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
                                   value="{{$product->cpu_speed}}" maxlength="50" required="">
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
                                   value="{{$product->ram}}" maxlength="50" required="">
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
                                   value="{{$product->os}}" maxlength="50" required="">
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
                                   value="{{$product->camera_primary}}" maxlength="50" required="">
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
                                   value="{{$product->battery}}" maxlength="50" required="">
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
                                   value="{{$product->warranty}}" maxlength="50" required="">
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
                                   value="{{$product->bluetooth}}" maxlength="50" required="">
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
                                   value="{{$product->wlan}}" maxlength="50" required="">
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
                                   value="{{$product->promotion_price}}" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="promotion_price-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Start Promotion</label>
                        <div class="col-sm-12">
                            {!! Form::date('start_promotion',$product->start_promotion,['class'=>'form-control','id'=>'start_promotion']) !!}
                            <span class="text-danger">
                                <strong id="start_promotion-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date End Promotion</label>
                        <div class="col-sm-12">
                            {!! Form::date('end_promotion',$product->end_promotion,['class'=>'form-control','id'=>'end_promotion']) !!}
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
                                    {!! Form::radio('sale_phone','1',$product->sale_phone ==1) !!}{{'Best Seller'}}
                                </label>
                                <label class="radio">
                                    {!! Form::radio('sale_phone','1',$product->sale_phone ==2) !!}{{'Unmarketable'}}
                                </label>
                            </div>
                            <span class="text-danger">
                                <strong id="sale_phone-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-savechanges" value="edit_product">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
