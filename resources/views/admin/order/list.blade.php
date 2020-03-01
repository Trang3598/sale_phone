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
            @can('order-create')
                <div style="padding-bottom:25px;float: right" class="btn-add">
                    <a href="javascript:void(0)" class="add-order btn btn-info">Add New Order</a>
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
                        <th>Customer Name</th>
                        <th>Customer Phone</th>
                        <th>Customer Email</th>
                        <th>Status</th>
                        <th>Deliverer</th>
                        <th>Total Price</th>
                        <th>Delivery Address</th>
                        <th>Note</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        <th colspan="3">Action</th>
                    </tr>
                    </thead>
                    <tbody id="listItem">
                    @if($orders)
                        @foreach($orders as $order)
                            <tr id="id_{{$order->id}}">
                                <td id="order_id_{{$order->id}}">{{$order->id}}</td>
                                <td id="customer_name_{{$order->id}}">{{$order->customer_name}}</td>
                                <td id="customer_phone_{{$order->id}}">{{$order->customer_phone}}</td>
                                <td id="customer_email_{{$order->id}}">{{$order->customer_email}}</td>
                                <td id="status_id_{{$order->id}}">{{isset($order->status)? $order->status->status_name:''}}</td>
                                <td id="deliverer_id_{{$order->id}}">{{isset($order->deliverer)? $order->deliverer->deliverer_name:''}}</td>
                                <td id="total_price_{{$order->id}}">{{$order->total_price}}</td>
                                <td id="delivery_address_{{$order->id}}">{{$order->delivery_address}}</td>
                                <td id="note_{{$order->id}}">{{$order->note}}</td>
                                <td id="created_at_{{$order->id}}">{{$order->created_at->format('d/m/Y')}}</td>
                                <td id="updated_at_{{$order->id}}">{{$order->updated_at->format('d/m/Y')}}</td>
                                <td>
                                    <a href="javascript:void(0)" id="detail-order"
                                       data-id="{{$order->id}}"
                                       class="btn btn-warning detail-order">See Detail</a>
                                </td>
                                @can('order-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-order btn btn-success"
                                               data-id="{{$order->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('order-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-order"
                                           data-id="{{$order->id}}"
                                           class="btn btn-danger delete-order">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="padding-top: 20px">
                {!! $orders->appends(compact('items'))->links()!!}
            </div>
            @endsection
            @section('form-add')
                <div id="order"></div>
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
                        $(document).on('click', '.add-order', function () {
                            $.get('admin/order/create', function (data) {
                                $("#order").html(data);
                                $('#userCrudModal').html("Add New Order");
                                $('#btn-save').val("add-order");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                        $(document).on('click', '.edit-order', function () {
                            var order_id = $(this).data('id');
                            $.get('admin/order/' + order_id + '/edit', function (data) {
                                $("#order").html(data);
                                $('#userCrudModal').html("Edit Order");
                                $('#btn-save').val("edit-order");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                        $(document).on('click', '.detail-order', function () {
                            var order_id = $(this).data('id');
                            $.get('order/' + order_id + '/detail', function (data) {
                                $("#order").html(data);
                                $('#userCrudModal').html("Detail Order");
                                $('#btn-save').val("detail-order");
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
                                    var dataItem = '<tr id="id_' + data.id + '"><td>' + data.id + '</td><td>' + data.customer_name +
                                        '</td><td>' + data.customer_phone + '</td><td>' + data.customer_email + '</td><td>' + data.status_id + '</td><td>' + data.deliverer_id + '</td><td>' + data.total_price +
                                        '</td><td>' + data.delivery_address + '</td><td>' + data.created_at + '</td><td>' + data.updated_at + '</td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="edit-order" data-id="' + data.id + '" class="btn btn-success mr-2">Update</a></td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="delete-order" data-id="' + data.id + '" class="btn btn-danger delete-user ml-1">Delete</a></td></tr>';
                                    $('#listItem').append(dataItem);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#addForm').trigger("reset");
                                    $('#btn-save').html('Save Changes');
                                    $('#showmess').html('Add successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        $('#customer_name-error').html(data.responseJSON.errors.customer_name);
                                        $('#customer_phone-error').html(data.responseJSON.errors.customer_phone);
                                        $('#customer_email-error').html(data.responseJSON.errors.customer_email);
                                        $('#status_id-error').html(data.responseJSON.errors.status_id);
                                        $('#deliverer_id-error').html(data.responseJSON.errors.deliverer_id);
                                        $('#total_price-error').html(data.responseJSON.errors.total_price);
                                        $('#delivery_address-error').html(data.responseJSON.errors.delivery_address);
                                        $('#note-error').html(data.responseJSON.errors.note);
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
                                    $("#customer_name_" + data.id).html(data.customer_name);
                                    $("#customer_phone_" + data.id).html(data.customer_phone);
                                    $("#customer_email_" + data.id).html(data.customer_email);
                                    $("#status_id_" + data.id).html(data.status_id);
                                    $("#deliverer_id" + data.id).html(data.deliverer_id);
                                    $("#total_price_" + data.id).html(data.total_price);
                                    $("#delivery_address_" + data.id).html(data.delivery_address);
                                    $("#note_" + data.id).html(data.note);
                                    $("#created_at_" + data.id).html(data.created_at);
                                    $("#updated_at_" + data.id).html(data.updated_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors.customer_name) {
                                            $('#customer_name-error').html(data.responseJSON.errors.customer_name);
                                        }
                                        if (data.responseJSON.errors.customer_phone) {
                                            $('#customer_phone-error').html(data.responseJSON.errors.customer_phone);
                                        }
                                        if (data.responseJSON.errors.customer_email) {
                                            $('#customer_email-error').html(data.responseJSON.errors.customer_email);
                                        }
                                        if (data.responseJSON.errors.status_id) {
                                            $('#status_id-error').html(data.responseJSON.errors.status_id);
                                        }
                                        if (data.responseJSON.errors.deliverer_id) {
                                            $('#deliverer_id-error').html(data.responseJSON.errors.deliverer_id);
                                        }
                                        if (data.responseJSON.errors.total_price) {
                                            $('#total_price-error').html(data.responseJSON.errors.total_price);
                                        }
                                        if (data.responseJSON.errors.delivery_address) {
                                            $('#delivery_address-error').html(data.responseJSON.errors.delivery_address);
                                        }
                                        if (data.responseJSON.errors.note) {
                                            $('#note-error').html(data.responseJSON.errors.note);
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
                    $('body').on('click', '#delete-order', function (event) {
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var order_id = $(this).data("id");
                        if (confirm("Are you sure want to delete this field !")) {
                            $.ajax({
                                type: "GET",
                                url: "admin/order/destroy/" + order_id,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#id_" + order_id).remove();
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
                            url: 'order/search',
                            data: dataString,
                            success: function (data) {
                                $('#listItem').html(data);
                            },
                        });
                    });
                </script>
@endsection
