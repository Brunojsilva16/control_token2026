$(document).ready(function () {

    switch (document.title) {
        case 'Painel Geral':
            var getval = './sqls/fetch_inscr.php';
            var callget = true;
            break;
        case 'Painel Pendentes':
            var getval = './sqls/fetch_pend.php';
            var callget = false;
            break;
        case 'Painel Confirmados':
            var getval = './sqls/fetch_conf.php';
            var callget = false;
            break;

        default:
            break;
    }


    // if (document.title == 'Painel Geral') {
    //     var getval = './sqls/fetch_inscr.php';
    //     var callget = true;
    // } else {
    //     var getval = './sqls/fetch_pend.php';
    //     var callget = false;
    // }


    $.get(getval, function (retorna) {
        $("#flexCard").html(retorna);

        if (callget) { fetchPanelDados(); }

        $('.btn_status').on('click', function (e) {
            e.preventDefault();

            const vall = $(this).data('v');
            const valtwo = $(this).data('id');

            if (vall != 'Confirmado') {
                var texto = "Cancelar a inscrição?";
            } else {
                var texto = "Confirmar a inscrição?";
            }

            Swal.fire({
                title: texto,
                // text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        method: 'POST',
                        url: './sqls/update_mod.php',
                        data: { codparceiro: valtwo, status: vall },
                        // contentType: false,
                        cache: false,
                        // processData: false,
                        dataType: 'json',
                        beforeSend: function () {
                            $(".carregando").html('Aguarde, processando requisição...');
                            $(".resultadoLoading").html("<img src='./assets/img/loading03.gif' style='width: 100%;'>");
                        },
                        success: function (response) {

                            console.log(response);

                            $(".carregando").html('');
                            $(".resultadoLoading").html('');

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
                                    footer: "Cadastro confirmado!",
                                    showConfirmButton: false,
                                    timer: 1500,

                                    willClose: () => {
                                        window.location.reload();
                                    }
                                });

                            }
                        }
                    });

                }
            })
        });

        $('.btn_crachar').on('click', function (e) {
            e.preventDefault();

            const valid = $(this).data('id');
            const namee = $(this).data('nome');

            const palavras = namee.split(" ");
            const primeiraPalavra = palavras[0];

            $.ajax({
                method: 'POST',
                url: './sqls/fetch_cracha.php',
                data: { id: valid, nome: namee },
                success: function (response) {

                    // console.log(response);

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
                            // icon: "error",
                            // title: "Oops...11",
                            showConfirmButton: false,
                            html: response,
                            footer: '<button id="btn_download" class="btn btn-outline-success">Download</button>'

                        });

                        // Seletor para a div que você deseja salvar
                        const divToDownload = document.querySelector('#crachar_download');

                        // Seletor para o botão de download
                        const downloadButton = document.getElementById('btn_download');

                        downloadButton.addEventListener('click', downloadDivAsImage);

                        function downloadDivAsImage() {
                            // Crie um elemento de imagem
                            const image = document.createElement('img');

                            console.log(divToDownload);

                            // Converta a div em uma imagem usando o DOMtoImage
                            domtoimage.toPng(divToDownload)
                                .then(function (dataUrl) {
                                    // Defina o atributo 'src' da imagem
                                    image.src = dataUrl;

                                    // Crie um link para download
                                    const link = document.createElement('a');
                                    link.href = dataUrl;
                                    link.download = 'Qrcode_' + primeiraPalavra + '.jpg';

                                    // Anexe a imagem ao link
                                    link.appendChild(image);

                                    // Simule um clique no link para iniciar o download
                                    link.click();
                                })
                                .catch(function (error) {
                                    console.error('Erro ao converter a div em imagem:', error);
                                });
                        }

                    }

                }
            });

        });

    });

});