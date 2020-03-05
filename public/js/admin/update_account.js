$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '.update_account', function (event) {
        event.preventDefault();
        var user_id = $(this).attr("data-id");
        $('#full_name').attr('readonly', false);
        $('#email').attr('readonly', false);
        $('#current_password').attr('readonly', false);
        $('#password').attr('readonly', false);
        $('#username').attr('readonly', false);
        $('#confirm').attr('readonly', false);
        $('.update_account').remove();
        $('#btn_action').append("<div class= 'form-group'><a href='javascript:void(0)' class='btn_close btn btn-danger'>Close</a>" +
            "<a href='javascript:void(0)' class='btn_save btn btn-success' data-id =  ' " + user_id + " ' >Save</a></div>");
    });
    $(document).on('click', '.btn_close', function (event) {
        event.preventDefault();
        $('#full_name').attr('readonly', true);
        $('#email').attr('readonly', true);
        $('#current_password').attr('readonly', true);
        $('#password').attr('readonly', true);
        $('#username').attr('readonly', true);
        $('#confirm').attr('readonly', true);
        $('.btn_close').remove();
        $('.btn_save').remove();
        $('#btn_action').append("<div class ='form-group' id='btn_action'><a href='javascript:void(0)' class='update_account btn btn-success' data-id=''>Update</a></div>");
    });
    $(document).on('click', '.btn_save', function (event) {
        var user_id = $(this).attr("data-id");
        var data = new FormData($('#updateForm')[0]);
        $.ajax({
            url: 'settingAccount/' + user_id,
            method: "POST",
            data: data,
            contentType: false,
            processData: false,
            success: function (res) {
                $('#showmess').html('Update account successfully').css({'display': 'block'});
            },
            error: function (data) {
                $('#showmess').html(data.responseJSON.message).attr('class', 'alert alert-danger').css({'display': 'block'});
                if (data.responseJSON.errors) {
                    if (data.responseJSON.errors.avatar) {
                        $('#avatar-error').html(data.responseJSON.errors.avatar);
                    }
                    if (data.responseJSON.errors.username) {
                        $('#username-error').html(data.responseJSON.errors.username);
                    }
                    if (data.responseJSON.errors.full_name) {
                        $('#full_name-error').html(data.responseJSON.errors.full_name);
                    }
                    if (data.responseJSON.errors.email) {
                        $('#email-error').html(data.responseJSON.errors.email);
                    }
                    if (data.responseJSON.errors.current_password) {
                        $('#current_password-error').html(data.responseJSON.errors.current_password);
                    }
                    if (data.responseJSON.errors.password) {
                        $('#password-error').html(data.responseJSON.errors.password);
                    }
                    if (data.responseJSON.errors.confirm) {
                        $('#confirm-error').html(data.responseJSON.errors.confirm);
                    }
                }
            }
        })
    });

    $(function () {
        $('#avatar').change(function () {
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#output').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                $('#output').attr('src', 'admin/assets/images/users/avt.png');
            }
        });
    });
});

