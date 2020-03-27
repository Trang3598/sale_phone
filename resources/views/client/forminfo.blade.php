<div class="modal fade" id="ajax-crud-modal" aria-hidden="true" data-backdrop="false" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="userCrudModal">THÔNG TIN NGƯỜI GỬI</h2>
            </div>
            <div class="modal-body">
                <form id="addForm" name="addForm" class="form-horizontal"
                      action="{{route('send')}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <input type="hidden" name="_method" value="POST">
                    @csrf
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="username" name="username"
                                   placeholder="Tên tài khoản"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="username-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                   placeholder="Họ tên (bắt buộc)"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="full_name-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email"
                                   placeholder="Email (để nhận phản hồi qua Email)"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="email-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                   placeholder="Số điện thoại (để nhận phản hồi qua Zalo)"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="phone_number-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Mật khẩu"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="password-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="confirm" name="confirm"
                                   placeholder="Xác nhận mật khẩu"
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="confirm-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="send_comment" value="send_comment">Gửi bình luận
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>

