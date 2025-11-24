const formInsert = document.getElementById("frmValidar");
const submitButton = document.getElementById("sbmGerar");

formInsert.addEventListener("submit", function (event) {
    event.preventDefault();

    // --- INÍCIO DA ALTERAÇÃO ---
    // Chama a função de validação. Se retornar false, interrompe a execução.
    if (!validarFormularioToken()) {
        return; 
    }

    const insertForm = new FormData(formInsert, event.submitter);

    $.ajax({
        type: "POST",
        url: './sqls/insert_token.php',
        cache: false,
        data: insertForm,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            // --- INÍCIO DAS ALTERAÇÕES ---
            
            // 1. Desabilita o botão para evitar múltiplos cliques
            submitButton.disabled = true;

            // 2. Altera o conteúdo do botão para mostrar um loading
            //    (Este exemplo usa um spinner do Bootstrap. Certifique-se de que o Bootstrap CSS está incluído na sua página)
            submitButton.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Processando...
            `;
            
            // --- FIM DAS ALTERAÇÕES ---

            // Suas linhas originais para o loading geral da página
            $(".carregando").html('Aguarde, processando requisição...');
            $(".resultadoLoading").html("<img src='./assets/img/loading03.gif' style='width: 100%;'>");
        },
        success: function (response) {

            $(".carregando").html('');
            $(".resultadoLoading").html('');
            
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Cadastro",
                text: response.message,
                showConfirmButton: false,
                timer: 1500,
                willClose: () => {
                    const element = document.getElementById("frmValidar");
                    element.remove();
                    seach_token(response.last_token);
                }
            });

        },
        error: function (error) {
            $(".carregando").html('');
            $(".resultadoLoading").html('');

            console.log(error);

            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Ocorreu um erro inesperado. Tente novamente.",
            });
        },
        // --- INÍCIO DA ADIÇÃO ---
        complete: function() {
            // 3. Este bloco é executado sempre que a requisição termina (seja sucesso ou erro)
            
            // Reabilita o botão
            submitButton.disabled = false;
            
            // Restaura o texto original do botão
            submitButton.innerHTML = 'Gerar Token';
        }
        // --- FIM DA ADIÇÃO ---
    });
});