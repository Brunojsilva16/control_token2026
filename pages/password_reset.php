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
        background-color: #973c3c;
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
                <span id="alert_message"></span>

                <form id="password_new">
                    <h3 class="text-center text-white" style="font-size: 22px; margin-bottom: 30px;"><strong>Digite a nova senha</strong></h3>
                    <div class="row">
                        <div class="form-group col-12">
                            <input id="senhac" type="password" class="form-control" name="password" placeholder="Nova senha" required autocomplete="on">
                            <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
                        </div>
                        <div class="form-group col-12">
                            <input id="senhav" type="password" class="form-control" name="repassword" placeholder="Redigite a senha" required autocomplete="on">
                            <span id="infoalerta"></span>
                            <!-- <span class="infoAlerta"></span> -->
                            <!-- <span class="glyphicon glyphicon-log-in form-control-feedback"></span> -->
                        </div>
                        <div class="col-6">
                            <input type="hidden" id="code" class="form-control" name="code" value="<?php echo $_GET['code']; ?>">
                            <input type="hidden" id="user" class="form-control" name="user" value="<?php echo $_GET['user']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-success s-valid" name="reset" style="margin-left: 15px;"><i class="fa fa-check-square-o"></i> Alterar senha</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <div id="aback" class="text-left">
                            <a href="index.php" class="text-white"><i class="fa fa-home"></i> Home</a>

                        </div>
                    </div>
                </form>

            </div>

            <!-- </div> -->
        </div>


        <!-- </main> -->
    </div>

    <?php include 'includes/scripts.php'; ?>

</body>

</html>