function resetSalesCreateForm() {
    $("#product-name").val("").trigger("change");
    $("#product-details").html("");
    $("#product-details").css("height", "0px");
    $("#qty").val("");
    $("#amount").val("");
    $("#estimatedProfit").val("");
    $("#remainingQuantity").val("");
    $(".estimatedProfit").text("");
    $(".remainingQuantity").text("");
    $("#qty").prop("disabled", true);
    $("#amount").prop("disabled", true);
    $(".save-button").prop("disabled", true);
}

function calcProductSaleEstimatedProfit(
    quantity,
    product,
    selectedPrice,
    amount = 0
) {
    let estimatedProfit = quantity * (selectedPrice - product.cost_price);

    if (amount > 0) {
        estimatedProfit = amount - quantity * product.cost_price;
    }

    return estimatedProfit.toFixed(2);
}

function calcProductSaleAmount(quantity, product, selectedPrice) {
    return (quantity * selectedPrice).toFixed(2);
}

$(function () {
    $(".sale-select-2").select2({
        placeholder: "Select Product",
        dropdownParent: "#store-sale-modal",
    });

    $(".close-button").on("click", function () {
        resetSalesCreateForm();
    });

    $("#qty").prop("disabled", true);
    $("#amount").prop("disabled", true);
    $(".save-button").prop("disabled", true);

    function buildProductDescription(product) {
        return `
            <div class="row px-3">
                <div class="col-12">
                <div>
                    <small class="text-muted">Product Description</small>
                    <input type="hidden" id="product-stock-in-id" name="id" value="${
                        product.id
                    }">
                    <input type="hidden" id="product-stock-quantity-val" name="val_quantity" value="${
                        product.quantity
                    }">
                </div>
                <div>
                    <h5 class="fst-italic text-secondary"><label id="product-stock-in-product_name">${
                        product.product_name
                    }</label></h5>
                </div>
                <div>
                    <span class="text-muted"><small>Code:</small></span>
                    <small><span class="badge bg-success"><label id="product-view-stock-in-product-code">${
                        product.code
                    }</label></span></small>
                </div>
                <div>
                    <span class="text-muted"><small>Supplier:</small></span>
                    <small><label id="product-stock-in-category">${
                        product.supplier_name
                    }</label></small>
                </div>
            </div>
            <div class="col-6 pt-2">
                <span class="text-muted"><small>Remaining Qty:</small></span>
                <label id="product-stock-in-quantity">${
                    product.quantity
                }</label>
            </div>
            <div class="col-6 pt-2">
                <span class="text-muted"><small>Unit:</small></span>
                <label id="product-stock-in-unit">${product.unit}</label>
            </div>
            <div class="col-6 pt-2">
                <span class="text-muted"><small>Cost Price:</small></span>
                <span style="font-weight: 700;"><label id="product-stock-in-cost-price">${
                    product.cost_price
                }</label></span>
            </div>
            <div class="col-6 pt-2">
                <span class="text-muted"><small>Sale Price:</small></span>
                    <input type="hidden" name="sell_price_used">
                    <div class="d-flex">
                    <div class="me-4">
                    <input type="radio" id="jhSalePrice" name="sell_price" value="${
                        product.sell_price
                    }" checked>
                    <label style="font-weight: 700;" for="jhSalePrice">${product.sell_price.toFixed(
                        2
                    )} (J.H)</label><br>
                    </div>

                    <div>
                    <input type="radio" id="jmSalePrice" name="sell_price" value="${
                        product.sell_price_two
                    }">
                    <label style="font-weight: 700;" for="jmSalePrice">${product.sell_price_two.toFixed(
                        2
                    )} (J.M)</label>
                    </div>
                    </div>

            </div>
            </div>
        `;
    }

    $("#product-name").on("change", function () {
        $("#product-details").html(``);

        $("#product-details").css("height", "200px");
        $("#product-details").html(`
            <div style="display: flex; align-items: center; justify-content: center; height: 200px;">
                <div class="spinner-border text-primary" role="status"></div>
            </div>
        `);

        $("#qty").val("");
        $("#amount").val("");

        const productId = $(this).val();
        $("#qty").prop("disabled", false);
        $("#amount").prop("disabled", false);
        $(".save-button").prop("disabled", false);

        $.ajax({
            url: route("product.details", ":productId").replace(
                ":productId",
                productId
            ),
            type: "GET",
            dataType: "json",
            success: function (response) {
                $("#product-details").html(``);
                $("#product-details").css("height", "200px");
                $("#product-details").html(buildProductDescription(response));
                let productQuantity = response.quantity;

                let selectedPrice;
                selectedPrice = selectedPrice = $(
                    'input[name="sell_price"]:checked'
                ).val();

                let salePriceUsed;
                if ($("#jhSalePrice").is(":checked")) {
                    salePriceUsed = "sell_price";
                } else {
                    salePriceUsed = "sell_price_two";
                }

                $('input[name="sell_price_used"]').val(salePriceUsed);

                $('input[name="sell_price"]').on("change", function () {
                    selectedPrice = $(this).val();
                    let salePriceUsed;
                    if ($("#jhSalePrice").is(":checked")) {
                        salePriceUsed = "sell_price";
                    } else {
                        salePriceUsed = "sell_price_two";
                    }
                    $('input[name="sell_price_used"]').val(salePriceUsed);

                    let quantity = $("#qty").val();
                    // console.log(quantity);
                    if (quantity > 0) {
                        $("#amount").val(
                            calcProductSaleAmount(
                                quantity,
                                response,
                                selectedPrice
                            )
                        );

                        $(".estimatedProfit ").text(
                            `Estimated Profit: ₱${calcProductSaleEstimatedProfit(
                                quantity,
                                response,
                                selectedPrice
                            )}`
                        );

                        let remainingQuantity = (
                            productQuantity - quantity
                        ).toFixed(2);

                        $(".remainingQuantity").text(
                            `Remaining Quantity: ${remainingQuantity}`
                        );
                    }
                });

                $("#qty")
                    .off("input")
                    .on("input", function () {
                        let quantity = $(this).val();
                        if (
                            parseFloat(quantity) > parseFloat(productQuantity)
                        ) {
                            $(this).val(productQuantity);
                            quantity = productQuantity;
                        }
                        $("#amount").val(
                            calcProductSaleAmount(
                                quantity,
                                response,
                                selectedPrice
                            )
                        );

                        $(".estimatedProfit ").text(
                            `Estimated Profit: ₱${calcProductSaleEstimatedProfit(
                                quantity,
                                response,
                                selectedPrice
                            )}`
                        );

                        let remainingQuantity = (
                            productQuantity - quantity
                        ).toFixed(2);
                        $(".remainingQuantity").text(
                            `Remaining Quantity: ${remainingQuantity}`
                        );
                    });

                $("#amount")
                    .off("input")
                    .on("input", function () {
                        let amount = $(this).val();
                        let quantity = $("#qty").val();
                        let estimatedProfit = calcProductSaleEstimatedProfit(
                            quantity,
                            response,
                            selectedPrice,
                            amount
                        );
                        $(".estimatedProfit ").text(
                            `Estimated Profit: ₱${estimatedProfit}`
                        );
                    });
            },
            error: function (response) {
                console.log("Error:", response);
            },
        });
    });
});
