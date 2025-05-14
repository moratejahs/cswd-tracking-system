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
                    doc.content.unshift({
                        image: 'data:image/png;base64,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ez83Gui64z22RvHmdXJeJCy2P17GebX9knt+N04LN4+w2JZYBuP84fJujfw2AHl+K/I2jTQpW4KFvuqFl156yVSFE05paSkefvhheXTKePLJJ2MqDXG73XjyySfl0fB4PCGNisOprKwM21eXx+MJefdhOF6vN6a2BXI11GWXXWaaLjMW39fU1MRcotBfVn1YWY2TqxMhPVadagbzvFhVFSazh2i5ejBS+x/5acJI1fSy5cuXh1wTA1FYWGh5fyeCy+XCSy+9lJTSK42xiw+N8boZThKVZyaa0+kMuaaGompQZnzYhXqldICFvox59+7dqKurC+koz+12o6ysDNu3b0d9fX1SM45kczqdaGlpQV1dHUpLS003vcPhQGlpKerq6iI+iVJcXIxdu3ahtrY27LFqa2vDmjVrTNNkHo8Hu3btgtfrDQn6CgsLUVlZCV8cj9sbq6EcDkfUzMLYVxEsviwTTW5rZdX+SiN/WcT7ZM9wMtjnRa4qjPXl7P1hrB6Uz5kVY2Bg7GYgFlb94cXDeH9v3bo17P3dX9pTbDt27Ah7XSeKXE0Ii+tmOElUnploxiYKch48VHJyctjhqEQRvUWKRERERJQgKV+CRURERDTcMMAiIiIiSjAGWEREREQJxgCLiIiIKMEYYBERERElGAMsIiIiogRjgEVERESUYAywiIiIiBKMARYRERFRgjHAIiIiIkowBlhERERECcYAi4iIiCjB/g+9JYnYuO2tLgAAAABJRU5ErkJggg==', // Must be base64 or CORS-safe
                        width: 500,
                        alignment: 'center',
                        margin: [0, 0, 0, 20], // [left, top, right, bottom]
                    });

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
