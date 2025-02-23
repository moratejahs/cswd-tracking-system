$(function () {
    $("#quickSaleDetroyForm").on("submit", function (e) {
        e.preventDefault();

        const btn = $("#quickSaleDetroyForm .qs-delete-button");
        const spinner =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...';
        btn.html(spinner).prop("disabled", true);

        $.ajax({
            url: $(this).attr("action"),
            method: "DELETE",
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    $("#sales-record").DataTable().ajax.reload();

                    Swal.fire({
                        icon: "success",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        text: response.success,
                        timer: 3000,
                    });

                    $("#remove-quick-sale-modal").modal("hide");
                }
                btn.html("Delete").prop("disabled", false);
            },
            error: function (response) {
                btn.html("Delete").prop("disabled", false);
                $("#remove-quick-sale-modal").modal("hide");

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
