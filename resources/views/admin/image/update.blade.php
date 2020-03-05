<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update Image Information</h1>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editForm" class="form-horizontal"
                      action="{{route('image.update',$image->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="category_id" id="category_id" value="{{$image->id}}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Product</label>
                        <div class="col-sm-12">
                            {!! Form::select('product_id', ['' => 'Enter the product...'] + $products,$image->product_id,['class'=> 'form-control']) !!}
                            <span class="text-danger">
                                <strong id="product_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Image File</label>
                        <div class="col-sm-12">
                            <input type="file" class=" form-control btn btn-info btn-sm waves-effect waves-light "
                                   id="image" name="image" value="" required="">
                            <input type="hidden" value="" id="image" name="image">
                            <span class="text-danger">
                                <strong id="image-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-savechanges" value="edit_image">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
