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
            @can('user-create')
                <div style="padding-bottom:25px;float: right" class="btn-add">
                    <a href="javascript:void(0)" class="add-user btn btn-info">Add New User</a>
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
                        <th>Username</th>
                        <th>Avatar</th>
                        <th>Roles</th>
                        <th>Date Created</th>
                        @can('user-edit','user-delete')
                            <th colspan="2">Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody id="listItem">
                    @if($users)
                        @foreach($users as $user)
                            <tr id="id_{{ $user->id }}">
                                <td id="user_id_{{$user->id}}">{{$user->id}}</td>
                                <td id="username_{{$user->id}}">{{isset($user->username) ? $user->username :''}}</td>
                                <td><img id="avatar_{{$user->id}}" src="images/{{$user->avatar}}"
                                         style="width: 100px;height:100px"></td>
                                <td id="role_{{$user->id}}">
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td id="created_at_{{$user->id}}">{{isset($user->created_at)?$user->created_at->format('d/m/Y'):''}}</td>
                                @can('user-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-user btn btn-success"
                                               data-id="{{$user->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('user-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-user"
                                           data-id="{{$user->id}}"
                                           class="btn btn-danger delete-user">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="padding-top: 20px">
                {!! $users->appends(compact('items'))->links()!!}
            </div>
            @endsection
            @section('form-add')
                <div id="user"></div>
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
                        $(document).on('click', '.add-user', function () {
                            $.get('admin/user/create', function (data) {
                                $("#user").html(data);
                                $('#userCrudModal').html("Add New User");
                                $('#btn-save').val("add-user");
                                $('#ajax-crud-modal').modal('show');
                                $(".toggle-password").click(function () {
                                    $(this).toggleClass("fa-eye fa-eye-slash");
                                    var input = $($(this).attr("toggle"));
                                    if (input.attr("type") == "password") {
                                        input.attr("type", "text");
                                    } else {
                                        input.attr("type", "password");
                                    }
                                });
                            })
                        });
                        $(document).on('click', '.edit-user', function () {
                            var user_id = $(this).data('id');
                            $.get('admin/user/' + user_id + '/edit', function (data) {
                                $("#user").html(data);
                                $('#userCrudModal').html("Edit User Information");
                                $('#btn-save').val("edit-user");
                                $('#ajax-crud-modal').modal('show');
                            });
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
                                    console.log(data.role_data[0]);
                                    var dataItem = '<tr id="id_' + data.users.id + '"><td>' + data.users.id + '</td><td id="username_' + data.users.id + '">' + data.users.username + '</td><td>' +
                                        '<img id="avatar_' + data.users.id + '"  src = "images/' + data.users.avatar + '" alt ="" style="height:100px;width:100px" class="img-responsive" />' +
                                        '</td><td><label class="badge badge-success">' + data.role_data[0].name + '</label></td><td>' + data.users.created_at + '</td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="" data-id="' + data.users.id + '" class="edit-user btn btn-success mr-2">Update</a></td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="delete-user" data-id="' + data.users.id + '" class="btn btn-danger delete-user ml-1">Delete</a></td></tr>';
                                    $('#listItem').append(dataItem);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#addForm').trigger("reset");
                                    $('#btn-save').html('Save Changes');
                                    $('#showmess').html('Add successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        $('#username-error').html(data.responseJSON.errors.username);
                                        $('#avatar-error').html(data.responseJSON.errors.avatar);
                                        $('#full_name-error').html(data.responseJSON.errors.full_name);
                                        $('#email-error').html(data.responseJSON.errors.email);
                                        $('#phone_number-error').html(data.responseJSON.errors.phone_number);
                                        $('#password-error').html(data.responseJSON.errors.password);
                                        $('#confirm-error').html(data.responseJSON.errors.confirm);
                                        $('#created_at-error').html(data.responseJSON.errors.created_at);
                                        $('#updated_at-error').html(data.responseJSON.errors.updated_at);
                                    }
                                    $('#btn-save').html('Save Changes');

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
                                    console.log(data.role_data[0]);
                                    $("#username_" + data.users.id).html(data.users.username)
                                    $("#avatar_" + data.users.id).attr('src', 'images/' + data.users.avatar);
                                    $("#role_" + data.users.id).html('<label class="badge badge-success">' + data.role_data[0] + '</label>');
                                    $("#created_at_" + data.users.id).html(data.users.created_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors.username) {
                                        $('#username-error').html(data.responseJSON.errors.username);
                                    }
                                    if (data.responseJSON.errors.avatar) {
                                        $('#avatar-error').html(data.responseJSON.errors.avatar);
                                    }
                                    if (data.responseJSON.errors.full_name) {
                                        $('#full_name-error').html(data.responseJSON.errors.full_name);
                                    }
                                    if (data.responseJSON.errors.email) {
                                        $('#email-error').html(data.responseJSON.errors.email);
                                    }
                                    if (data.responseJSON.errors.phone_number) {
                                        $('#phone_number-error').html(data.responseJSON.errors.phone_number);
                                    }
                                    if (data.responseJSON.errors.password) {
                                        $('#password-error').html(data.responseJSON.errors.password);
                                    }
                                    if (data.responseJSON.errors.confirm) {
                                        $('#confirm-error').html(data.responseJSON.errors.confirm);
                                    }
                                    if (data.responseJSON.errors.updated_at) {
                                        $('#updated_at-error').html(data.responseJSON.errors.updated_at);
                                    }
                                    if (data.responseJSON.errors.created_at) {
                                        $('#created_at-error').html(data.responseJSON.errors.created_at);
                                    }
                                    $('#btn-save').html('Save Changes');

                                }
                            });
                        }
                    });
                    $('body').on('click', '#delete-user', function (event) {
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var user_id = $(this).data("id");
                        if (confirm("Are you sure want to delete this field !")) {
                            $.ajax({
                                type: "GET",
                                url: "admin/user/destroy/" + user_id,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#id_" + user_id).remove();
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
                            url: 'user/search',
                            data: dataString,
                            success: function (data) {
                                $('#listItem').html(data);
                            },
                        });
                    });
                </script>
@endsection
