// //delete consulta
$(document).on('click', '.deletec', function () {
    // $("#deleteForm")[0].reset();
    var id = $(this).data('id');

    document.getElementById('idpac').value = id;
    // $("#idpac").val(id);
    $('#deleteModal').modal('show');
});

const formDell = document.getElementById("deleteForm");
formDell.addEventListener("submit", function (event) {
    event.preventDefault();
    const dellForm = new FormData(formDell, event.submitter);

    $.ajax({
        method: 'POST',
        url: './sqls/delete.php',
        data: dellForm,
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        beforeSend: function () {
            $(".carregando").html('Aguarde, processando requisição...');
            $(".resultadoLoading").html("<img src='./assets/img/loading03.gif' style='width: 100%;'>");
        },
        success: function (response) {

            $(".carregando").html('');
            $(".resultadoLoading").html('');
            $('#deleteModal').modal('hide');

            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: response.message,
                    // footer: '<a href="#">Why do I have this issue?</a>'
                });
            }
            else {

                Swal.fire({
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
                                refresRoload();
                                break;
                            case 'Controle':
                                refresRoload();
                                break;
                        }
                    }
                });
            }
        }
    });
});


