<?php
include_once('../conexao.php');

$output = array('error' => false);
$conn = $pdo->open();

try{    

    $stmt = $conn->prepare("SELECT * FROM listagem 
    WHERE status_li = 1 ORDER BY id_list ASC");
    $stmt->execute();
    $output['listaformapag'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    $output['error'] = true;
    $output['message'] = $e->getMessage();
}

$pdo->closeConection();
echo json_encode($output);

?>
