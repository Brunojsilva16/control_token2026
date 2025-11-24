<?php
include_once('../conexao.php');


// if (isset($_POST['e_id'])) {
//     $tipolist = $_POST['e_id'];

$output = array('error' => false);
$conn = $pdo->open();

try{    
    // $sql = 'SELECT * FROM members';

    $stmt = $conn->prepare("SELECT * FROM profissionais 
    WHERE id_status = 1 AND user_tipo = 1 ORDER BY profissional ASC");
    // WHERE status_li = 1 AND tipo_li = :tp ORDER BY id_list ASC");
    $stmt->execute();
    $output['listaprof'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    $output['error'] = true;
    $output['message'] = $e->getMessage();
}

$pdo->closeConection();
echo json_encode($output);
// }
?>
