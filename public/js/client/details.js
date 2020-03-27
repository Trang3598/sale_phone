$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '#btn-back', function () {
        $('#ajax-crud-modal').hide();
    });
    $('#btnSendCmt').click(function (e) {
        e.preventDefault();
        $.get('../send-infor', function (data) {
            var comment_content = $('#comment_content').val();
            if (comment_content === '') {
                $('#comment_content-error').html('Vui lòng nhập nội dung');
            } else {
                $("#forminfor").html(data);
                $('#btn-save').val("btnSendCmt");
                $('#ajax-crud-modal').modal('show');
                $('.modal-backdrop').remove();
            }
            if (data === '') {
                var form_cmt = new FormData($('#js_activity_feed_form')[0]);
                form_cmt.append('_method', 'post');
                if ($("#js_activity_feed_form").length > 0) {
                    $.ajax({
                        data: form_cmt,
                        url: $('#js_activity_feed_form').attr('action'),
                        type: "POST",
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            if (data.img_cmt != null) {
                                var dataItem = ' <ul><li class="com-title">' + data.user.username + '<br><span>' + data.comment_id.created_at + '</span></li><li class="com-details">' + data.comment_id.comment_content +
                                    '</li><li><img src="http://127.0.0.1:8000/images_feedbacks/' + data.img_cmt.image + '"  alt=""  style="height:100px;width:100px" class="img-responsive"></li>' +
                                    '<li style="padding-top: 10xp"><a href="javascript:void(0)" class="respondent" onclick="">Trả lời</a></li></ul>';
                                $('#comment-list').append(dataItem);
                            } else {
                                var dataItem2 = ' <ul><li class="com-title">' + data.user.username + '<br><span>' + data.comment_id.created_at + '</span></li><li class="com-details">' + data.comment_id.comment_content +
                                    '</li><li style="padding-top: 10xp"><a href="javascript:void(0)" class="respondent" onclick="">Trả lời</a></li></ul>';
                                $('#comment-list').append(dataItem2);
                            }
                            $('.box_img').remove();
                            $('#comment_content').val('');
                        },
                    });
                }
            }
        });
    });
    $(document).on('click', '#send_comment', function (event) {
            event.preventDefault();
            var form_data = new FormData($('#addForm')[0]);
            form_data.append('_method', 'post');
            if ($("#addForm").length > 0) {
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');
                $.ajax({
                    data: form_data,
                    url: $('#addForm').attr('action'),
                    type: "POST",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('#ajax-crud-modal').modal('hide');
                        $('#addForm').trigger("reset");
                        $('#btn-save').html('Save Changes');
                        $('#showmess').html('Add successfully').css({'display': 'block'});
                    },
                    error: function (data) {
                        if (data.responseJSON.errors) {
                            $('#username-error').html(data.responseJSON.errors.username);
                            $('#full_name-error').html(data.responseJSON.errors.full_name);
                            $('#email-error').html(data.responseJSON.errors.email);
                            $('#phone_number-error').html(data.responseJSON.errors.phone_number);
                            $('#password-error').html(data.responseJSON.errors.password);
                            $('#confirm-error').html(data.responseJSON.errors.confirm);
                        }
                        $('#btn-save').html('Save Changes');
                    }
                });
            }
        }
    );
    $('.btnCmtUpload').click(function (event) {
        event.preventDefault();
        $("#hdFileCmtUpload").click();
    });
    $("#hdFileCmtUpload").change(function (event) {
        var total_file = document.getElementById("hdFileCmtUpload").files.length;
        for (var i = 0; i < total_file; i++) {
            $('#image_preview').append("<div class='box_img' style='position: relative;'>" +
                "<img id = 'img_" + i + "' src='" + URL.createObjectURL(event.target.files[i]) + "'><span class = 'close' data-id='" + i + "' >X</span>" + "</div>");
            $(".close").css('border', 'solid 1px #4d4d4d')
                .css('background', '#333333')
                .css('height', '25px')
                .css('width', '25px')
                .css('-webkit-border-radius', '15px')
                .css('-moz-border-radius', '15px')
                .css('border-radius', '15px')
                .css('color', 'white')
                .css('font-size', '12px')
                .css('text-align', 'center')
                .css('padding', '5px 2px 2px')
                .css('cursor', 'pointer')
                .css('font-style', 'normal')
                .css('box-sizing', 'border-box')
                .css('right', '3px')
                .css('top', '1px')
                .css('position', 'absolute');
        }
        $(".close").click(function (event) {
            var id = $(this).data('id');
            $(this).parent().remove();
        });
    });
});
