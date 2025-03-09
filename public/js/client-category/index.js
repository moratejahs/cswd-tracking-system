$(function () {
    $('#clientCategory').DataTable({
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: route('admin.client-categorie.index'),
        columns: [
            {
                data: 'id',
                name: 'id',
            },
            {
                data: 'description',
                name: 'description',
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
            },
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).css({
                'font-size': '13px',
                'font-weight': '600',
            });
        },
    });
});
