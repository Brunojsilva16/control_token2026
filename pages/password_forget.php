<?php $title = "Reset"; ?>
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

<?php

if (isset($_POST['reset'])) {

  $email = $_POST['email'];
  $conn = $pdo->open();

  $stmt = $conn->prepare("SELECT * FROM profissionais WHERE email_p=:email");
  $stmt->execute(['email' => $email]);

  if ($stmt->rowCount() > 0) {

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // echo $row['id_prof'];
    // generate code
    $setstr = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = substr(str_shuffle($setstr), 0, 14);

    $stmt = $conn->prepare("UPDATE profissionais SET code_reset=:code WHERE id_prof=:id");
    $stmt->execute(['code' => $code, 'id' => $row['id_prof']]);

    $pdo->closeConection();

    $message = "
                  <p>Redefinição de senha - " . $row['profissional'] . "</p>
                  <h2>Redefinição de senha</h2>
                  <p>Clique no link abaixo para redefinir sua senha.</p>
                  <a href='https://clinicaassista.com.br/token/password_reset?code=" . $code . "&user=" . $row['id_prof'] . "'>Reset Senha</a>
              ";

  } else {

    $pdo->closeConection();

    $message = "Email não encontrado!";
  }
} else {
  $message = "E-mail ou conta inexistente!";
}
?>

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

<body class="hold-transition login-page">



  <?php include 'includes/msg.php'; ?>

  <div class="container justify-content-center align-items-center">
    <div id="login-row" class="row justify-content-center align-items-center">

      <div id="login-box" class="col-md-12">

        <form id="login-form" class="form" method="post">
          <h3 class="text-center" style="font-size: 22px"><strong>Recuperação de senha</strong></h3>
          <div class="form-group d-flex justify-content-center">
            <img src="assets/img/favicon.png" width="100px" class="img-responsive upp">
          </div>

          <div class="form-group lg">
            <label for="email">Favor, insira o e-mail associado à conta</label><br>
            <input type="email" required autofocus name="email" id="email" class="form-control" required>
          </div>

          <div class="form-row ccenter-between">
            <div class="form-group">
              <button type="submit" id="llogin" class="btn btn-md btn btn-info btn-flat" name="reset"><i class="fa fa-mail-forward" aria-hidden="true"></i> Enviar</button>
            </div>
            <div class="form-group">
              <div class="text-right text-light">
                <a class="text-info text-light" href="home"><i class="fas fa-hand-point-right text-info text-light"></i> Voltar </a><br>
              </div>
            </div>

          </div>
        </form>

        <?php

        echo $message;

        ?>

      </div>
      <!-- </div> -->
    </div>
    <!-- </main> -->
  </div>

  <?php include 'includes/scripts.php'; ?>

</body>

</html>