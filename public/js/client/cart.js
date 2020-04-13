function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('body').on('click', '#delete_product', function (event) {
        event.preventDefault();
        var product_id = $(this).data("id");
        if (confirm("Are you sure want to delete this field !")) {
            $.ajax({
                type: "GET",
                url: "cart/delete/" + product_id,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#item_" + product_id).remove();
                    if (data.redirect) {
                        window.location = data.redirect;
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });
    var total, quantity, priceValue, discount, Discount, real_pay;
    $(".augment").click(function (e) {
        var id = $(this).attr('id').substring($(this).attr('id').indexOf("_") + 1, $(this).attr('id').length);
        $(this).prev().val(+$(this).prev().val() + 1);
        quantity = $(this).prev().val();
        priceValue = $(this).closest('.choosenumber').find('.price').data("value");
        discount = $(this).closest('.choosenumber').find('.discount').data("value");
        total = quantity * priceValue;
        Discount = quantity * discount;
        $('#price_' + id).val(total);
        $('#discount_' + id).val(Discount);
        sale_quantity = $(this).closest('.choosenumber').find('.sale_quantity').data("value");
        $('#sale_quantity_' + id).val(quantity);
        var total_price = 0;
        var totalDiscount = 0;
        var totalItems = document.querySelectorAll(".price");
        var totalItemsDiscount = document.querySelectorAll(".discount");
        for (i = 0; i < totalItems.length; i++) {
            total_price += parseInt(totalItems[i].value, 10);
        }
        for (i = 0; i < totalItemsDiscount.length; i++) {
            totalDiscount += parseInt(totalItemsDiscount[i].value, 10);
        }
        $('.total_price').text(formatNumber(total_price) + "₫");
        $('.total_discount').text(formatNumber(totalDiscount) + "₫");
        real_pay = formatNumber(total_price - totalDiscount);
        $('.pay_total').text(real_pay + "₫");
        $('.total_pay').val(total_price - totalDiscount);
    });
    $(".abate").click(function () {
        var id = $(this).attr('id').substring($(this).attr('id').indexOf("_") + 1, $(this).attr('id').length);
        if ($(this).next().next().val() > 1) {
            $(this).next().next().val(+$(this).next().next().val() - 1);
            quantity = $(this).next().next().val();
            priceValue = $(this).closest('.choosenumber').find('.price').data("value");
            discount = $(this).closest('.choosenumber').find('.discount').data("value");
            total = quantity * priceValue;
            Discount = quantity * discount;
            $('#price_' + id).val(total);
            $('#discount_' + id).val(Discount);
            $('#sale_quantity_' + id).attr('value', quantity);
            var total_price = 0;
            var totalDiscount = 0;
            var totalItems = document.querySelectorAll(".price");
            var totalItemsDiscount = document.querySelectorAll(".discount");
            for (i = 0; i < totalItems.length; i++) {
                total_price += parseInt(totalItems[i].value, 10);
            }
            for (i = 0; i < totalItemsDiscount.length; i++) {
                totalDiscount += parseInt(totalItemsDiscount[i].value, 10);
            }
            $('.total_price').text(formatNumber(total_price) + "₫");
            $('.total_discount').text(formatNumber(totalDiscount) + "₫");
            real_pay = formatNumber(total_price - totalDiscount);
            $('.pay_total').text(real_pay + "₫");
            $('.total_pay').val(total_price - totalDiscount);
        }
    });
    $(document).on('click', '.payoffline', function (event) {
        event.preventDefault();
        var form_data = new FormData($('#formtest')[0]);
        form_data.append('_method', 'post');
        if ($("#formtest").length > 0) {
            $.ajax({
                data: form_data,
                url: $('#formtest').attr('action'),
                type: "POST",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.redirect) {
                        window.location = data.redirect;
                    }
                },
                error: function (data) {
                    if (data.responseJSON.errors) {
                        $('#customer_name-error').html(data.responseJSON.errors.customer_name);
                        $('#customer_phone-error').html(data.responseJSON.errors.customer_phone);
                        $('#customer_email-error').html(data.responseJSON.errors.customer_email);
                        $('#note-error').html(data.responseJSON.errors.note);
                        $('#delivery_address-error').html(data.responseJSON.errors.delivery_address);
                        $('#color_id-error').html(data.responseJSON.errors.color_id);
                    }
                    $('#btn-save').html('Save Changes');
                }
            });
        }
    });
    var count = 0;
    $('.change').click(function (event) {
        event.preventDefault();
        count++;
        if (count % 2 === 0) {
            $('#updateInfor').css('display', 'block');
        } else {
            $('#updateInfor').css('display', 'none');
        }
    });
});


