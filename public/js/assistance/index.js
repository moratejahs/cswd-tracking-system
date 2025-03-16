$(function () {
    $('#serviceRecord').DataTable({
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: route('admin.service.index'),
        columns: [
            {
                data: 'full_name',
                name: 'full_name',
            },
            {
                data: 'birth_date',
                name: 'birth_date',
                className: 'text-center',
                render: function (data, type, row) {
                    var date = new Date(data);
                    var options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                    };
                    return date.toLocaleDateString('en-US', options);
                },
            },
            {
                data: 'address',
                name: 'address',
                className: 'text-center',
            },
            {
                data: 'contact_no',
                name: 'contact_no',
                className: 'text-center',
            },
            {
                data: 'status',
                name: 'status',
                className: 'text-center',
            },
            {
                data: 'occupation',
                name: 'occupation',
                className: 'text-center',
            },
            {
                data: 'assistance',
                name: 'assistance',
                className: 'text-center',
            },
            {
                data: 'quantity',
                name: 'quantity',
                className: 'text-center',
            },
            {
                data: 'person_of_responsible',
                name: 'person_of_responsible',
                className: 'text-center',
            },
            {
                data: 'created_at',
                name: 'created_at',
                className: 'text-center',
                render: function (data) {
                    if (!data) return '';

                    const date = new Date(data);
                    const monthNames = [
                        'Jan',
                        'Feb',
                        'Mar',
                        'Apr',
                        'May',
                        'Jun',
                        'Jul',
                        'Aug',
                        'Sep',
                        'Oct',
                        'Nov',
                        'Dec',
                    ];
                    const formattedDate = `${
                        monthNames[date.getMonth()]
                    } ${String(date.getDate()).padStart(
                        2,
                        '0'
                    )}, ${date.getFullYear()}`;

                    return formattedDate;
                },
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
