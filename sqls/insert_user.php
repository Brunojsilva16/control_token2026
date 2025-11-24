<?php include '../includes/timezone.php'; ?>

<?php
if (session_status() !== PHP_SESSION_ACTIVE) {

	session_start([
		'cookie_lifetime' => 28800,
		'gc_maxlifetime' => 28800,
	]);
}
?>
<?php


if ($_POST['sbmSalvar'] == 'Salvar') {

    include '../conexao.php';

    try {

        $nome = isset($_POST['nomeuser']) ? trim($_POST['nomeuser']) : NULL;
        $email = isset($_POST['emailuser']) ? trim($_POST['emailuser']) : NULL;
        $senha = isset($_POST['senhauser']) ? trim($_POST['senhauser']) : NULL;
        $password = password_hash($senha, PASSWORD_DEFAULT);
        $crp = isset($_POST['v_crp']) ? trim($_POST['v_crp']) : NULL;
        $usuario = isset($_POST['userTipoRadio']) ? trim($_POST['userTipoRadio']) : NULL;
        // $datacad = date("d/m/Y - H:i:h");
        $datacad = date("Y-m-d H:i:h");

        $conn = $pdo->open();

        if (($_POST['userTipoRadio'] > 1)) {

            $stmt = $conn->prepare("INSERT INTO `usuarios_a`(`nome`, `email`, `senha`, `user_tipo`, `id_status`, `data_cad`)
                VALUES (:nome, :email, :senha, :user_tipo, :id_status, :datacad)");

            $stmt->bindValue(":nome", $nome);
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":senha", $password);
            $stmt->bindValue(":user_tipo", $usuario);
            $stmt->bindValue(":id_status", 0);    
            $stmt->bindValue(":datacad", $datacad);
            $stmt->execute();
        } else {
            //Insert TB Assista 
            $stmt = $conn->prepare("INSERT INTO `profissionais`(`nomep`, `emailp`, `senhap`, `crp`, `user_tipo`, `id_status`, `data_cadp`)
        VALUES (:nome, :email, :senha, :crp, :user_tipo, :id_status, :datacad)");

            $stmt->bindValue(":nome", $nome);
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":senha", $password);
            $stmt->bindValue(":crp", $crp);
            $stmt->bindValue(":user_tipo", $usuario);
            $stmt->bindValue(":id_status", 0);
            $stmt->bindValue(":datacad", $datacad);
            $stmt->execute();
        }
        // $_SESSION['msg_modal'] ='msg';
        $_SESSION['success'] = 'Cadastro realizado com sucesso!';
        unset($_SESSION['userTipo']);
        unset($_SESSION['emailuser']);
    } catch (PDOException $e) {
        $_SESSION['error'] = "Problema com a conexão: " . $e->getMessage();
    }

    $pdo->closeConection();

    header('location: ../index');
    exit();
} else {
    header('location: ../login');
    exit();
}

?>