<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update Category</h1>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editForm" class="form-horizontal"
                      action="{{route('category.update',$category->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="category_id" id="category_id" value="{{$category->id}}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Category Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="category_name" name="category_name"
                                   placeholder="Enter Category Name"
                                   value="{{$category->category_name}}" maxlength="50" required="">
                            <input type="hidden" value="{{$category->id}}" id="category_id_form" name="id">
                            <span class="text-danger">
                                <strong id="category_name-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Created</label>
                        <div class="col-sm-12">
                            {!! Form::date('created_at',$category->created_at,['class'=>'form-control','id'=>'created_at']) !!}
                            <span class="text-danger">
                                <strong id="created_at-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Updated</label>
                        <div class="col-sm-12">
                            {!! Form::date('updated_at',$category->created_at,['class'=>'form-control','id'=>'updated_at']) !!}
                            {{--                            {!! Form::date('updated_at',$category->created_at,['class'=>'form-control','id'=>'updated_at']) !!}--}}
                            <span class="text-danger">
                                <strong id="updated_at-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-savechanges" value="edit_category">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
