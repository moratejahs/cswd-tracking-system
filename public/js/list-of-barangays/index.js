$('#barangayRecords').DataTable({
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All'],
    ],
    processing: true,
    serverSide: true,
    autoWidth: false,
    ajax: {
        url: "{{ route('admin.assistance.edit', $id) }}",
        type: 'GET',
        dataType: 'json',
        error: function (xhr, status, error) {
            console.log('AJAX error: ', error);
            console.log('Response:', xhr.responseText);
        },
    },

    columns: [
        {
            data: 'outlet_name',
            name: 'outlet_name',
            className: 'text-center',
        },
        {
            data: 'outlet_address',
            name: 'outlet_address',
            className: 'text-center',
        },
        { data: 'status', name: 'status', className: 'text-center' },
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
