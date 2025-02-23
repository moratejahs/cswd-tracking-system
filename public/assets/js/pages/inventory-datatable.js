$(function () {
    $("#inventoryRecord").DataTable({
        autowidth: false,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
        dom: '<"row"<"col-md-4"l><"col-md-4 text-center"B><"col-md-4"f>>t<"row"<"col-md-6"i><"col-md-6 d-flex justify-content-end"p>>',
        buttons: [
            {
                extend: "print",
                title: "",
                text: "Print",
                className: "btn btn-primary btn-sm",
            },
            {
                extend: "excel",
                title: "",
                text: "Excel",
                className: "btn btn-primary btn-sm",
            },
            {
                extend: "pdf",
                title: "",
                text: "PDF",
                className: "btn btn-primary btn-sm",
            },
        ],
        processing: true,
        serverSide: true,
        ajax: route("index.inventory"),
        columns: [
            {
                data: "code",
                name: "code",
                className: "text-center fw-bolder",
            },
            {
                data: "product_name",
                name: "product_name",
            },
            {
                data: "supplier_name",
                name: "supplier_name",
            },

            {
                data: "unit",
                name: "unit",
            },
            {
                data: "quantity",
                name: "quantity",
                className: "text-center",
            },
            {
                data: "cost_price",
                name: "cost_price",
                className: "text-center fw-bold",
                render: function (data, type, row) {
                    return "₱" + numberFormat(parseFloat(data), 2, ".", ",");
                },
            },
            {
                data: "sell_price",
                name: "sell_price",
                className: "text-center fw-bold",
                render: function (data, type, row) {
                    return "₱" + numberFormat(parseFloat(data), 2, ".", ",");
                },
            },
            {
                data: "sell_price_two",
                name: "sell_price_two",
                className: "text-center fw-bold",
                render: function (data, type, row) {
                    return "₱" + numberFormat(parseFloat(data), 2, ".", ",");
                },
            },
            {
                data: "status",
                name: "status",
                className: "text-center",
            },
            {
                data: "action",
                name: "action",
                className: "text-center",
            },
        ],
    });
});
