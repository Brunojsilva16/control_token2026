<?php
include_once('../conexao.php');


$output = array('error' => false);
$conn = $pdo->open();

try{    
    // $sql = 'SELECT * FROM members';

    $stmt = $conn->prepare("SELECT * FROM profissionais 
    WHERE id_status = 1 AND user_tipo = 1 ORDER BY profissional ASC");
    $stmt->execute();
    $output['dataprof'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    $output['error'] = true;
    $output['message'] = $e->getMessage();
}
    //close connection
$pdo->closeConection();
echo json_encode($output);
?>