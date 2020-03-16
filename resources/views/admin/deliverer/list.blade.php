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
            @can('deliverer-create')
                <div style="padding-bottom:25px;float: right" class="btn-add">
                    <a href="javascript:void(0)" class="add-deliverer btn btn-info">Add New Deliverer</a>
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
                        <th>Phone</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        @can('deliverer-edit','deliverer-delete')
                            <th colspan="2">Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody id="listItem">
                    @if($deliverers)
                        @foreach($deliverers as $deliverer)
                            <tr id="id_{{ $deliverer->id }}">
                                <td id="deliverer_id_{{$deliverer->id}}">{{$deliverer->id}}</td>
                                <td id="deliverer_name_{{$deliverer->id}}">{{$deliverer->deliverer_name}}</td>
                                <td id="deliverer_phone_{{$deliverer->id}}">{{$deliverer->deliverer_phone}}</td>
                                <td id="created_at_{{$deliverer->id}}">{{$deliverer->created_at->format('d/m/Y')}}</td>
                                <td id="updated_at_{{$deliverer->id}}">{{$deliverer->updated_at->format('d/m/Y')}}</td>
                                @can('deliverer-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-deliverer btn btn-success"
                                               data-id="{{$deliverer->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('deliverer-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-deliverer"
                                           data-id="{{$deliverer->id}}"
                                           class="btn btn-danger delete-deliverer">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="padding-top: 20px">
                {!! $deliverers->appends(compact('items'))->links()!!}
            </div>
            @endsection
            @section('form-add')
                <div id="deliverer"></div>
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
                        $(document).on('click', '.add-deliverer', function () {
                            $.get('admin/deliverer/create', function (data) {
                                $("#deliverer").html(data);
                                $('#userCrudModal').html("Add New Deliverer");
                                $('#btn-save').val("add-deliverer");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                        $(document).on('click', '.edit-deliverer', function () {
                            var deliverer_id = $(this).data('id');
                            $.get('admin/deliverer/' + deliverer_id + '/edit', function (data) {
                                $("#deliverer").html(data);
                                $('#userCrudModal').html("Edit Deliverer");
                                $('#btn-save').val("edit-deliverer");
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
                                    var dataItem = '<tr id="id_' + data.id + '"><td>' + data.id + '</td><td>' + data.deliverer_name + '</td><td>' + data.deliverer_phone + '</td><td>' + data.created_at + '</td><td>' + data.updated_at + '</td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="edit-deliverer" data-id="' + data.id + '" class="btn btn-success mr-2">Update</a></td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="delete-deliverer" data-id="' + data.id + '" class="btn btn-danger delete-user ml-1">Delete</a></td></tr>';
                                    $('#listItem').append(dataItem);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#addForm').trigger("reset");
                                    $('#btn-save').html('Save Changes');
                                    $('#showmess').html('Add successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    console.log(data.responseJSON.errors);
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors) {
                                            $('#deliverer_name-error').html(data.responseJSON.errors.deliverer_name);
                                            $('#deliverer_phone-error').html(data.responseJSON.errors.deliverer_phone);
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
                                    $("#deliverer_name_" + data.id).html(data.deliverer_name);
                                    $("#deliverer_phone_" + data.id).html(data.deliverer_phone);
                                    $("#created_at_" + data.id).html(data.created_at);
                                    $("#updated_at_" + data.id).html(data.updated_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors.deliverer_name) {
                                            $('#deliverer_name-error').html(data.responseJSON.errors.deliverer_name);
                                        }
                                        if (data.responseJSON.errors.deliverer_phone) {
                                            $('#deliverer_phone-error').html(data.responseJSON.errors.deliverer_phone);
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
                    $('body').on('click', '#delete-deliverer', function (event) {
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var deliverer_id = $(this).data("id");
                        if (confirm("Are you sure want to delete this field !")) {
                            $.ajax({
                                type: "GET",
                                url: "admin/deliverer/destroy/" + deliverer_id,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#id_" + deliverer_id).remove();
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
                            url: 'deliverer/search',
                            data: dataString,
                            success: function (data) {
                                $('#listItem').html(data);
                            },
                        });
                    });
                </script>
@endsection
