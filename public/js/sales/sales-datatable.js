$(function () {
    $("#sales-record").DataTable({
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: route("sales.index"),
        columns: [
            {
                data: "code",
                name: "products.code",
                className: "text-center fw-bolder",
                render: function (data, type, row) {
                    return data ? data : "N/A";
                },
            },
            {
                data: "product_name",
                name: "products.product_name",
                className: "fst-italic",
            },
            {
                data: "supplier_name",
                name: "products.supplier_name",
                render: function (data, type, row) {
                    return data ? data : "N/A";
                },
            },
            // {
            //     data: "category_name",
            //     name: "categories.category_name",
            // },
            {
                data: "unit",
                name: "products.unit",
                className: "text-center",
                render: function (data, type, row) {
                    return data ? data : "N/A";
                },
            },
            {
                data: "quantity",
                name: "sales.quantity",
                className: "text-center",
            },
            {
                data: "unit_price",
                name: "unit_price",
                className: "text-center",
            },
            {
                data: "amount",
                name: "sales.amount",
                className: "text-center",
            },
            {
                data: "sale_date",
                name: "sales.sale_date",
                className: "text-center",
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
                className: "text-center",
            },
        ],
    });
});
