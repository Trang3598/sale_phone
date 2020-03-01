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
            @can('role-create')
                <div style="padding-bottom:25px;float: right" class="btn-add">
                    <a href="javascript:void(0)" class="add-role btn btn-info">Add New Role</a>
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
                        <th>Name</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        <th colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody id="listItem">
                    @if($roles)
                        @foreach($roles as $role)
                            <tr id="id_{{ $role->id }}">
                                <td id="role_id_{{$role->id}}">{{$role->id}}</td>
                                <td id="name_{{$role->id}}">{{$role->name}}</td>
                                <td id="created_at_{{$role->id}}">{{$role->created_at->format('d/m/Y')}}</td>
                                <td id="updated_at_{{$role->id}}">{{$role->updated_at->format('d/m/Y')}}</td>
                                @can('role-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-role btn btn-success"
                                               data-id="{{$role->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('role-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-role"
                                           data-id="{{$role->id}}"
                                           class="btn btn-danger delete-role">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="padding-top: 20px">
                {!! $roles->appends(compact('items'))->links()!!}
            </div>
            @endsection
            @section('form-add')
                <div id="role"></div>
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
                        $(document).on('click', '.add-role', function () {
                            $.get('admin/role/create', function (data) {
                                $("#role").html(data);
                                $('#userCrudModal').html("Add New Role");
                                $('#btn-save').val("add-role");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                        $(document).on('click', '.edit-role', function () {
                            var role_id = $(this).data('id');
                            $.get('admin/role/' + role_id + '/edit', function (data) {
                                $("#role").html(data);
                                $('#userCrudModal').html("Edit Role");
                                $('#btn-save').val("edit-role");
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
                                    var dataItem = '<tr id="id_' + data.id + '"><td>' + data.id + '</td><td>' + data.name + '</td><td>' + data.created_at + '</td><td>' + data.updated_at + '</td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="edit-role" data-id="' + data.id + '" class="btn btn-success mr-2">Update</a></td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="delete-role" data-id="' + data.id + '" class="btn btn-danger delete-role ml-1">Delete</a></td></tr>';
                                    $('#listItem').append(dataItem);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#addForm').trigger("reset");
                                    $('#btn-save').html('Save Changes');
                                    $('#showmess').html('Add successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        $('#name-error').html(data.responseJSON.errors.name);
                                        $('#created_at-error').html(data.responseJSON.errors.created_at);
                                        $('#updated_at-error').html(data.responseJSON.errors.updated_at);
                                        $('#guard_name-error').html(data.responseJSON.errors.guard_name);
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
                                    $("#name_" + data.id).html(data.name);
                                    $("#created_at_" + data.id).html(data.created_at);
                                    $("#updated_at_" + data.id).html(data.updated_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors.name) {
                                            $('#name-error').html(data.responseJSON.errors.name);
                                        }
                                        if (data.responseJSON.errors.guard_name) {
                                            $('#name-error').html(data.responseJSON.errors.guard_name);
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
                    $('body').on('click', '#delete-role', function (event) {
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var role_id = $(this).data("id");
                        if (confirm("Are you sure want to delete this field !")) {
                            $.ajax({
                                type: "GET",
                                url: "admin/role/destroy/" + role_id,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#id_" + role_id).remove();
                                    $('#showmess').html('Delete successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    console.log('Error:', data);
                                }
                            });
                        }
                    });
                </script>
@endsection
