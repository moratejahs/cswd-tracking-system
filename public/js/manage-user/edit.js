$(body).on('click', '#editAccount', function () {
    var url = $(this).data('url');
    $.get(url, function (data) {
        $('#editAccountModal').modal('show');
        $('#accountId').val(data.id);
        $('#accountFirstname').val(data.first_name);
        $('#accountMiddlename').val(data.middle_name);
        $('#accountLastname').val(data.last_name);
        $('#accountPosition').val(data.position);
        $('#accountEmail').val(data.email);
        $('#accountUsername').val(data.username);
        $('#accountPassword').val(data.password);
    });
});
