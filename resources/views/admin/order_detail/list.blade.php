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
            @can('order_detail-create')
                <div style="padding-bottom:25px;float: right" class="btn-add">
                    <a href="javascript:void(0)" class="add-order_detail btn btn-info">Add New Order Detail</a>
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
                        <th>Ordering code</th>
                        <th>Product</th>
                        <th>Color</th>
                        <th>Sale Quantity</th>
                        <th>Price (VND)</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        @can('order_detail-edit','order_detail-delete')
                            <th colspan="2">Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody id="listItem">
                    @if($order_details)
                        @foreach($order_details as $order_detail)
                            <tr id="id_{{ $order_detail->id }}">
                                <td id="order_detail_id_{{$order_detail->id}}">{{$order_detail->id}}</td>
                                <td id="order_id_{{$order_detail->id}}">{{$order_detail->order_id}}</td>
                                <td id="product_id_{{$order_detail->id}}">{{isset($order_detail->product_id)?$order_detail->product->name_phone:''}}</td>
                                <td id="color_{{$order_detail->id}}">{{isset($order_detail->color_id)?$order_detail->color->color_name : ''}}</td>
                                <td id="sale_quantity_{{$order_detail->id}}">{{$order_detail->sale_quantity}}</td>
                                <td id="price_{{$order_detail->id}}">{{number_format($order_detail->price)}}</td>
                                <td id="created_at_{{$order_detail->id}}">{{$order_detail->created_at->format('d/m/Y')}}</td>
                                <td id="updated_at_{{$order_detail->id}}">{{$order_detail->updated_at->format('d/m/Y')}}</td>
                                @can('order_detail-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-order_detail btn btn-success"
                                               data-id="{{$order_detail->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('order_detail-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-order_detail"
                                           data-id="{{$order_detail->id}}"
                                           class="btn btn-danger delete-order_detail">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="padding-top: 20px">
                {!! $order_details->appends(compact('items'))->links()!!}
            </div>
            @endsection
            @section('form-add')
                <div id="order_detail"></div>
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
                        $(document).on('click', '.add-order_detail', function () {
                            $.get('admin/order_detail/create', function (data) {
                                $("#order_detail").html(data);
                                $('#userCrudModal').html("Add New Order Detail");
                                $('#btn-save').val("add-order_detail");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                        $(document).on('click', '.edit-order_detail', function () {
                            var order_detail_id = $(this).data('id');
                            $.get('admin/order_detail/' + order_detail_id + '/edit', function (data) {
                                $("#order_detail").html(data);
                                $('#userCrudModal').html("Edit Order Detail");
                                $('#btn-save').val("edit-order_detail");
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
                                    console.log(data);
                                    var dataItem = '<tr id="id_' + data.order_details.id + '"><td>' + data.order_details.id + '</td><td id="order_id_' + data.order_details.id + '">' + data.order_details.order_id + '</td><td id="name_phone_' + data.order_details.id + '">' + data.product.name_phone +
                                        '</td><td id="color_id_' + data.order_details.id + '">' + data.color.color_name + '</td><td id = "sale_quantity_' + data.order_details.id + '">' + data.order_details.sale_quantity +
                                        '</td><td id="price_' + data.order_details.id + '">' + data.order_details.price + '</td><td id = "created_at' + data.order_details.id + '">' + data.order_details.created_at
                                        + '</td><td id="updated_at_' + data.order_details.id + '">' + data.order_details.updated_at + '</td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="" data-id="' + data.order_details.id + '" class="edit-order_detail btn btn-success mr-2">Update</a></td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="delete-order_detail" data-id="' + data.order_details.id + '" class="btn btn-danger delete-user ml-1">Delete</a></td></tr>';
                                    $('#listItem').append(dataItem);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#addForm').trigger("reset");
                                    $('#btn-save').html('Save Changes');
                                    $('#showmess').html('Add successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        $('#order_id-error').html(data.responseJSON.errors.order_id);
                                        $('#product_id-error').html(data.responseJSON.errors.product_id);
                                        $('#color_id-error').html(data.responseJSON.errors.color_id);
                                        $('#sale_quantity-error').html(data.responseJSON.errors.sale_quantity);
                                        $('#price-error').html(data.responseJSON.errors.price);
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
                                    $("#order_id_" + data.order_details.id).html(data.order_details.order_id);
                                    $("#product_id_" + data.order_details.id).html(data.product.name);
                                    $("#color_id_" + data.order_details.id).html(data.color.color_name);
                                    $("#sale_quantity_" + data.order_details.id).html(data.order_details.sale_quantity);
                                    $("#price_" + data.order_details.id).html(data.order_details.price);
                                    $("#created_at_" + data.order_details.id).html(data.order_details.created_at);
                                    $("#updated_at_" + data.order_details.id).html(data.order_details.updated_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors.order_id) {
                                            $('#order_id-error').html(data.responseJSON.errors.order_id);
                                        }
                                        if (data.responseJSON.errors.product_id) {
                                            $('#product_id-error').html(data.responseJSON.errors.product_id);
                                        }
                                        if (data.responseJSON.errors.color_id) {
                                            $('#color_id-error').html(data.responseJSON.errors.color_id);
                                        }
                                        if (data.responseJSON.errors.sale_quantity) {
                                            $('#sale_quantity-error').html(data.responseJSON.errors.sale_quantity);
                                        }
                                        if (data.responseJSON.errors.price) {
                                            $('#price-error').html(data.responseJSON.errors.price);
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
                    $('body').on('click', '#delete-order_detail', function (event) {
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var order_detail_id = $(this).data("id");
                        if (confirm("Are you sure want to delete this field !")) {
                            $.ajax({
                                type: "GET",
                                url: "admin/order_detail/destroy/" + order_detail_id,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#id_" + order_detail_id).remove();
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
                            url: 'order_detail/search',
                            data: dataString,
                            success: function (data) {
                                $('#listItem').html(data);
                            },
                        });
                    });
                </script>
@endsection
