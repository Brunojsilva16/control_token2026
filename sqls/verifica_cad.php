<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<?php

if ($_POST['newEmail'] == 'Salvar') {

    include '../conexao.php';

    $emailcad = $_POST['emailuser'];
    $usuario = $_POST['userTipoRadio'];

    try {
        $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT * FROM profissionais 
            WHERE emailp = :e LIMIT 1");
            $stmt->bindValue(":e", $emailcad, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['alertt'] = "Este e-mail - {$emailcad} <br/> já está cadastrado!";
                header('location: ../cadastro_user');
                exit();
            } 

            $stmt2 = $conn->prepare("SELECT * FROM usuarios_a 
            WHERE email = :e LIMIT 1");
            $stmt2->bindValue(":e", $emailcad, PDO::PARAM_STR);
            $stmt2->execute();
    
            if ($stmt2->rowCount() > 0) {
                $_SESSION['alertt'] = "Este e-mail - {$emailcad} <br/> já está cadastrado!";
                header('location: ../cadastro_user');
                exit();
                echo "aqui já cadastrado 2";
            } else {   
                    $_SESSION['emailTipo'] = $emailcad;
                    $_SESSION['userTipo'] = $usuario;
                    header("Location: ../cadastro_f");
                    exit;
            }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Problema com a conexão: " . $e->getMessage();
    }
    $pdo->closeConection();

} else {   
    header('location: ../login');
    exit();
}
?>