$(body).on('click', '#approvedAssistance', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#approvedAssistanceModal').modal('show');
        $('#approvedId').val(data.id);
    });
});
