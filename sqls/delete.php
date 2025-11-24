<?php
include_once('../conexao.php');

$output = array();
$output['error'] = false;


// echo '<pre>';
// print_r($_POST);
// echo  '</pre>';
// exit;

$idd = $_POST['iddel'];
$idpag = $_POST['idpag'];

// $output['tipo'] = $_POST;

try {
    $conn = $pdo->open();

    $stmt = $conn->prepare("DELETE FROM `gtoken` WHERE `id_token` = :idp");
    $stmt->bindValue(":idp", $idd, PDO::PARAM_INT);
    $stmt->execute();

    //if-else statement executing query

    if ($stmt->rowCount() > 0) {

        // $_SESSION['success'] = 'Cadastro excluido com sucesso!';
        $output['message'] = 'Excluido com sucesso!';
        // retorno para página 1
        $output['page'] = $idpag;
    } else {
        $output['error'] = true;
        $output['message'] = 'Erro inesperado!';
    }
} catch (PDOException $e) {
    $output['error'] = true;
    $output['message'] = "Problema com a conexão: " . $e->getMessage();
}

$pdo->closeConection();
// header('location: ../index.php');
echo json_encode($output);
