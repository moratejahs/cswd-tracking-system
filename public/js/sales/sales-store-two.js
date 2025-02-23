$(function () {
    $('#salesCreateFormTwo').on('submit', function (e) {
        e.preventDefault();

        const btn = $('#salesCreateFormTwo .qs-save-button');
        const spinner =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
        btn.html(spinner).prop('disabled', true);
        console.log($(this).serialize());
        $.ajax({
            url: route('quick-sales.store'),
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    $('#sales-record').DataTable().ajax.reload();

                    // clear form values
                    $('#salesCreateFormTwo')[0].reset();

                    Swal.fire({
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        text: response.success,
                        timer: 3000,
                    });

                    $('#store-sale-modal-two').modal('hide');
                }
                btn.html('Save').prop('disabled', false);
            },
            error: function (response) {
                console.log(response);

                btn.html('Save').prop('disabled', false);

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
