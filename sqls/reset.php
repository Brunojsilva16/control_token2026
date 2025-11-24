<?php

include '../conexao.php';

use PHPMailer\PHPMaer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// $mail = new PHPMailer\PHPMailer\PHPMailer();

require '../vendor/autoload.php';

// echo '<pre>';
// print_r($_POST);
// echo  '</pre>';
// exit;

//Create an instance; passing `true` enables exceptions
if (isset($_POST['reset'])) {

	$email = $_POST['email'];
	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT * FROM profissionais WHERE email_p=:email");
	$stmt->execute(['email' => $email]);

	if ($stmt->rowCount() > 0) {

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		// echo $row['id_prof'];
		// generate code
		$setstr = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($setstr), 0, 14);

		$stmt = $conn->prepare("UPDATE profissionais SET code_reset=:code WHERE id_prof=:id");
		$stmt->execute(['code' => $code, 'id' => $row['id_prof']]);


		$pdo->closeConection();

		echo $message = "
					<h2>Redefinição de senha</h2>
					<p>Sua conta:</p>
					<p>Email: " . $email . "</p>
					<p>Clique no link abaixo para redefinir sua senha.</p>
					<a href='https://clinicaassista.com.br/token/password_reset.php?code=" . $code . "&user=" . $row['id_prof'] . "'>Reset Senha</a>
				";

		echo '
			<script type="text/javascript">
	
			$(document).ready(function(){
	
			swal({
				html: "<h2>Redefinição de senha</h2>
				<p>Sua conta:</p>
				<p>Email: " . $email . "</p>
				<p>Clique no link abaixo para redefinir sua senha.</p>
				<a href="https://clinicaassista.com.br/token/password_reset.php?code="' . $code . '"&user="' . $row['id_prof'] . '">Reset Senha</a>
				"";
			})
			});
	
			</script>';
	} else {
		$pdo->closeConection();

		echo '
		<script type="text/javascript">

		$(document).ready(function(){

		swal({
			position: "top-end",
			type: "success",
			title: "Email não encontrado!",
			showConfirmButton: false,
			timer: 1500
		})
		});

		</script>';
	}
} else {

	echo '
		<script type="text/javascript">

		$(document).ready(function(){

		swal({
			position: "top-end",
			type: "success",
			title: "E-mail ou conta inexistente!",
			showConfirmButton: false,
			timer: 1500
		})
		});

		</script>';
}
