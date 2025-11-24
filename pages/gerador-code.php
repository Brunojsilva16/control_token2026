<?php $title = 'Gerador Qrcode'; ?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ? $title : $titleSite; ?></title>
    <link rel="stylesheet" href="./css/style_global.css" />

    <link rel="stylesheet" href="./css/code.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Icons Font -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js" integrity="sha512-01CJ9/g7e8cUmY0DFTMcUw/ikS799FHiOA0eyHsUWfOetgbx/t6oV4otQ5zXKQyIrQGTHSmRVPIgrgLcZi/WMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://kit.fontawesome.com/93bdce3b33.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"> </script>
    <script src="  https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"> </script> -->

    <link rel="icon" href="./assets/img/favicon.png" sizes="32x32">

</head>

<style>
    header {
        height: 80vh;
    }

    footer {
        height: 20vh;
    }

    form.code {
        padding-top: 50px;
    }

    .container {
        max-width: 400px;
    }

    .form-group {
        padding: 10px 0;
        /* margin: 10px; */
    }

    .form-check .form-check-input {
        margin-left: 0px !important;
        float: none;
    }
</style>

<!-- scroll-behavior -->

<body id="inicio">

    <?php
    // include "includes/navbar.php"
    ?>

    <div id="entrada"></div>
    <div id="entrada-conecta"></div>

    <header>

        <div class="container">

            <form class="code" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label id="labelText1" for="inputText1">Nome</label>
                    <input type="text" class="form-control" id="inputText1" name="nome" placeholder="Nome">
                </div>
                <div class="form-group">
                    <label id="labelText2" for="inputText2">Digite ou cole aqui o link </label>
                    <input type="text" class="form-control" id="inputText2" name="link" placeholder="link">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="corCheck1" name="checkcor">
                    <label class="form-check-label" for="corCheck1">Sem cor</label>
                </div>
                <button type="submit" class="btn btn-success btn_gerar">Enviar</button>
            </form>

        </div>
    </header>

    <?php include './includes/footer_free.php'; ?>
    <script type="text/javascript" src="./js/crachar.js"></script>
    <?php include './includes/scripts.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script> -->
    <!-- <script type="text/javascript" src="./js/panel.js"></script> -->

    <script src='https://cdn.rawgit.com/lagden/vanilla-masker/lagden/build/vanilla-masker.min.js'></script>
    <script type="text/javascript" src="./js/vanilla.js"></script>

</body>

</html>