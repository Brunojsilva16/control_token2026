<?php $title = "Controle"; ?>
<?php include 'includes/timezone.php'; ?>
<?php include '../conexao.php'; ?>
<?php

if ($_SESSION['usuario']['tipo'] != 2) {
    header('Location: home');
    exit();
}
?>

<?php include 'includes/head.php'; ?>

<body>

    <div class="wrapper">
        <div class="section">
            <div class="top_navbar">
                <div class="hamburger">

                    <a href="#">
                        <i class="fas fa-bars"></i>
                    </a>

                </div>
            </div>
            <div class="container-fluid" style="background-color: #f5f6fa;">
                <div id="conteudo_homeAt" class="box-body" style="width: 1080px;">

                    <div class="container">
                        <?php include 'includes/msg.php'; ?>
                        <div class="p-3 mb-2 bg-secondary text-white">
                            <div class="row" id="myDIV">
                                <div>
                                    SISTEMA GERADOR DE CÓDIGO
                                </div>
                                <div>
                                    <?php include 'includes/login_navuser.php'; ?>
                                </div>
                            </div>
                        </div>

                        <h1 class="page-header text-center">Controle Profissionais</h1>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-striped" style="margin-top:20px;">
                                    <thead>
                                        <th>Nome</th>
                                        <th>Crp</th>
                                        <th width="180px" class="text-center">Acão</th>
                                    </thead>
                                    <tbody id="tbody"></tbody>
                                </table>
                            </div>
                        </div>


                    </div>



                </div>

            </div>

            <div class="sidebar">
                <div class="profile">
                    <!-- <img src="https://1.bp.blogspot.com/-vhmWFWO2r8U/YLjr2A57toI/AAAAAAAACO4/0GBonlEZPmAiQW4uvkCTm5LvlJVd_-l_wCNcBGAsYHQ/s16000/team-1-2.jpg" alt="profile_picture"> -->
                    <img src="assets/img/semfoto.png" alt="profile_picture">

                    <h3>Usuario</h3>
                    <p>Recepcionista</p>
                </div>
                <ul>
                    <li>
                        <a href="#">
                            <span class="icon"><i class="fas fa-home"></i></span>
                            <span class="item">Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon"><i class="fas fa-desktop"></i></span>
                            <span class="item">Meus tokens</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon"><i class="fas fa-user-friends"></i></span>
                            <span class="item">Profissionais</span>
                        </a>
                    </li>
                    <!-- <li>
                    <a href="#" class="active">
                        <span class="icon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="item">Perfomance</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-database"></i></span>
                        <span class="item">Development</span>
                    </a>
                </li> -->
                    <li>
                        <a href="#">
                            <span class="icon"><i class="fas fa-chart-line"></i></span>
                            <span class="item">Relatórios</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon"><i class="fas fa-user-shield"></i></span>
                            <span class="item">Adm</span>
                        </a>
                    </li>
                    <!-- <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-cog"></i></span>
                        <span class="item">Settings</span>
                    </a>
                </li> -->
                </ul>
            </div>

        </div>

        <script>
            var hamburger = document.querySelector(".hamburger");
            hamburger.addEventListener("click", function() {
                document.querySelector("body").classList.toggle("active");
            })

        </script>

        <?php include 'modals/modal_adm.php'; ?>
        <?php include 'includes/scripts.php'; ?>

</body>

</html>