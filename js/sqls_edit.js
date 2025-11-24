
// // Edit token   
$(document).on('click', '.etoken', function () {
    var id = $(this).data('id');
    // $("#editForm")[0].reset();

    if (id) {
        getEditlsT(id, 'edit');
        // document.getElementById('idpac').value = id;
        //     $("#idpac").val(id);
    }

    $('#edittModal').modal('show');

});
const formEdit = document.getElementById("editForm");
formEdit.addEventListener("submit", function (event) {
    event.preventDefault();
    const editForm = new FormData(formEdit, event.submitter);

    $.ajax({
        type: 'POST',
        url: './sqls/edit.php',
        cache: false,
        data: editForm,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            $(".carregando").html('Aguarde, processando requisição...');
            $(".resultadoLoading").html("<img src='./assets/img/loading03.gif' style='width: 100%;'>");
        },
        success: function (response) {

            $(".carregando").html('');
            $(".resultadoLoading").html('');
            $('#edittModal').modal('hide');

            if (response.error) {
                // showAlert('error', response.message);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: response.message,
                    // footer: '<a href="#">Why do I have this issue?</a>'
                });
            }
            else {

                Swal.fire({
                    // html: ` HERE IS ALL  `,
                    position: "top-end",
                    icon: "success",
                    title: "Alteração",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500,

                    willClose: () => {
                        switch (document.title) {
                            case 'Home':
                                listarUsuarios(response.page);
                                break;
                            case 'Consulta':
                                seach_token(response.idtoken);
                                break;
                            case 'Controle':
                                seach_token(response.idtoken);
                                break;
                        }
                    }

                });

            }
        }
    });
});