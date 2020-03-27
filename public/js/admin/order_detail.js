$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '#btn-back', function () {
        $('#ajax-crud-modal').hide();
    });
    $('.add-detail-order').click(function () {
        var order_id = $(this).data('id');
        $.get('admin/order/add_order_detail/' + order_id, function (data) {
            $("#order").html(data);
            $('#userCrudModal').html("Add New Order Detail");
            $('#btn-save').val("add-detail-order");
            $('#ajax-crud-modal').modal('show');
        });
    });
    $(document).on('change', '#selectProduct', function (event) {
        var product_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'admin/order/set_price',
            method: "post",
            data: {product_id: product_id},
            success: function (data) {
                if (data.price) {
                    $('#price_order_detail').attr('value', data.price);
                } else if (data.promotion_price) {
                    $('#price_order_detail').attr('value', data.promotion_price);
                } else {
                    $('#price_order_detail').attr('value', data);
                }
            }
        })
    });
    $('#add_order_detail').submit(function (event) {
        event.preventDefault();
        var order_id = $(this).data('id');
        var data = new FormData($('#add_order_detail_form')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'admin/order/add_order_detail_action/' + order_id,
            method: "POST",
            data: data,
            contentType: false,
            processData: false,
            success: function (res) {
                $('#showmess').html('Add successfully').attr('class', 'alert alert-success').css({'display': 'block'});
            },
            error: function (data) {
                if (data.responseJSON.errors) {
                    if (data.responseJSON.errors.product_id) {
                        $('#product_id-error').html(data.responseJSON.errors.product_id);
                    }
                    if (data.responseJSON.errors.sale_quantity) {
                        $('#sale_quantity-error').html(data.responseJSON.errors.sale_quantity);
                    }
                    if (data.responseJSON.errors.price) {
                        $('#price-error').html(data.responseJSON.errors.price);
                    }
                }
            }
        })
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
                url: "admin/order/delete_product_from_cart/" + order_detail_id,
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
    $(document).on('click', '.edit-order_detail', function () {
        var order_detail = $(this).data('id');
        $.get('admin/order/update_view_order_detail/' + order_detail, function (data) {
            $("#order").html(data);
            $('#userCrudModal').html("Edit Category");
            $('#btn-save').val("edit-cate");
            $('#ajax-crud-modal').modal('show');
        })
    });

    $(document).on('click', '#update_order_detail', function (event) {
        event.preventDefault();
        var form_data = new FormData($('#update_order_detail_form')[0]);
        if ($("#update_order_detail_form").length > 0) {
            var actionType = $('#update_order_detail').val();
            $('#update_order_detail').html('Sending...');
            $('#ajax-crud-modal').modal('hide');
            $.ajax({
                data: form_data,
                url: $('#update_order_detail_form').attr('action'),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {

                    $('#update_order_detail_form').trigger("reset");
                    $('#update_order_detail').html('Save Changes');
                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                },
                error: function (data) {
                    if (data.responseJSON.errors) {
                        if (data.responseJSON.errors.product_id) {
                            $('#product_id-error').html(data.responseJSON.errors.product_id);
                        }
                        if (data.responseJSON.errors.sale_quantity) {
                            $('#sale_quantity-error').html(data.responseJSON.errors.sale_quantity);
                        }
                        if (data.responseJSON.errors.price) {
                            $('#price-error').html(data.responseJSON.errors.price);
                        }
                        $('#update_order_detail').html('Save Changes');
                    }
                }
            });
        }
    });

});
