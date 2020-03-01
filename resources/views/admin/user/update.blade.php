<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update User Information</h1>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editForm" class="form-horizontal"
                      action="{{route('user.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Username</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="username" name="username"
                                   placeholder="Enter username "
                                   value="{{$user->username}}" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="username-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Full Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                   placeholder="Enter full name  "
                                   value="{{$user->full_name}}" maxlength="50" required="">
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
                                   value="{{$user->email}}" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="email-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Enter password"
                                   value="" maxlength="50" required="">
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
                            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                            <span class="text-danger">
                                <strong id="role-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Created</label>
                        <div class="col-sm-12">
                            {!! Form::date('created_at',$user->created_at,['class'=>'form-control','id'=>'created_at']) !!}
                            <span class="text-danger">
                                <strong id="created_at-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Updated</label>
                        <div class="col-sm-12">
                            {!! Form::date('updated_at',$user->updated_at,['class'=>'form-control','id'=>'updated_at']) !!}
                            <span class="text-danger">
                                <strong id="updated_at-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-savechanges" value="edit_user">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
