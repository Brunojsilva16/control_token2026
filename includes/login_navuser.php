
  <?php

  if (isset($_SESSION['usuario'])) {
   $usuario = $_SESSION['usuario']['nome'].  '<br>' . '<a href="logout" class="btn btn-outline-danger btn-sm" style="color: #fff;">Encerrar</a>';
    // echo $usuario = $_SESSION['usuario']['nome']. ' | ' . '<a href="logout.php" class="text-light font-weight-bold ml-2">Sair</a>';
  } else {
     $usuario = '<a href="login.php" class="text-light font-weight-bold ml-2">Entrar</a>';
  }

 ?>
