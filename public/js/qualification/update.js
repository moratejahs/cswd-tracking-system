$(body).on('click', '#editQualification', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#editQualificationModals').modal('show');
        $('#qualificationIdsss').val(data.id);
        $('#qualificationName').val(data.name);
        $('#qualificationDes').val(data.description);
    });
});
