$('#assistanceFundRecords').DataTable({
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All'],
    ],
    processing: true,
    serverSide: true,
    autoWidth: false,
    ajax: route('admin.assistance.index'),
    columns: [
        { data: 'code', name: 'code', className: 'text-center' },
        {
            data: 'assistance_name',
            name: 'assistance_name',
            className: 'text-center',
        },
        { data: 'description', name: 'description', className: 'text-center' },
        {
            data: 'created_at',
            name: 'created_at',
            className: 'text-center',
            render: function (data, type, row) {
                if (data) {
                    let date = new Date(data);
                    return date.toLocaleDateString('en-US', {
                        month: 'short',
                        day: '2-digit',
                        year: 'numeric',
                    });
                }
                return '';
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

document.addEventListener('DOMContentLoaded', function () {
    document
        .getElementById('showAssistanceData')
        .addEventListener('click', function () {
            fetch('/admin/get-assistance-data')
                .then((response) => response.json())
                .then((data) => {
                    const tbody = document.getElementById('assistanceDataBody');
                    tbody.innerHTML = ''; // Clear existing data

                    data.forEach((item) => {
                        const row = `<tr>
                        <td>${item.first_name}</td>
                        <td>${item.last_name}</td>
                        <td>${item.total_visited}</td>
                        <td>${item.total_amount}</td>
                    </tr>`;
                        tbody.innerHTML += row;
                    });

                    // Show the modal
                    const modal = new bootstrap.Modal(
                        document.getElementById('assistanceDataModal')
                    );
                    modal.show();
                })
                .catch((error) =>
                    console.error('Error fetching assistance data:', error)
                );
        });
});
