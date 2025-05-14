$(function () {
    // Initialize DataTable
    let table = $('#serviceRecord').DataTable({
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
                orientation: 'landscape',
                className: 'btn btn-primary btn-sm',
                customize: function (win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<div style="text-align: center; margin-bottom: 20px;"><img src="https://cswd-tandag.site/cswd_header.png" style="width: 100%; max-width: 600px;" /></div>'
                        ).append(`
                            <div style="display: flex; justify-content: center; margin-top: 50px;">
                                <div style="text-align: center; margin-right: 100px;">
                                    <div style="border-top: 1px solid black; width: 200px; margin: 0 auto;"></div>
                                    <p style="margin-top: 5px; font-weight: bold;">SOCIAL WELFARE OFFICER-III</p>
                                </div>
                                <div style="text-align: center; margin-left: 100px;">
                                    <div style="border-top: 1px solid black; width: 200px; margin: 0 auto;"></div>
                                    <p style="margin-top: 5px; font-weight: bold;">DEPARTMENT HEAD</p>
                                </div>
                            </div>
                        `);
                },
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
                orientation: 'landscape',
                pageSize: 'A4',
                customize: function (doc) {
                    // Reduce default font size
                    doc.defaultStyle.fontSize = 10;

                    // Add image at the top (if served from a CORS-safe server or base64)

                    // Add signatures at the bottom
                    doc.content.push({
                        margin: [0, 50, 0, 0],
                        columns: [
                            {
                                width: '*',
                                alignment: 'center',
                                stack: [
                                    {
                                        text: '_______________________________',
                                        margin: [0, 10, 0, 2],
                                    },
                                    {
                                        text: 'SOCIAL WELFARE OFFICER-III',
                                        bold: true,
                                    },
                                ],
                            },
                            {
                                width: '*',
                                alignment: 'center',
                                stack: [
                                    {
                                        text: '_______________________________',
                                        margin: [0, 10, 0, 2],
                                    },
                                    { text: 'DEPARTMENT HEAD', bold: true },
                                ],
                            },
                        ],
                    });
                },
            },
            // Add a new button for date filter
            {
                text: 'Filter by Date',
                className: 'btn btn-primary btn-sm',
                action: function () {
                    $('#createFilter').modal('show');
                },
            },
        ],
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: route('admin.service.index'),
            data: function (d) {
                // Only add date parameters if they have values
                if ($('#start_date').val()) {
                    d.start_date = $('#start_date').val();
                }
                if ($('#end_date').val()) {
                    d.end_date = $('#end_date').val();
                }
            },
        },
        columns: [
            {
                data: 'first_name',
                name: 'first_name',
                className: 'text-left',
            },
            {
                data: 'middle_name',
                name: 'middle_name',
                className: 'text-left',
            },
            {
                data: 'last_name',
                name: 'last_name',
                className: 'text-left',
            },
            {
                data: 'birth_date',
                name: 'birth_date',
                className: 'text-left',
            },
            {
                data: 'age',
                name: 'age',
                className: 'text-left',
            },
            {
                data: 'gender',
                name: 'gender',
                className: 'text-left',
            },
            {
                data: 'age', // This seems duplicated in the header; keep only once if unnecessary
                name: 'age',
                className: 'text-left',
            },
            {
                data: 'address',
                name: 'address',
                className: 'text-left',
            },
            {
                data: 'contact_no',
                name: 'contact_no',
                className: 'text-left',
            },
            {
                data: 'occupation',
                name: 'occupation',
                className: 'text-left',
            },
            {
                data: 'purpose',
                name: 'purpose',
                className: 'text-left',
            },
            {
                data: 'category',
                name: 'category',
                className: 'text-left',
            },
            {
                data: 'amount',
                name: 'amount',
                className: 'text-left',
            },
            {
                data: 'responsible_person',
                name: 'responsible_person',
                className: 'text-left',
            },
            {
                data: 'created_at',
                name: 'created_at',
                className: 'text-left',
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

    // Handle filter button click
    $('#filterButton').on('click', function () {
        table.draw();
        $('#createFilter').modal('hide');
    });

    // Add a reset filter button handler if needed
    $('#resetFilterButton').on('click', function () {
        $('#start_date').val('');
        $('#end_date').val('');
        table.draw();
        $('#createFilter').modal('hide');
    });
});
