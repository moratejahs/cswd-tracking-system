$(body).on('click', '#removeAccount', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#removeAccountModal').modal('show');
        $('#removeUserId').val(data.id);
    });
});
