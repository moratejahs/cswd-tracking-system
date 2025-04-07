$(function () {
    $('#serviceRecord').DataTable({
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
                customize: function (win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<div style="text-align: center; margin-bottom: 20px;"><img src="https://cswd-tandag.site/cswd_header.png" style="width: 100%; max-width: 600px;" /></div>'
                        ).append(`
                            <div style="display: flex; justify-content: center; margin-top: 50px; font-size: 14px;">
                                <div style="text-align: center; margin-right: 100px;">
                                    <div style="border-top: 1px solid black; width: 300px; margin: 0 auto;"></div>
                                    <p style="margin-top: 5px; font-weight: bold;">SOCIAL WELFARE OFFICER-III</p>
                                </div>
                                <div style="text-align: center; margin-left: 100px;">
                                    <div style="border-top: 1px solid black; width: 300px; margin: 0 auto;"></div>
                                    <p style="margin-top: 5px; font-weight: bold;">DEPARTMENT HEAD</p>
                                </div>
                            </div>
                        `);
                },
            },
        ],
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: route('admin.service.index'),
        columns: [
            {
                data: 'full_name',
                name: 'full_name',
                className: 'text-left',
            },
            {
                data: 'birth_date',
                name: 'birth_date',
                className: 'text-left',

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
                className: 'text-left',
            },
            {
                data: 'contact_no',
                name: 'contact_no',
                className: 'text-left',
            },
            {
                data: 'status',
                name: 'status',
                className: 'text-left',
            },
            {
                data: 'occupation',
                name: 'occupation',
                className: 'text-left',
            },
            {
                data: 'assistance',
                name: 'assistance',
                className: 'text-left',
            },
            {
                data: 'quantity',
                name: 'quantity',
                className: 'text-left',
            },
            {
                data: 'person_of_responsible',
                name: 'person_of_responsible',
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
});
