<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Add New User</h1>
            </div>
            <div class="modal-body">
                <form id="addForm" name="addForm" class="form-horizontal"
                      action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <input type="hidden" name="_method" value="POST">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Username</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="username" name="username"
                                   placeholder="Enter username "
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="username-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Avatar</label>
                        <div class="col-sm-12">
                            <input type="file" class=" form-control btn btn-info btn-sm waves-effect waves-light "
                                   id="avatar" name="avatar" value="" required="">
                            <span class="text-danger">
                                <strong id="avatar-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Full Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                   placeholder="Enter full name  "
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="full_name-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email"
                                   placeholder="Enter email"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="email-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Phone Number</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                   placeholder="Enter phone number"
                                   value="" maxlength="10" required="">
                            <span class="text-danger">
                                <strong id="phone_number-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Enter password"
                                   value="" maxlength="50" required="">
                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <span class="text-danger">
                                <strong id="password-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Confirm password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="confirm" name="confirm"
                                   placeholder="Enter confirm password"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="confirm-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Role</label>
                        <div class="col-sm-12">
                            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control')) !!}
                            <span class="text-danger">
                                <strong id="role-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add_user">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
