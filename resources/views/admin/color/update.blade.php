<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update Category</h1>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editForm" class="form-horizontal"
                      action="{{route('color.update',$color->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="category_id" id="category_id" value="{{$color->id}}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Color Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="color_name" name="color_name"
                                   placeholder="Enter Color Name"
                                   value="{{$color->color_name}}" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="color_name-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Product</label>
                        <div class="col-sm-12">
                            {!! Form::select('product_id', ['' => 'Enter the product...'] + $products,$color->product_id,['class'=> 'form-control']) !!}
                            <span class="text-danger">
                                <strong id="product_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Created</label>
                        <div class="col-sm-12">
                            {!! Form::date('created_at',$color->created_at,['class'=>'form-control','id'=>'created_at']) !!}
                            <span class="text-danger">
                                <strong id="created_at-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Updated</label>
                        <div class="col-sm-12">
                            {!! Form::date('updated_at',$color->created_at,['class'=>'form-control','id'=>'updated_at']) !!}
                            <span class="text-danger">
                                <strong id="updated_at-error"></strong>
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
