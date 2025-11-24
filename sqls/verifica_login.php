<?php
if (session_status() !== PHP_SESSION_ACTIVE) {

	session_start();
}
?>

<?php

if (!isset($_POST['email_lg']) && !isset($_POST['senha_lg'])) {
    $_SESSION['alertt'] = 'Todos os campos são obrigatórios!';
    // echo print_r($_SESSION);

    header('location: ../home');
    exit();
} else {

    include '../conexao.php';

    // "<pre>";
    // echo print_r($_POST);
    // "</pre>";
    // exit;   


    if ($_POST['optradio'] != 'profissional') {

        $query = "SELECT * FROM usuarios_a WHERE email = :e LIMIT 1";
        $sh = 1;
    } else {
        $query = "SELECT * FROM profissionais WHERE email_p = :e LIMIT 1";
        $sh = 0;
    }

    $email = $_POST['email_lg'];

    try {
        $conn = $pdo->open();

        $stmt = $conn->prepare($query);
        $stmt->bindValue(":e", $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $senha = $_POST['senha_lg'];
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['id_status'] == 1) {
                // echo "Id 1";
                $senharow = ($sh > 0) ? $row['senha'] : $row['senha_p'];

                if (password_verify($senha, $senharow)) {

                    $_SESSION['usuario'] = [
                        'id' => $sh > 0 ? $row['id_user'] : $row['id_prof'],
                        'nome' => $sh > 0 ? $row['nome'] : $row['profissional'],
                        'tipo' => $row['user_tipo'],
                        'nivel' => $row['nivel_acesso']
                    ];
                    header('location: ../home');
                    exit();
                    // echo print_r($_SESSION);
                } else {
                    $_SESSION['alertt'] = 'Senha incorreta!';
                    header('location: ../login');
                    exit();
                    // echo print_r($_SESSION);
                }
            } else {
                // echo "id 2";
                $_SESSION['alertt'] = 'Conta ainda não está activa!';
                header('location: ../login');
                exit();
                // echo print_r($_SESSION);
            }
        } else {
            $_SESSION['danger'] = 'Email não encontrado!';
            header('location: ../login');
            exit();
            // echo print_r($_SESSION);
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Problema com a conexão: " . $e->getMessage();
    }
    $pdo->closeConection();
}

?>