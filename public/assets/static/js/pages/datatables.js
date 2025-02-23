let jquery_datatable_inventory = $('#inventory-record').DataTable({
    responsive: true,
    language: {
        search: '',
        searchPlaceholder: 'Search..',
        lengthMenu: '_MENU_ ',
    },
});

let jquery_datatable_inventory_supplier = $('#supplier-record').DataTable({
    responsive: true,
    language: {
        search: '',
        searchPlaceholder: 'Search..',
        lengthMenu: '_MENU_ ',
    },
});

let jquery_datatable_category = $('#inventory-category').DataTable({
    responsive: true,
    language: {
        search: '',
        searchPlaceholder: 'Search..',
    },
});
let jquery_datatable_restore_product = $('#restore-inventory-record').DataTable(
    {
        responsive: true,
        language: {
            search: '',
            searchPlaceholder: 'Search..',
        },
    }
);
let jquery_datatable_sales = $('#sales-record').DataTable({
    responsive: true,
    language: {
        search: '',
        searchPlaceholder: 'Search..',
    },
});
let jquery_datatable_sales_restore = $('#restore-sales-record').DataTable({
    responsive: true,
    language: {
        search: '',
        searchPlaceholder: 'Search..',
    },
});

let jquery_datatable_product_inventory_stock_in = $(
    '#product-inventory-stock-in-record'
).DataTable({
    responsive: true,
    language: {
        search: '',
        searchPlaceholder: 'Search..',
    },
});

let customized_datatable = $('#table3').DataTable({
    responsive: true,
    pagingType: 'simple',
    dom:
        "<'row'<'col-3'l><'col-9'f>>" +
        "<'row dt-row'<'col-sm-12'tr>>" +
        "<'row'<'col-4'i><'col-8'p>>",
    language: {
        info: 'Page _PAGE_ of _PAGES_',
        lengthMenu: '_MENU_ ',
        search: '',
        searchPlaceholder: 'Search..',
    },
});

const setTableColor = () => {
    document
        .querySelectorAll('.dataTables_paginate .pagination')
        .forEach((dt) => {
            dt.classList.add('pagination-primary');
        });
};
setTableColor();
jquery_datatable_inventory.on('draw', setTableColor);
jquery_datatable_category.on('draw', setTableColor);
jquery_datatable_product_inventory_stock_in.on('draw', setTableColor);
jquery_datatable_inventory_supplier.on('draw', setTableColor);
