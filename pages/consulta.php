<?php $title = "Consulta"; ?>
<?php include 'includes/timezone.php'; ?>
<?php include './conexao.php'; ?>
<?php include 'includes/sessao.php'; ?>
<?php

if ($_SESSION['usuario']['tipo'] != 2) {
    $sideb = 'includes/siderbar_pf.php';
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

                <div class="container text-star">
                    <span id="alert_message"></span>

                    <!-- <div class="p-3 mb-2 bg-secondary text-white">CONSULTA</div> -->

                    <div class="row">
                        <div class="col-12 align-self-start">

                            <div class="row navb">
                                <div class="input-group col-md-4">
                                    <label class="upp"><strong>DIGITE O TOKEN </strong></label>
                                    <div class="col-12 align-self-start">
                                    </div>

                                    <input id="chave" class="form-control py-2 border-right-0 border chavesearch" name="chave" type="search" placeholder="Pequisar..." required="">
                                    <span class="input-group-append">
                                        <button class="btn btn-outline-success btn-md border-left-0 border chavesearch">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>

                                </div>
                            </div>
                            <!-- </form> -->
                            <p></p>
                        </div>

                    </div>
                    <div id="tokenOnly"></div>
                    <div id="msgg"></div>
                </div>

            </div>
        </div>
    </div>

    <?php include 'modals/modal_delete.php'; ?>
    <?php include 'modals/modal_edit.php'; ?>
    <?php include 'includes/scripts.php'; ?>
    <script type="text/javascript" src="./js/sqls_edit.js"></script>
    <script type="text/javascript" src="./js/sqls_delete.js"></script>

    <!-- 6. Bootstrap Selectpicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

    <!-- 5. Bootstrap JS (Dependência do Selectpicker) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- 6. Bootstrap Selectpicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
    <script>
        var hamburger = document.querySelector(".hamburger");
        hamburger.addEventListener("click", function() {
            document.querySelector("body").classList.toggle("active");
        })

        function myFunction(x) {
            x.classList.toggle("change");
        }
    </script>

</body>

</html>