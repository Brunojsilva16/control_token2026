<?php $title = "Administradores"; ?>
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

                <div class="container text-star">
                    <?php include 'includes/msg.php'; ?>

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered table-striped" style="margin-top:20px;">
                                <thead>
                                    <th>Nome</th>
                                    <th width="180px" class="text-center">Acão</th>
                                </thead>
                                <tbody id="admbody"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/scripts.php'; ?>
    <script>
        $(document).ready(function() {
            fetchAdm();
        });

        var hamburger = document.querySelector(".hamburger");
        hamburger.addEventListener("click", function() {
            document.querySelector("body").classList.toggle("active");
        })

        function myFunction(x) {
            x.classList.toggle("change");
        }
    </script>

    <?php include 'modals/modal_adm.php'; ?>

</body>

</html>