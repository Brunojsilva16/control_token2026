<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de Dropdown com Selectpicker</title>
    
    <!-- 1. Estilos do Bootstrap (Necessário para o Selectpicker) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- 2. Estilos do Bootstrap Selectpicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
    
    <!-- 3. Tailwind CSS (Apenas para estilizar a página de exemplo) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Ajuste para garantir que o menu do selectpicker apareça corretamente */
        .bootstrap-select .dropdown-menu {
            z-index: 1060; /* Valor alto para sobrepor outros elementos */
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Teste de Dropdown de Bancos</h1>

        <!-- HTML do Dropdown fornecido -->
        <div class="form-group col-md-12 upp doww"> <!-- Ajustado para col-md-12 para melhor encaixe -->
            <label for="listbanco"><strong>Banco:</strong></label>
            <span class="listforma-info infoAlerta"></span>
            <select name="listbanco" id="listbanco" class="form-control selectpicker" data-style="btn-light border">
                <!-- As opções serão populadas pelo JavaScript -->
            </select>
        </div>

        <hr class="my-6">

        <!-- Botões para simular a seleção dinâmica -->
        <div class="space-y-3">
            <h2 class="text-lg font-semibold text-gray-700">Testar Seleção:</h2>
            <button id="btnItau" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Selecionar Itaú
            </button>
            <button id="btnBradesco" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Selecionar Bradesco
            </button>
            <button id="btnNenhum" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Selecionar Nenhum
            </button>
        </div>
    </div>

    <!-- 4. jQuery (Dependência do Bootstrap e Selectpicker) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    
    <!-- 5. Bootstrap JS (Dependência do Selectpicker) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    <!-- 6. Bootstrap Selectpicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    
    <!-- 7. Seu script -->
    <script>
        /**
         * Popula o dropdown de bancos e pré-seleciona um valor.
         * @param {string} bancoParaSelecionar - O valor (ex: "Itau") do banco a ser selecionado.
         */
        function popularDropdownBancoFixo(bancoParaSelecionar) {

            // 1. Defina sua lista de opções aqui
            var listaDeOpcoes = [
                { valor: "", texto: "Nenhum" },
                { valor: "Itau", texto: "Banco Itau" },
                { valor: "Bradesco", texto: "Banco Bradesco" },
                { valor: "Santander", texto: "Banco Santander" },
                { valor: "Caixa", texto: "Caixa Econômica Federal" }
            ];

            // 2. Limpa espaços em branco do valor que veio do response (MUITO IMPORTANTE)
            if (bancoParaSelecionar && typeof bancoParaSelecionar === 'string') {
                bancoParaSelecionar = bancoParaSelecionar.trim();
                console.log("Valor para selecionar (tratado): " + bancoParaSelecionar);
            } else {
                bancoParaSelecionar = ""; // Define um padrão seguro (Nenhum)
                console.log("Nenhum valor fornecido, selecionando padrão: " + bancoParaSelecionar);
            }

            // 3. Seleciona o elemento dropdown
            var $dropdown = $("#listbanco");

            // 4. Limpa opções antigas
            $dropdown.empty();

            // 5. Itera sobre sua lista fixa e cria as <option>
            listaDeOpcoes.forEach((banco) => {

                // Verifica se esta é a opção que deve ser selecionada
                var selecionado = (banco.valor == bancoParaSelecionar) ? "selected" : "";
                
                // Debug: Verifica qual opção está sendo marcada como selecionada
                // console.log(`Opção: ${banco.valor} | Para Selecionar: ${bancoParaSelecionar} | Selecionado: ${selecionado}`);

                $dropdown.append(
                    "<option value='" + banco.valor + "' " + selecionado + ">" + banco.texto + "</option>"
                );
            });

            // 6. [MUITO IMPORTANTE] Atualize o plugin selectpicker
            // Sem isso, o dropdown não será atualizado na tela.
            $dropdown.selectpicker('refresh');
        }


        // --- Código para executar o exemplo ---
        $(document).ready(function() {
            
            // Simula o carregamento inicial da página
            // como se 'response.data.nome_banco' fosse "Itau"
            var bancoInicial = "Itau";
            console.log("Carregamento inicial, selecionando:", bancoInicial);
            popularDropdownBancoFixo(bancoInicial);


            // Adiciona funcionalidade aos botões de teste
            $("#btnItau").on("click", function() {
                console.log("Clicou em 'Selecionar Itaú'");
                popularDropdownBancoFixo("Itau");
            });

            $("#btnBradesco").on("click", function() {
                console.log("Clicou em 'Selecionar Bradesco'");
                popularDropdownBancoFixo("Bradesco");
            });

            $("#btnNenhum").on("click", function() {
                console.log("Clicou em 'Selecionar Nenhum'");
                popularDropdownBancoFixo(""); // Passa string vazia para 'Nenhum'
            });

        });
    </script>

</body>
</html>
