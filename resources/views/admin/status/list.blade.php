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
            @can('status-create')
                <div style="padding-bottom:25px;float: right" class="btn-add">
                    <a href="javascript:void(0)" class="add-status btn btn-info">Add New Status</a>
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
                        <th>Status</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        @can('status-edit','status-delete')
                            <th colspan="2">Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody id="listItem">
                    @if($statuses)
                        @foreach($statuses as $status)
                            <tr id="id_{{ $status->id }}">
                                <td id="status_id_{{$status->id}}">{{$status->id}}</td>
                                <td id="status_name_{{$status->id}}">{{$status->status_name}}</td>
                                <td id="created_at_{{$status->id}}">{{$status->created_at->format('d/m/Y')}}</td>
                                <td id="updated_at_{{$status->id}}">{{$status->updated_at->format('d/m/Y')}}</td>
                                @can('status-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-status btn btn-success"
                                               data-id="{{$status->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('status-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-status"
                                           data-id="{{$status->id}}"
                                           class="btn btn-danger delete-status">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="padding-top: 20px">
                {!! $statuses->appends(compact('items'))->links()!!}
            </div>
            @endsection
            @section('form-add')
                <div id="status"></div>
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
                        $(document).on('click', '.add-status', function () {
                            $.get('admin/status/create', function (data) {
                                $("#status").html(data);
                                $('#userCrudModal').html("Add New Status");
                                $('#btn-save').val("add-status");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                        $(document).on('click', '.edit-status', function () {
                            var status_id = $(this).data('id');
                            $.get('admin/status/' + status_id + '/edit', function (data) {
                                $("#status").html(data);
                                $('#userCrudModal').html("Edit Status");
                                $('#btn-save').val("edit-status");
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
                                    var dataItem = '<tr id="id_' + data.id + '"><td>' + data.id + '</td><td>' + data.status_name + '</td><td>' + data.created_at + '</td><td>' + data.updated_at + '</td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="edit-status" data-id="' + data.id + '" class="btn btn-success mr-2">Update</a></td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="delete-status" data-id="' + data.id + '" class="btn btn-danger delete-user ml-1">Delete</a></td></tr>';
                                    $('#listItem').append(dataItem);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#addForm').trigger("reset");
                                    $('#btn-save').html('Save Changes');
                                    $('#showmess').html('Add successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        $('#status_name-error').html(data.responseJSON.errors.status_name);
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
                                    $("#status_name_" + data.id).html(data.status_name);
                                    $("#created_at_" + data.id).html(data.created_at);
                                    $("#updated_at_" + data.id).html(data.updated_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors.status_name) {
                                            $('#status_name-error').html(data.responseJSON.errors.status_name);
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
                    $('body').on('click', '#delete-status', function (event) {
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var status_id = $(this).data("id");
                        if (confirm("Are you sure want to delete this field !")) {
                            $.ajax({
                                type: "GET",
                                url: "admin/status/destroy/" + status_id,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#id_" + status_id).remove();
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
