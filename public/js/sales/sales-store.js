$(function () {
    $("#salesCreateForm").on("submit", function (e) {
        e.preventDefault();
        const btn = $("#salesCreateForm .save-button");
        const spinner =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
        btn.html(spinner).prop("disabled", true);

        $.ajax({
            url: $(this).action,
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    $("#sales-record").DataTable().ajax.reload();
                    resetSalesCreateForm("#salesCreateForm");

                    // Toast SweerAlert
                    Swal.fire({
                        icon: "success",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        text: response.success,
                        timer: 3000,
                    });

                    $("#store-sale-modal").modal("hide");

                    // Modal SweetAlert
                    // Swal.fire({
                    //     icon: "success",
                    //     title: "Success!",
                    //     text: response.success,
                    //     confirmButtonText: "Ok",
                    // }).then(() => {
                    //     window.location.href = response.redirect;
                    // });
                }
                btn.html("Save").prop("disabled", false);
            },
            error: function (response) {
                btn.html("Save").prop("disabled", false);

                if (response.responseJSON.error) {
                    Swal.fire({
                        icon: "error",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        text: response.responseJSON.error,
                        timer: 3000,
                    });
                }
            },
        });
    });
});
