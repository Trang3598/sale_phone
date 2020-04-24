@extends('admin.layout.index')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="message_warning">
                <div class="alert alert-success" id="showmess" style="display: none"></div>
                @if(session('message'))
                    <div class="alert alert-success">
                        {{session('message')}}
                        <button style="float: right;border: none;background-color: #dff0d8">X</button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{session('error')}}
                        <button style="float: right;border: none;background-color: #f2dede">X</button>
                    </div>
                @endif
            </div>
            @can('comment-create')
                <div style="padding-bottom:25px;float: right" class="btn-add">
                    <a href="javascript:void(0)" class="add-comment btn btn-info">Add New Feedback</a>
                </div>
            @endcan
            <div style="padding-top: 25px">
                <label>Total: {{isset($count)?$count:0}} records</label>
            </div>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>User</th>
                        <th>Products</th>
                        <th>Comment Content</th>
                        <th>Date Created</th>
                        @can('comment-edit','comment-delete')
                            <th colspan="2">Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody id="listItem">
                    @if($comments)
                        @foreach($comments as $comment)
                            <tr id="id_{{$comment->id }}">
                                <td id="id_{{$comment->id}}">{{$comment->id}}</td>
                                <td id="user_id_{{$comment->id}}">{{isset($comment->user_id)? $comment->user->username:'VISITOR'}}</td>
                                <td id="product_id_{{$comment->id}}">{{isset($comment->product_id)? $comment->product->name_phone:''}}</td>
                                <td id="comment_content_{{$comment->id}}">{{$comment->comment_content}}</td>
                                <td id="created_at_{{$comment->id}}">{{$comment->created_at->format('d/m/Y')}}</td>
                                @can('comment-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-comment btn btn-success"
                                               data-id="{{$comment->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('comment-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-comment"
                                           data-id="{{$comment->id}}"
                                           class="btn btn-danger delete-comment">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="padding-top: 20px">
                {!! $comments->appends(compact('items'))->links()!!}
            </div>
            @endsection
            @section('form-add')
                <div id="comment"></div>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('div.message_warning').on('click', function () {
                            $('div.message_warning').remove();
                        });
                    });
                </script>
                <script>
                    $(document).ready(function () {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $(document).on('click', '#btn-back', function () {
                            $('#ajax-crud-modal').hide();
                        });
                        $(document).on('click', '.add-comment', function () {
                            $.get('admin/comment/create', function (data) {
                                $("#comment").html(data);
                                $('#userCrudModal').html("Add New Comment");
                                $('#btn-save').val("add-comment");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                        $(document).on('click', '.edit-comment', function () {
                            var comment_id = $(this).data('id');
                            $.get('admin/comment/' + comment_id + '/edit', function (data) {
                                $("#comment").html(data);
                                $('#userCrudModal').html("Edit Comment");
                                $('#btn-save').val("edit-comment");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                    });
                    $(document).on('click', '#btn-save', function (event) {
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
                                    var dataItem = '<tr id="id_' + data.comments.id + '"><td>' + data.comments.id + '</td><td id="user_id_' + data.comments.id + '">' + data.user.username
                                        + '</td><td id="product_id_' + data.comments.id + '">' + data.product.name_phone + '</td><td id="comment_content_' + data.comments.id + '">'
                                        + data.comments.comment_content  + '</td><td id="created_at_'
                                        +data.comments.id +'">' + data.comments.created_at + '</td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="" data-id="' + data.comments.id  + '" class="edit-comment btn btn-success mr-2">Update</a></td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="delete-comment" data-id="' + data.comments.id + '" class="btn btn-danger delete-user ml-1">Delete</a></td></tr>';
                                    $('#listItem').append(dataItem);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#addForm').trigger("reset");
                                    $('#btn-save').html('Save Changes');
                                    $('#showmess').html('Add successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors) {
                                            $('#user_id-error').html(data.responseJSON.errors.user_id);
                                            $('#product_id-error').html(data.responseJSON.errors.product_id);
                                            $('#comment_content-error').html(data.responseJSON.errors.comment_content);
                                            $('#phone_number-error').html(data.responseJSON.errors.phone_number);
                                            $('#created_at-error').html(data.responseJSON.errors.created_at);
                                            $('#updated_at-error').html(data.responseJSON.errors.updated_at);
                                        }
                                        $('#btn-save').html('Save Changes');
                                    }
                                }
                            });
                        }
                    });
                    $(document).on('click', '#btn-savechanges', function (event) {
                        event.preventDefault();
                        var form_data = new FormData($('#editForm')[0]);
                        form_data.append('_method', 'patch');
                        if ($("#editForm").length > 0) {
                            var actionType = $('#btn-savechanges').val();
                            $('#btn-savechanges').html('Sending..');
                            $.ajax({
                                data: form_data,
                                url: $('#editForm').attr('action'),
                                type: "POST",
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#user_id_" + data.comments.id).html(data.user.username);
                                    $("#product_id_" +data.comments.id).html(data.product.name_phone);
                                    $("#comment_content_" + data.comments.id).html(data.comments.comment_content);
                                    $("#created_at_" +data.comments.id).html(data.comments.created_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors.user_id) {
                                            $('#user_id-error').html(data.responseJSON.errors.user_id);
                                        }
                                        if (data.responseJSON.errors.product_id) {
                                            $('#product_id-error').html(data.responseJSON.errors.product_id);
                                        }
                                        if (data.responseJSON.errors.phone_number) {
                                            $('#phone_number-error').html(data.responseJSON.errors.phone_number);
                                        }
                                        if (data.responseJSON.errors.created_at) {
                                            $('#created_at-error').html(data.responseJSON.errors.created_at);
                                        }
                                        if (data.responseJSON.errors.updated_at) {
                                            $('#updated_at-error').html(data.responseJSON.errors.updated_at);
                                        }
                                        $('#btn-save').html('Save Changes');
                                    }
                                }
                            });
                        }
                    });
                    $('body').on('click', '#delete-comment', function (event) {
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var comment_id = $(this).data("id");
                        if (confirm("Are you sure want to delete this field !")) {
                            $.ajax({
                                type: "GET",
                                url: "admin/comment/destroy/" + comment_id,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#id_" + comment_id).remove();
                                    $('#showmess').html('Delete successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    console.log('Error:', data);
                                }
                            });
                        }
                    });
                </script>
                <script type="text/javascript">
                    $('#search').keyup(function () {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var value = $(this).val();
                        var dataString = 'key=' + value;
                        $.ajax({
                            type: 'GET',
                            url: 'comment/search',
                            data: dataString,
                            success: function (data) {
                                $('#listItem').html(data);
                            },
                        });
                    });
                </script>
@endsection
