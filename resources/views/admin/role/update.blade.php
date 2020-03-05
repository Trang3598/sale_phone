<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update Role</h1>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editForm" class="form-horizontal"
                      action="{{route('role.update',$role->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="category_id" id="category_id" value="{{$role->id}}">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Role Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Enter Role Name"
                                   value="{{$role->name}}" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="name-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Guard Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="guard_name" name="guard_name"
                                   placeholder="Enter Guard Name"
                                   value="{{$role->guard_name}}" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="guard_name-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Permission</label>
                        <div class="col-sm-12">
                            @foreach($permission as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                    {{ $value->name }}</label>
                                <br/>
                            @endforeach
                            <span class="text-danger">
                                <strong id="permission-error"></strong>
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
