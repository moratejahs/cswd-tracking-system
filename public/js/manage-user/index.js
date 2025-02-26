$(function () {
    $('#manage-users-record').DataTable({
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: route('admin.manage_account.index'),
        columns: [
            {
                data: 'full_name',
                name: 'full_name',
                render: function (data, type, row) {
                    return `${row.first_name} ${row.middle_name} ${row.last_name}`;
                },
            },
            {
                data: 'email',
                name: 'email',
                className: 'text-center',
            },
            {
                data: 'position',
                name: 'position',
                className: 'text-center',
            },
            {
                data: 'username',
                name: 'username',
                className: 'text-center',
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
