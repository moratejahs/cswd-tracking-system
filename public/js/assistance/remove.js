$(body).on('click', '#removeService', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#removeAssistanceModal').modal('show');
        $('#remove-id').val(data.id);
    });
});
