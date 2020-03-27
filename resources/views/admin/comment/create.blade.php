<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Add New Feedback</h1>
            </div>
            <div class="modal-body">
                <form id="addForm" name="addForm" class="form-horizontal"
                      action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="feedback_id" id="feedback_id" value="">
                    <input type="hidden" name="_method" value="POST">
                    @csrf
                    <div class="form-group" >
                        <label class="col-sm-12">Username</label>
                        <div class="col-sm-12">
                            @if(isset($users))
                            {!! Form::select('user_id', ['' => 'Enter the username...'] + $users,'',['class'=> 'form-control','id' => 'user_id_input']) !!}
                            @endif
                            <span class="text-danger">
                                <strong id="user_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Product</label>
                        <div class="col-sm-12">
                            @if(isset($products))
                            {!! Form::select('product_id', ['' => 'Enter the product bought...'] + $products,'',['class'=> 'form-control']) !!}
                            @endif
                            <span class="text-danger">
                                <strong id="product_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Comment Content</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="comment_content" name="comment_content">
                            <span class="text-danger">
                                <strong id="comment_content-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group" id="phone_number_input">
                        <label class="col-sm-12">Phone Number</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="phone_number" name="phone_number">
                            <span class="text-danger">
                                <strong id="phone_number-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add_comment">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
