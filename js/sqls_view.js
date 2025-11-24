// Consulta View tokne
$(document).on('click', '.vtoken', function () {
    $("#viewForm")[0].reset();
    var id = $(this).data('id');

    if (id) {
        getEditlsT(id, 'view');
    }

    $('#viewModal').modal('show');
});