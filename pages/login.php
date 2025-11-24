<?php $title = "Login"; ?>
<?php include 'includes/timezone.php'; ?>
<?php include 'conexao.php'; ?>
<?php

if (session_status() !== PHP_SESSION_ACTIVE) {

	session_start([
		'cookie_lifetime' => 28800,
		'gc_maxlifetime' => 28800,
	]);
}

if (isset($_SESSION['usuario'])) {

    header('Location: home');
    exit();
}

?>

<?php include 'includes/head.php'; ?>

<style>
    #login-box {

        padding: 20px;
        margin-top: 120px;
        margin-bottom: 20px;
        margin-left: auto;
        margin-right: auto;
        max-width: 500px;
        max-height: 500px;
        border: 1px solid #ffeccc;
        border-radius: 25px;
        background-color: #000;
        color: #fff;
    }

    #llogin {
        background: linear-gradient(45deg, #cf4e12, #f3219c);
        border: none;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: bold;
        border-radius: 50px;
        max-width: 200px;
        min-width: 140px;
        padding: 10px;
        box-shadow: 1px 6px 3px 1px rgb(0 0 0 / 20%);
    }
</style>

<body>

    <div class="container justify-content-center align-items-center">
        <div id="login-row" class="row justify-content-center align-items-center">

            <div id="login-box" class="col-md-12">

                <form id="login-form" class="form" action="sqls/verifica_login.php" method="post">
                    <div class="form-group d-flex justify-content-center">
                        <img src="assets/img/favicon.png" width="100px" class="img-responsive upp">
                    </div>

                    <div class="form-group lg">
                        <label for="email" class="text-info text-light">Usuário ou e-mail:</label><br>
                        <input type="email" required="" autofocus="" name="email_lg" id="emaillg" class="form-control" placeholder="E-mail">
                    </div>
                    <div class="form-group lg">
                        <label for="senhalg" class="text-info text-light">Senha:</label><br>
                        <input type="password" name="senha_lg" id="senhalg" class="form-control" placeholder="Senha" required="">
                    </div>
                    <div>

                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                                <input type="radio" class="form-check-input" id="radio1" name="optradio" value="colaborador" checked="active"><strong>Colaboradores</strong>
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="radio2" name="optradio" value="profissional"><strong>Profissionais</strong>
                            </label>
                        </div>
                    </div>
                    <br>

                    <div class="form-row ccenter-between">
                        <div class="form-group">
                            <button type="submit" id="llogin" class="btn btn-md btn btn-info btn-flat" name="logar"><i class="fa fa-mail-forward" aria-hidden="true"></i> Login</button>
                        </div>
                        <div class="form-group">

                        </div>

                    </div>
                </form>

            </div>

            <!-- </div> -->
        </div>

        <!-- </main> -->
    </div>

    <?php include 'modals/modal_adm.php'; ?>

</body>

</html>