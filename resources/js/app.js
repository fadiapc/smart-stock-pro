import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

$(document).ready(function () {
    if (window.Echo) {
        Echo.channel('inventory-channel')
            .listen('.StockUpdated', function (data) {
                const stockElement = $('#stock-' + data.product_id);

                if (stockElement.length) {
                    stockElement.text(data.new_stock + ' unit');
                    stockElement.addClass('text-orange-500');
                    setTimeout(() => stockElement.removeClass('text-orange-500'), 2000);
                }

                const logEntry = $('<p>').text(
                    '[' + data.timestamp + '] ' + data.product_name +
                    ' terjual ' + data.sold_quantity +
                    ' unit | Sisa stok: ' + data.new_stock + ' unit'
                );
                $('#realtime-log').prepend(logEntry);
            });
    }

    $(document).on('click', '.sell-trigger', function () {
        const productId = $(this).data('product-id');
        const quantity = $(this).data('quantity');

        $.ajax({
            url: '/inventory/sell',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { product_id: productId, quantity: quantity },
            success: function (response) {
                if (response.success) {
                    $('#stock-' + productId).text(response.product.stock + ' unit');
                }
            },
            error: function (xhr) {
                alert(xhr.responseJSON?.message || 'Kesalahan server.');
            }
        });
    });
});
