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
		<div class="p-3 mb-2 bg-secondary text-white">Cadastro Usuário</div>

		<form autocomplete="off" class="row col-12" id="form-cad" method="post" action="sqls/insert_user.php" enctype="multipart/form-data" onsubmit="return validate()">

			<div class="row">

				<div class="col-12 align-self-start upp doww">
					<strong>Tipo de usuário</strong>
				</div>

				<div class="form-group col-md-12">
					<label>
						<?= $_SESSION['userTipo'] == '2' ? 'Atendente' : 'Profissional'; ?>
					</label>
					<input type="hidden" name="userTipoRadio" value="<?= $_SESSION['userTipo']; ?>">
				</div>
				<div class="col-8 align-self-start upp doww">
					<label for="emailc"> <strong>Email:</strong> <span class="obrig"></span></label>
				</div>

				<div class="form-group col-md-8">
					<label>
						<?= $_SESSION['emailTipo']; ?>
					</label>
					<input type="hidden" id="email" name="emailuser" value="<?= $_SESSION['emailTipo']; ?>">
				</div>

				<div class="col-8 align-self-start upp doww">
					<label for="nomec" class="cad"><strong>Nome</strong><span class="obrig"> *</span></label>
				</div>

				<div class="form-group col-md-8">
					<input id="nomec" name="nomeuser" type="text" class="form-control" placeholder="Nome" maxlength="80" required>
				</div><br>


				<div class="col-12 align-self-start upp doww">
					<label for="senha"><strong>Senha</strong><span class="obrig"> *</span></label>
				</div>

				<div class="form-group col-md-8">
					<input type="password" id="senha" onchange="validarSenha()" name="senhauser" class="form-control" placeholder="Digite sua senha" maxlength="16" minlength="6">
				</div>

				<div class="col-12 align-self-start upp doww">
					<label for="datanasc"><strong>CRP/Outro</strong></label>
				</div>
				<div class="form-group col-md-8">
					<span onclick="activatecad();">
						<input type="text" id="crp" name="v_crp" value="" class="form-control" <?= $_SESSION['userTipo'] != '1' ? 'disabled="disabled"' : ''; ?> required>
					</span>
				</div>
				<div class="col-md-8 d-flex justify-content-between">
					<a href="cadastro_user.php" class="btn btn-outline-secondary upp">voltar</a>
					<button type="submit" id="sbmSalvar" name="sbmSalvar" value="Salvar" class="btn btn-info upp doww">Salvar</button>
				</div>

			</div>
		</form>

	</div>

	<?php include 'includes/scripts.php'; ?>
</body>

</html>