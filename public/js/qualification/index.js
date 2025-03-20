$(function () {
    $('#qualificationTables').DataTable({
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        dom: '<"row"<"col-md-4"l><"col-md-4 text-center"B><"col-md-4"f>>t<"row"<"col-md-6"i><"col-md-6 d-flex justify-content-end"p>>',
        buttons: [
            {
                extend: 'print',
                title: 'Beneficiary Records',
                text: 'Print',
                className: 'btn btn-primary btn-sm',
            },
            {
                extend: 'excelHtml5',
                title: 'Beneficiary Records',
                text: 'Excel',
                className: 'btn btn-primary btn-sm',
            },
            {
                extend: 'pdfHtml5',
                title: 'Beneficiary Records',
                text: 'PDF',
                className: 'btn btn-primary btn-sm',
                orientation: 'portrait',
                pageSize: 'A4',
            },
        ],
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: route('qualification.index'),
        columns: [
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'description',
                name: 'description',
                render: function (data) {
                    if (!data) return ''; // Handle empty data
                    return data.replace(/-/g, '<br>-'); // Add line breaks before each dash
                },
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
