$(function () {
    $('#restoreQuickSaleBtn').on('click', function () {
        const saleId = $(this).data('sale-id');
        $('#quickSaleRestoreForm').attr(
            'action',
            route('quick-sales.restore', saleId)
        );
    });

    $('#quickSaleRestoreForm').on('submit', function (e) {
        e.preventDefault();

        const btn = $('#quickSaleRestoreForm .qs-restore-button');
        const spinner =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.html(spinner).prop('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            type: 'PATCH',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        text: response.success,
                        timer: 3000,
                    });
                }

                $('#restore-quick-sale-modal').modal('hide');
                btn.html(`Confirm`).prop('disabled', false);
                location.reload();
            },
            error: function (response) {
                $('#restore-quick-sale-modal').modal('hide');
                btn.html(`Confirm`).prop('disabled', false);

                if (response.responseJSON.error) {
                    Swal.fire({
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        text: response.responseJSON.error,
                        timer: 3000,
                    });
                }
            },
        });
    });
});
