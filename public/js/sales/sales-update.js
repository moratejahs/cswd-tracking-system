$(function () {
    $("#saleUpdateForm").on("submit", function (e) {
        e.preventDefault();

        const btn = $("#saleUpdateForm .update-button");
        const spinner =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving Changes...';
        btn.html(spinner).prop("disabled", true);

        $.ajax({
            url: $(this).attr("action"),
            type: "PATCH",
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

                    $("#edit-sales-modal").modal("hide");
                }
                btn.html("Save Changes").prop("disabled", false);
            },
            error: function (response) {
                btn.html("Save Changes").prop("disabled", false);
                $("#edit-sales-modal").modal("hide");

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
