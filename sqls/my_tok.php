<?php include '../includes/timezone.php'; ?>
<?php include '../conexao.php'; ?>
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {

	session_start([
		'cookie_lifetime' => 28800,
		'gc_maxlifetime' => 28800,
	]);
}

?>

<?php
//VALIDAÇÃO DO POST

$output = array('error' => false);
$conn = $pdo->open();

$token = $_POST['chave'];
$tipo = $_POST['tipo'];
// $idd = $_POST['id'];

try {
    $stmt = $conn->prepare("SELECT * FROM gtoken as tg
        LEFT JOIN profissionais as pf on tg.id_prof = pf.id_prof
        LEFT JOIN usuarios_a as uss on tg.id_user = uss.id_user
        WHERE tg.token = :e ORDER BY tg.paciente ASC LIMIT 1");
    $stmt->bindValue(":e", $token, PDO::PARAM_STR);
    $stmt->execute();
    $output['data'] = $stmt->fetch();
    $output['typeconsulta'] = $tipo;

} catch (PDOException $e) {
    $output['error'] = true;
    $output['message'] = $e->getMessage();
}

//close connection
$pdo->closeConection();

echo json_encode($output);

?>