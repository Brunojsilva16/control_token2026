<?php $title = "Cadastro"; ?>
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {

	session_start([
		'cookie_lifetime' => 28800,
		'gc_maxlifetime' => 28800,
	]);
}

if (isset($_SESSION['usuario'])) {

    header('Location: home');
    exit();
}

?>

<?php include 'includes/head.php'; ?>

<body>

	<div class="container text-star">
	<?php include 'includes/msg.php'; ?>
		<div class="p-3 mb-2 bg-secondary text-white">Cadastro Usuário</div>

		<form autocomplete="off" class="row col-12" id="form-cad" method="post" action="sqls/verifica_cad.php" enctype="multipart/form-data" onsubmit="return validate()">

			<div class="row">

				<div class="col-12 align-self-start upp doww">
					<strong>Tipo de usuário</strong>
				</div>


				<div class="form-group col-md-12">
					<div class="form-group">

						<div class="col-12 align-self-start">
							<div class="form-check doww">
								<input class="form-check-input" type="radio" name="userTipoRadio" id="flexRadio1" checked value="2">
								<label class="form-check-label" for="flexRadio1">
									Atendente
								</label>
							</div>
							<div class="form-check doww">
								<input class="form-check-input" type="radio" name="userTipoRadio" id="flexRadio2" value="1">
								<label class="form-check-label" for="flexRadio2">
									Profissional
								</label>
							</div>

						</div>
					</div>
				</div>

				<div class="col-8 align-self-start upp doww">
					<label for="emailc"><strong>Email:</strong> <span class="obrig"></span></label>
				</div>

				<div class="form-group col-md-8">
					<input type="email" id="email" name="emailuser" class="form-control" maxlength="60" placeholder="seu@email" required>
				</div>
				<div class="col-md-8 d-flex justify-content-between">
					<a href="login" class="btn btn-outline-secondary upp">voltar</a>
					<button type="submit" id="sbmSalvar" name="newEmail" value="Salvar" class="btn btn-info upp doww">Continuar</button>
				</div>

			</div>
		</form>

	</div>

	<?php include 'includes/scripts.php'; ?>
</body>

</html>