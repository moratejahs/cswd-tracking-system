$(body).on('click', '#removeCategory', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#removeCategoryModal').modal('show');
        $('#clentRemoveId').val(data.id);
    });
});
