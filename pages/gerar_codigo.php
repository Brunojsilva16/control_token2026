<?php $title = "Controle"; ?>
<?php include 'includes/timezone.php'; ?>
<?php include 'includes/sessao.php'; ?>
<?php
if ($_SESSION['usuario']['tipo'] != 2) {
    header('Location: home');
    exit();
} else {
    $sideb = 'includes/siderbar.php';
}
?>

<?php include 'includes/head.php'; ?>

<body>

    <div class="wrapper">
        <div class="section">
            <div class="top_navbar">
                <div class="hamburger">
                    <a href="#">
                        <div id="hamburgerBar" class="container" onclick="myFunction(this)">
                            <div class="bar1"></div>
                            <div class="bar2"></div>
                            <div class="bar3"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="container-fluid" style="background-color: #f5f6fa;">
                <?php include $sideb; ?>

                <div class="container">

                    <?php
                    include 'forms/form_token.php';
                    ?>

                </div>

                <div id="tokenOnly"></div>

            </div>
        </div>
    </div>
    <?php
    include 'modals/modal_delete.php';
    include 'modals/modal_edit.php';
    include 'includes/scripts.php';
    ?>
    <script type="text/javascript" src="./js/sqls_insertv3.js"></script>
    <script type="text/javascript" src="./js/sqls_edit.js"></script>
    <script type="text/javascript" src="./js/sqls_delete.js"></script>

    <script>
        $(document).ready(function() {
            fetchProf('profSelect', 'Todos', 'adm');
            fetchAno('anoSelect');
            fetchMes('mesSelect');
            fetchPagamento('listforma');
            fetchModaGerar('modalidadeRadio');
        });

        var hamburger = document.querySelector(".hamburger");
        hamburger.addEventListener("click", function() {
            document.querySelector("body").classList.toggle("active");
        })

        function myFunction(x) {
            x.classList.toggle("change");
        }
    </script>


    <script>
        // Aguarda o documento estar pronto (opcional, mas boa prática)
        document.addEventListener('DOMContentLoaded', (event) => {

            // Adiciona o "ouvinte" de clique ao botão que criamos
            document.getElementById('btnDataAtual').addEventListener('click', function() {

                // 1. Cria um objeto com a data atual
                const data = new Date();

                // 2. Formata a data para o padrão AAAA-MM-DD (necessário para <input type="date">)
                const ano = data.getFullYear();
                const mes = String(data.getMonth() + 1).padStart(2, '0'); // +1 pois os meses começam em 0
                const dia = String(data.getDate()).padStart(2, '0');
                const dataFormatada = `${dia}/${mes}/${ano}`; // Formato AAAA-MM-DD

                // 3. Define o valor do input "Data Pagamento"
                
                // A linha abaixo estava a causar o erro porque o id 'datacad' não existe no input de data.
                // document.getElementById('datacad').value = dataFormatada;

                // CORREÇÃO:
                // Vamos selecionar o input de data pelo seu atributo 'name', que é "pag_resp"
                // (Este input está no seu arquivo 'forms/form_token.php')
                var campoData = document.querySelector('input[name="pag_resp"]');
                if (campoData) {
                    campoData.value = dataFormatada;
                } else {
                    console.error("Não foi possível encontrar o campo de data (input[name='pag_resp'])");
                }
            });

        });
    </script>
</body>

</html>