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


                    <!-- <div id="gerdorToken"></div> -->

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
    <script type="text/javascript" src="./js/sqls_insert.js"></script>
    <script type="text/javascript" src="./js/sqls_edit.js"></script>
    <script type="text/javascript" src="./js/sqls_delete.js"></script>

    <script>
        $(document).ready(function() {
            // form_token();
            fetchProf('profSelect', 'Todos', 'adm');
            fetchPesquisa('anoSelect', 'mesSelect', 'listforma', 'modalidadeRadio');
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