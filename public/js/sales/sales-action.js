$(function () {
    $(document).on('click', '#edit-sales', function () {
        $('#saleUpdateForm').attr(
            'action',
            route('sales.update', $(this).data('sale-id'))
        );

        $.ajax({
            url: route('sales.edit', $(this).data('sale-id')),
            method: 'GET',
            success: function (response) {
                $('#editSaleProductId').val(response.product.id);
                $('#editProductName').html(response.product.product_name);
                $('#editProductCode').html(response.product.code);
                $('#editProductSupplier').html(response.product.supplier_name);
                $('#editProductRemainingQty').html(response.product.quantity);
                $('#editProductUnit').html(response.product.unit);
                $('#editProductCostPrice').html(response.product.cost_price);
                $('#editProductSalePrice').html(response.product.sell_price);
                $('#editQty').val(response.quantity);
                $('#editAmount').val(response.amount);
                // let productQuantity = response.product.quantity;

                if (response.sell_price_used === 'sell_price') {
                    $('#jhSalePrice').prop('checked', true);
                    $('#jmSalePrice').prop('checked', false);
                } else {
                    $('#jmSalePrice').prop('checked', true);
                    $('#jhSalePrice').prop('checked', false);
                }

                $('#jhSalePrice').val(response.product.sell_price);
                $('#jhSalePriceLabel').html(
                    response.product.sell_price + ' (J.H)'
                );
                $('#jmSalePrice').val(response.product.sell_price_two);
                $('#jmSalePriceLabel').html(
                    response.product.sell_price_two + ' (J.M)'
                );

                let prevProductQty = (
                    Number(response.quantity) +
                    Number(response.product.quantity)
                ).toFixed(2);

                let selectedPrice;
                selectedPrice = selectedPrice = $(
                    'input[name="sell_price"]:checked'
                ).val();

                $('input[name="sell_price"]').on('change', function () {
                    selectedPrice = $(this).val();
                    // console.log(selectedPrice);

                    let quantity = $('#editQty').val();
                    if (quantity > 0) {
                        $('#editAmount').val(
                            calcProductSaleAmount(
                                quantity,
                                response.product,
                                selectedPrice
                            )
                        );

                        $('.estimatedProfit ').text(
                            `Estimated Profit: ₱${calcProductSaleEstimatedProfit(
                                quantity,
                                response.product,
                                selectedPrice
                            )}`
                        );

                        let remainingQuantity = (
                            prevProductQty - quantity
                        ).toFixed(2);

                        $('.remainingQuantity').text(
                            `Remaining Quantity: ${remainingQuantity}`
                        );
                    }
                });

                let remainingQuantity = (
                    prevProductQty - response.quantity
                ).toFixed(2);

                $('.remainingQuantity').text(
                    `Remaining Quantity: ${remainingQuantity}`
                );

                $('.estimatedProfit ').text(
                    `Estimated Profit: ₱${calcProductSaleEstimatedProfit(
                        response.quantity,
                        response.product,
                        selectedPrice
                    )}`
                );

                $('#edit-sales-modal').modal('show');
                $('#editQty').on('input', function () {
                    let quantity = $(this).val();
                    let prevProductQty = (
                        Number(response.quantity) +
                        Number(response.product.quantity)
                    ).toFixed(2);

                    if (!isNaN(quantity) || quantity !== '') {
                        if (parseFloat(quantity) > parseFloat(prevProductQty)) {
                            $(this).val(prevProductQty);
                            quantity = prevProductQty;
                        }

                        $('#editAmount').val(
                            calcProductSaleAmount(
                                quantity,
                                response.product,
                                selectedPrice
                            )
                        );

                        $('.estimatedProfit ').text(
                            `Estimated Profit: ₱${calcProductSaleEstimatedProfit(
                                quantity,
                                response.product,
                                selectedPrice
                            )}`
                        );

                        let remainingQuantity = (
                            prevProductQty - quantity
                        ).toFixed(2);
                        $('.remainingQuantity').text(
                            `Remaining Quantity: ${remainingQuantity}`
                        );
                    }
                });

                $('#editAmount')
                    .off('input')
                    .on('input', function () {
                        let amount = $(this).val();
                        let quantity = $('#editQty').val();
                        let estimatedProfit = calcProductSaleEstimatedProfit(
                            quantity,
                            response.product,
                            selectedPrice,
                            amount
                        );
                        $('.estimatedProfit ').text(
                            `Estimated Profit: ₱${estimatedProfit}`
                        );
                    });
            },
            error: function (response) {
                console.log('Error:', response);
            },
        });
    });

    $(document).on('click', '#remove-sales', function () {
        $('#remove-sales-modal').modal('show');
        $('#saleDetroyForm').attr(
            'action',
            route('sales.destroy', $(this).data('sale-id'))
        );
    });

    $(document).on('click', '#remove-quick-sale', function () {
        $('#remove-quick-sale-modal').modal('show');
        $('#quickSaleDetroyForm').attr(
            'action',
            route('quick-sales.destroy', $(this).data('sale-id'))
        );
    });
});
