$(body).on('click', '#edit-saless', function() {
    var url = $(this).data('url');
    $.get(url, function(data) {
        $('#edit-sales-modal').modal('show');
        $('#edit-sale-id').val(data.sales_id);
        $('#edit-product-id').val(data.product_id);
        $('#edit-sale-qty').val(data.sales_quantity);
        $('#edit-sale-amount').val(data.sales_amount);
    })
});

$(body).on('click', '#remove-sales', function() {
    var url = $(this).data('url');
    $.get(url, function(data) {
        $('#remove-sales-modal').modal('show');
        $('#remove-sale-id').val(data.sales_id);
    })
});
$(body).on('click', '#restore-sales', function() {
    var url = $(this).data('url');
    $.get(url, function(data) {
        $('#restore-sales-modal').modal('show');
        $('#restore-sale-id').val(data.sales_id);
    })
});
