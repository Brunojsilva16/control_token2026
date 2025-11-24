<?php
include_once('../conexao.php');


if (isset($_POST['e_id'])) {
    $tipolist = $_POST['e_id'];

$output = array('error' => false);
$conn = $pdo->open();

try{    
    // $sql = 'SELECT * FROM members';

    $stmt = $conn->prepare("SELECT * FROM listagem 
    WHERE status_li = 1 AND tipo_li = :tp ORDER BY id_list ASC");
    $stmt->bindValue(":tp", $tipolist, PDO::PARAM_STR);
    $stmt->execute();
    $output['listaconsulta'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    $output['error'] = true;
    $output['message'] = $e->getMessage();
}
$pdo->closeConection();
echo json_encode($output);
}

    //close connection


