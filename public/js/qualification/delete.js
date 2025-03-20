$(body).on('click', '#deleteQualification', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#removeDeleteQualificationModal').modal('show');
        $('#qualificationId').val(data.id);
    });
});
