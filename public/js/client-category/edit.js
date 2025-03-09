$(body).on('click', '#editCategory', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#editCategoryModal').modal('show');
        $('#clientId').val(data.id);
        $('#clientDes').val(data.description);
    });
});
