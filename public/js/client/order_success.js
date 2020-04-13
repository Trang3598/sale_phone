$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#payoff').click(function (event) {
        $('.payment').val(1);
        var val = $('.payment').val();
        console.log(val);
        $.ajax({
            type: "POST",
            url: '../payment',
            data: {
                payment: val
            },
            success: function (data) {
                $('.mess-payment').css('display', 'block');
                $('.choosepayment').css('display', 'none');
                $('.mess-payment span b').text('Tiền mặt khi nhận hàng');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    $('.cathe').click(function (event) {
        $('.payment').val(2);
        var val = $('.payment').val();
        console.log(val);
        $.ajax({
            type: "POST",
            url: '../payment',
            data: {
                payment: val
            },
            success: function (data) {
                $('.mess-payment').css('display', 'block');
                $('.choosepayment').css('display', 'none');
                $('.mess-payment span b').text('Cà thẻ khi nhận hàng');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    $('body').on('click', '.deleteOrder', function (event) {
        event.preventDefault();
        $.ajax({
            type: "GET",
            url: "../cancel",
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.redirect) {
                    window.location = data.redirect;
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});
