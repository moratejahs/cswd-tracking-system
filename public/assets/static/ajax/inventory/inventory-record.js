$(body).on('click', '#edit-product', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#edit-product-modal').modal('show');
        $('#product-id').val(data.product_id);
        $('#product-code').text(data.product_code);
        $('#product-product_name').val(data.product_name);
        $('#product-quantity').val(data.quantity);
        $('#product-unit').val(data.unit);
        $('#product-sell_price').val(data.sell_price);
        $('#product-sell_price_two').val(data.sell_price_two);
        $('#product-cost_price').val(data.cost_price);
        $('#product-category-id').val(data.category_id);
    });
});

$(body).on('click', '#edit-sales', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#edit-sales-modal').modal('show');
        $('#edit-sale-id').val(data.sales_id);
        $('#edit-product-id').val(data.product_id);
        $('#edit-sale-qty').val(data.sales_quantity);
        $('#edit-sale-amount').val(data.sales_amount);
    });
});

$(body).on('click', '#remove-sales', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#remove-sales-modal').modal('show');
        $('#remove-sale-id').val(data.sales_id);
    });
});

$(body).on('click', '#restore-sales', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#restore-sales-modal').modal('show');
        $('#restore-sale-id').val(data.sales_id);
    });
});
