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


$rediretion = '../index';

if (isset($_POST['activate']) or isset($_POST['desactivate'])) {
	$iduser = $_POST['id_u'];

	switch ($_POST) {
		case isset($_POST['activate']):
			$status_value = 1;
			if ($_POST['tipo_u'] != 2) {
				$query = "UPDATE profissionais SET id_status = :status WHERE id_prof = :id";
				$rediretion = '../profissionais';
			} else {
				$query = "UPDATE usuarios_a SET id_status = :status WHERE id_user = :id";
				$rediretion = '../adm';
			}
			break;
		case isset($_POST['desactivate']):
			$status_value = 0;
			if ($_POST['tipo_u'] != 2) {
				$query = "UPDATE profissionais SET id_status = :status WHERE id_prof = :id";
				$rediretion = '../profissionais';
			} else {
				$query = "UPDATE usuarios_a SET id_status = :status WHERE id_user = :id";
				$rediretion = '../adm';
			}
			break;
	}
} else {
	$_SESSION['error'] = 'Metodo incorreto de acesso!';
	header('location: ../home');
	exit();
}

try {

	$conn = $pdo->open();
	// activate

	$stmt = $conn->prepare($query);
	$stmt->bindValue(":status", $status_value);
	$stmt->bindValue(":id", $iduser);
	$stmt->execute();

	// $_SESSION['msg_modal'] ='msg';
	// $_SESSION['success'] = 'Cadastro ativado com sucesso!';
	unset($_SESSION['userTipo']);
	unset($_SESSION['emailuser']);


	if ($stmt->rowCount() > 0) {

		$status_value == 1 ? $_SESSION['success'] = 'Cadastro ativado com sucesso!'
			: $_SESSION['success'] = 'Cadastro desativado com sucesso!';
		$pdo->closeConection();
		header('location:' .$rediretion);
		exit();
	} else {
		$pdo->closeConection();
		$_SESSION['error'] = 'Erro inexperado';
	}
} catch (PDOException $e) {
	$_SESSION['error'] = "Problema com a conexão: " . $e->getMessage();
	$pdo->closeConection();
}

?>