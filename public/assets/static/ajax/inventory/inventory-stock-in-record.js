$(body).on("click", "#add-product-stock-in", function () {
    var url = $(this).data("url");
    const f = new Intl.NumberFormat("en-us", {
        currency: "USD",
    });
    $.get(url, function (data) {
        $("#product-stock-in-modal").modal("show");
        $("#product-stock-in-id").val(data.product_id);
        $("#product-stock-quantity-val").val(data.quantity);
        $('#product-view-stock-in-product-code').text(data.product_code);
        $("#product-stock-in-product_name").text(data.product_name);
        $("#product-stock-in-quantity").text(data.quantity);
        $("#product-stock-in-unit").text(data.unit);
        $("#product-stock-in-sell-price").text(f.format(data.sell_price));
        $("#product-stock-in-sell-price-two").text(f.format(data.sell_price_two));
        $("#product-stock-in-cost-price").text(f.format(data.cost_price));
        $("#product-stock-in-category").text(data.category_name);
    });
});

$(body).on("click", "#edit-product-stock-in", function () {
    var url = $(this).data("url");
    const f = new Intl.NumberFormat("en-us", {
        currency: "USD",
    });
    $.get(url, function (data) {
        $("#edit-product-stock-in-modal").modal("show");
        $("#product-view-stock-in-id").val(data.product_id);
        $("#product-view-stock-quantity").val(data.quantity);
        $("#product-view-stock-in-product_name").text(data.product_name);
        $("#product-view-stock-in-unit").text(data.unit);
        $('#product-view-stock-in-product-code').text(data.product_code);
        $("#product-view-stock-in-sell-price").text(f.format(data.sell_price));
        $("#product-view-stock-in-cost-price").text(f.format(data.cost_price));
        $("#product-view-stock-in-category").text(data.category_name);
    });
});

$(body).on("click", "#remove-product", function () {
    var url = $(this).data("url");
    $.get(url, function (data) {
        $("#remove-product-modal").modal("show");
        $("#remove-id").val(data.product_id);
    });
});

$(body).on("click", "#restore-product", function () {
    var url = $(this).data("url");
    $.get(url, function (data) {
        $("#restore-product-modal").modal("show");
        $("#restore-id").val(data.product_id);
    });
});
