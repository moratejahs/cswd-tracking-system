$(function () {
    $("#restoreSaleBtn").on("click", function () {
        $("#restore-sales-modal").modal("show");
        const saleId = $(this).data("sale-id");
        $("#saleRestoreForm").attr("action", route("sales.restore", saleId));
    });

    $("#saleRestoreForm").on("submit", function (e) {
        e.preventDefault();

        const btn = $("#saleRestoreForm .restore-button");
        const spinner =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.html(spinner).prop("disabled", true);

        $.ajax({
            url: $(this).attr("action"),
            type: "PATCH",
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        text: response.success,
                        timer: 3000,
                    });
                }

                $("#restore-sales-modal").modal("hide");
                location.reload();

                btn.html(`Confirm`).prop("disabled", false);
            },
            error: function (response) {
                $("#restore-sales-modal").modal("hide");
                btn.html(`Confirm`).prop("disabled", false);

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
                location.reload();
            },
        });
    });
});
