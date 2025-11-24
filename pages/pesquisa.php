<?php
$title = "Pesquisa Avançada";
include 'includes/timezone.php';
include 'includes/sessao.php';

// Determina o tipo de usuário para a lógica da UI
$isAdmin = ($_SESSION['usuario']['tipo'] > 1);
$sideb = $isAdmin ? "includes/siderbar.php" : "includes/siderbar_pf.php";

include 'includes/head.php';
?>

<body id="indexs">
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

            <div class="container-fluid" style="background-color: #f5f6fa; min-height: 100vh;">
                <?php include $sideb; ?>

                <div class="container-fluid py-4">
                    <div class="card shadow-sm rounded-lg border-0">
                        <div class="card-header bg-white border-0 py-3">
                            <h4 class="mb-0"><i class="fa fa-filter text-success mr-2"></i>Filtros de Pesquisa</h4>
                        </div>
                        <div class="card-body">
                            <form id="pform" action="./list_excel.php" method="POST">
                                <!-- Linha 1: Profissional e Paciente -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nomeprof"><strong>Profissional</strong></label>
                                        <?php if ($isAdmin): ?>
                                            <select id="nomeprof" name="idprof[]" class="form-control selectpicker" title="Todos os profissionais" multiple data-actions-box="true" data-live-search="true" data-style="btn-light">
                                            </select>
                                        <?php else: ?>
                                            <select id="nomeprof" name="idprof[]" data-style="btn-light" class="form-control" readonly>
                                                <option value="<?php echo htmlspecialchars($_SESSION['usuario']['id']); ?>" selected><?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?></option>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="idpaciente"><strong>Nome do Paciente</strong></label>
                                        <input type="text" id="idpaciente" name="nomepac" class="form-control" placeholder="Digite parte do nome...">
                                    </div>
                                </div>

                                <!-- Linha 2: Pagamento e Modalidade -->
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="listforma"><strong>Forma de Pagamento</strong></label>
                                        <select id="listforma" name="tipopag[]" class="form-control selectpicker" title="Todas as formas" multiple data-actions-box="true" data-live-search="true" data-style="btn-light">
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="modalidaderef"><strong>Modalidade</strong></label>
                                        <select id="modalidaderef" name="modalidaderef[]" class="form-control selectpicker" title="Todas as modalidades" multiple data-actions-box="true" data-live-search="true" data-style="btn-light">
                                        </select>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="idnomeresp"><strong>Responsável financeiro</strong></label>
                                        <input type="text" id="idnomeresp" name="nomeresp" class="form-control" placeholder="Digite parte do nome...">
                                    </div>
                                </div>

                                <!-- Linha 3: Período -->
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="datepicker1"><strong>Data Inicial</strong></label>
                                        <input type="text" id="datepicker1" name="date_start" class="form-control seudata" placeholder="DD/MM/AAAA">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="datepicker2"><strong>Data Final</strong></label>
                                        <input type="text" id="datepicker2" name="date_end" class="form-control seudata" placeholder="DD/MM/AAAA">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer bg-white text-right border-0">

                            <?php if ($isAdmin): ?>
                                <button class="btn btn-success" type="button" id="pfilter" style="width: 150px;">
                                    <i class="fa fa-search mr-1"></i> Pesquisar
                                </button>

                                <button type="button" id="btnExportar" class="btn btn-success">
                                    <i class="fa fa-file-excel"></i> Exportar Completo
                                </button>
                            <?php endif; ?>

                            <button type="button" id="btnExportarReduzido" class="btn btn-primary">
                                <i class="fa fa-file-excel"></i> Exportar Reduzido
                            </button>

                            <button class="btn btn-info" type="button" id="refresh">
                                <i class="fa fa-refresh mr-1"></i> Limpar Filtros
                            </button>
                        </div>

                    </div>

                    <!-- Área de Resultados -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card shadow-sm rounded-lg border-0">
                                <div class="card-body px-0">
                                    <div id="listarpesquisa">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'modals/modal_view.php'; ?>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- Passa a variável de sessão do PHP para o JavaScript -->
    <script>
        const userType = <?php echo json_encode($_SESSION['usuario']['tipo']); ?>;
        const userId = <?php echo json_encode($_SESSION['usuario']['id']); ?>;
        const userName = <?php echo json_encode($_SESSION['usuario']['nome']); ?>;
    </script>

    <!-- Você pode criar este novo arquivo ou adicionar seu conteúdo ao 'funcoesv2.js' -->
    <script type="text/javascript" src="./js/funcoes_refatoradov3.js"></script>
    <script type="text/javascript" src="./js/export_excelv2.js"></script>
    <script type="text/javascript" src="./js/funcoes_antigas.js"></script>

    <script>
        // Lógica do menu Hamburger
        var hamburger = document.querySelector(".hamburger");
        hamburger.addEventListener("click", function() {
            document.querySelector("body").classList.toggle("active");
        });

        function myFunction(x) {
            x.classList.toggle("change");
        }
    </script>
</body>

</html>