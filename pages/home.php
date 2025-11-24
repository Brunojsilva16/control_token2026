<?php $title = "Home"; ?>
<?php include 'includes/timezone.php'; ?>

<?php include 'includes/sessao.php'; ?>
<?php
if ($_SESSION['usuario']['tipo'] != 2) {
    $sideb = 'includes/siderbar_pf.php';
} else {
    $sideb = 'includes/siderbar.php';
}
?>

<?php include 'includes/head.php'; ?>


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

            <div class="container-fluid" style="background-color: #f5f6fa;">
                <?php include $sideb; ?>

                <!-- <div class="container text-star"> -->
                <span id="alert_message"></span>

                <div class="row">
                    <div class="col-lg-12">
                        <span class="listar-cliente"></span>
                    </div>
                </div>
                <!-- </div> -->

            </div>
        </div>
    </div>
    <?php
    // include 'modals/modalss.php'; 
    ?>
    <?php
    include 'modals/modal_view.php';
    include 'modals/modal_delete.php';
    include 'modals/modal_edit.php';
    ?>
    <?php include 'includes/scripts.php'; ?>
    <script type="text/javascript" src="./js/sqls_view.js"></script>
    <script type="text/javascript" src="./js/sqls_edit.js"></script>
    <script type="text/javascript" src="./js/sqls_delete.js"></script>

    <!-- 6. Bootstrap Selectpicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

    <!-- 5. Bootstrap JS (Dependência do Selectpicker) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- 6. Bootstrap Selectpicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

    <script>
        $(document).ready(function() {
            listarUsuarios(1);
            // $('select').selectpicker();
        });

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