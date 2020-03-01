<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Add New Role</h1>
            </div>
            <div class="modal-body">
                <form id="addForm" name="addForm" class="form-horizontal"
                      action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="POST">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Role Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Enter Role Name "
                                   value="" required="">
                            <span class="text-danger">
                                <strong id="name-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Guard Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="guard_name" name="guard_name"
                                   placeholder="Enter Guard Name "
                                   value="" required="">
                            <span class="text-danger">
                                <strong id="guard_name-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Permission</label>
                        <div class="col-sm-12">
                            @foreach($permission as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label>
                                <br/>
                            @endforeach
                            <span class="text-danger">
                                <strong id="permission-error"></strong>
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
                <button type="button" class="btn btn-primary" id="btn-save" value="add_role">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
