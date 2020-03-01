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
            @can('sale_phone-create')
                <div style="padding-bottom:25px;float: right" class="btn-add">
                    <a href="javascript:void(0)" class="add-sale_phone btn btn-info">Add New Sale Phone</a>
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
                        <th>Quantity</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        @can('sale_phone-edit','sale_phone-delete')
                            <th colspan="2">Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody id="listItem">
                    @if($sale_phones)
                        @foreach($sale_phones as $sale_phone)
                            <tr id="id_{{ $sale_phone->id }}">
                                <td id="id_{{$sale_phone->id}}">{{$sale_phone->id}}</td>
                                <td id="phone_id_{{$sale_phone->id}}">{{isset($sale_phone->phone_id)? $sale_phone->product->name_phone: ''}}</td>
                                <td id="quantity_{{$sale_phone->id}}">{{$sale_phone->quantity}}</td>
                                <td id="created_at_{{$sale_phone->id}}">{{$sale_phone->created_at->format('d/m/Y')}}</td>
                                <td id="updated_at_{{$sale_phone->id}}">{{$sale_phone->updated_at->format('d/m/Y')}}</td>
                                @can('sale_phone-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-sale_phone btn btn-success"
                                               data-id="{{$sale_phone->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('sale_phone-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-sale_phone"
                                           data-id="{{$sale_phone->id}}"
                                           class="btn btn-danger delete-category">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="padding-top: 20px">
                {!! $sale_phones->appends(compact('items'))->links()!!}
            </div>
            @endsection
            @section('form-add')
                <div id="sale_phone"></div>
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
                        $(document).on('click', '.add-sale_phone', function () {
                            $.get('admin/sale_phone/create', function (data) {
                                $("#sale_phone").html(data);
                                $('#userCrudModal').html("Add New Sale Phone");
                                $('#btn-save').val("add-sale_phone");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                        $(document).on('click', '.edit-sale_phone', function () {
                            var sale_phone_id = $(this).data('id');
                            $.get('admin/sale_phone/' + sale_phone_id + '/edit', function (data) {
                                $("#sale_phone").html(data);
                                $('#userCrudModal').html("Edit Sale Phone");
                                $('#btn-save').val("edit-sale_phone");
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
                                    var dataItem = '<tr id="id_' + data.id + '"><td>' + data.id + '</td><td>' + data.phone_id + '</td><td>' + data.quantity + '</td><td>' + data.created_at + '</td><td>' + data.updated_at + '</td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="edit-sale_phone" data-id="' + data.id + '" class="btn btn-success mr-2">Update</a></td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="delete-sale_phone" data-id="' + data.id + '" class="btn btn-danger delete-user ml-1">Delete</a></td></tr>';
                                    $('#listItem').append(dataItem);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#addForm').trigger("reset");
                                    $('#btn-save').html('Save Changes');
                                    $('#showmess').html('Add successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors) {
                                            $('#phone_id-error').html(data.responseJSON.errors.phone_id);
                                            $('#quantity-error').html(data.responseJSON.errors.quantity);
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
                                    $("#phone_id_" + data.id).html(data.phone_id);
                                    $("#quantity_" + data.id).html(data.quantity);
                                    $("#created_at_" + data.id).html(data.created_at);
                                    $("#updated_at_" + data.id).html(data.updated_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors.phone_id) {
                                            $('#phone_id-error').html(data.responseJSON.errors.phone_id);
                                        }
                                        if (data.responseJSON.errors.quantity) {
                                            $('#quantity-error').html(data.responseJSON.errors.quantity);
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
                    $('body').on('click', '#delete-sale_phone', function (event) {
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var sale_phone_id = $(this).data("id");
                        if (confirm("Are you sure want to delete this field !")) {
                            $.ajax({
                                type: "GET",
                                url: "admin/sale_phone/destroy/" + sale_phone_id,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#id_" + sale_phone_id).remove();
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
                            url: 'sale_phone/search',
                            data: dataString,
                            success: function (data) {
                                $('#listItem').html(data);
                            },
                        });
                    });
                </script>
@endsection
