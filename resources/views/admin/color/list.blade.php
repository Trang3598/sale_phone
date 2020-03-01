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
            @can('color-create')
                <div style="padding-bottom:25px;float: right" class="btn-add">
                    <a href="javascript:void(0)" class="add-color btn btn-info">Add New Color</a>
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
                        <th>Product</th>
                        <th>Color Name</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        @can('color-edit','color-delete')
                            <th colspan="2">Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody id="listItem">
                    @if($colors)
                        @foreach($colors as $color)
                            <tr id="id_{{$color->id }}">
                                <td id="color_id_{{$color->id}}">{{$color->id}}</td>
                                <td id="product_id_{{$color->id}}">{{isset($color->product_id)?$color->product->name_phone:''}}</td>
                                <td id="color_name_{{$color->id}}">{{$color->color_name}}</td>
                                <td id="created_at_{{$color->id}}">{{$color->created_at->format('d/m/Y')}}</td>
                                <td id="updated_at_{{$color->id}}">{{$color->updated_at->format('d/m/Y')}}</td>
                                @can('color-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-color btn btn-success"
                                               data-id="{{$color->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('color-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-color"
                                           data-id="{{$color->id}}"
                                           class="btn btn-danger delete-color">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="padding-top: 20px">
                {!! $colors->appends(compact('items'))->links()!!}
            </div>
            @endsection
            @section('form-add')
                <div id="color"></div>
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
                        $(document).on('click', '.add-color', function () {
                            $.get('admin/color/create', function (data) {
                                $("#color").html(data);
                                $('#userCrudModal').html("Add New Color");
                                $('#btn-save').val("add-color");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                        $(document).on('click', '.edit-color', function () {
                            var color_id = $(this).data('id');
                            $.get('admin/color/' + color_id + '/edit', function (data) {
                                $("#color").html(data);
                                $('#userCrudModal').html("Edit Color");
                                $('#btn-save').val("edit-color");
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
                                    var dataItem = '<tr id="id_' + data.id + '"><td>' + data.id + '</td><td>' + data.name_phone + '</td><td>' + data.color_name + '</td><td>' + data.created_at + '</td><td>' + data.updated_at + '</td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="edit-color" data-id="' + data.id + '" class="btn btn-success mr-2">Update</a></td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="delete-color" data-id="' + data.id + '" class="btn btn-danger delete-user ml-1">Delete</a></td></tr>';
                                    $('#listItem').append(dataItem);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#addForm').trigger("reset");
                                    $('#btn-save').html('Save Changes');
                                    $('#showmess').html('Add successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors) {
                                            $('#product_id-error').html(data.responseJSON.errors.product_id);
                                            $('#color_name-error').html(data.responseJSON.errors.color_name);
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
                                    $("#product_id_" + data.id).html(data.product_id);
                                    $("#color_name_" + data.id).html(data.color_name);
                                    $("#created_at_" + data.id).html(data.created_at);
                                    $("#updated_at_" + data.id).html(data.updated_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors.product_id) {
                                            $('#product_id-error').html(data.responseJSON.errors.product_id);
                                        }
                                        if (data.responseJSON.errors.color_name) {
                                            $('#color_name-error').html(data.responseJSON.errors.color_name);
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
                    $('body').on('click', '#delete-color', function (event) {
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var color_id = $(this).data("id");
                        if (confirm("Are you sure want to delete this field !")) {
                            $.ajax({
                                type: "GET",
                                url: "admin/color/destroy/" + color_id,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#id_" + color_id).remove();
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
                            url: 'color/search',
                            data: dataString,
                            success: function (data) {
                                $('#listItem').html(data);
                            },
                        });
                    });
                </script>
@endsection
