<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update Comment</h1>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editForm" class="form-horizontal"
                      action="{{route('comment.update',$comment->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="comment_id" id="comment_id" value="{{$comment->id}}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Username</label>
                        <div class="col-sm-12">
                            @if(isset($users))
                                {!! Form::select('user_id', ['' => 'Enter the username...'] + $users,$comment->user_id,['class'=> 'form-control','id' => 'user_id_input']) !!}
                            @endif
                            <span class="text-danger">
                                <strong id="user_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Username</label>
                        <div class="col-sm-12">
                            @if(isset($products))
                                {!! Form::select('product_id', ['' => 'Enter the product bought...'] + $products,$comment->product_id,['class'=> 'form-control']) !!}
                            @endif
                            <span class="text-danger">
                                <strong id="product_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Comment Time</label>
                        <div class="col-sm-12">
                            {!! Form::date('comment_time',$comment->comment_time,['class'=>'form-control','id'=>'comment_time']) !!}
                            <span class="text-danger">
                                <strong id="comment_time-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Comment Content</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="comment_content" name="comment_content" value="{{$comment->comment_content}}">
                            <span class="text-danger">
                                <strong id="comment_content-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group" id="phone_number_input">
                        <label class="col-sm-12">Phone Number</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="phone_number" name="phone_number" value="{{$comment->phone_number}}">
                            <span class="text-danger">
                                <strong id="phone_number-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Created</label>
                        <div class="col-sm-12">
                            {!! Form::date('created_at',$comment->created_at,['class'=>'form-control','id'=>'created_at']) !!}
                            <span class="text-danger">
                                <strong id="created_at-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Updated</label>
                        <div class="col-sm-12">
                            {!! Form::date('updated_at',$comment->created_at,['class'=>'form-control','id'=>'updated_at']) !!}
                            <span class="text-danger">
                                <strong id="updated_at-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-savechanges" value="edit_comment">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
