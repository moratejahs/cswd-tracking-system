$(body).on('click', '#deleteAssistanceFund', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#deleteAssistanceFundModal').modal('show');
        $('#assistantDeleteId').val(data.id);
    });
});
