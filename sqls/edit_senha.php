<?php include '../includes/timezone.php'; ?>
<?php include '../conexao.php'; ?>

<?php

$output = array('error' => false);

$code = $_POST['code'];
$user = $_POST['user'];
$check = null;

$password = $_POST['password'];

$conn = $pdo->open();

$stmt = $conn->prepare("SELECT * FROM profissionais WHERE code_reset=:code AND id_prof =:id LIMIT 1");
$stmt->bindValue(":code", $code, PDO::PARAM_STR);
$stmt->bindValue(":id", $user, PDO::PARAM_STR);
$stmt->execute();
// $stmt->execute(['code'=>$_GET['code'], 'id'=>$_GET['user']]);
$row = $stmt->fetch();

if ($stmt->rowCount() > 0) {

    $password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("UPDATE profissionais SET senha_p=:senh, code_reset=:cod WHERE id_prof =:id");
        $stmt->execute(['senh' => $password, 'cod' => $check, 'id' => $row['id_prof']]);
        $output['message'] = 'Senha alterada com sucesso';
    } catch (PDOException $e) {
        $output['error'] = true;
        $output['error'] = $e->getMessage();
    }
} else {
    // $output['error'] = 'Código expirado ou ID não correspondem ao usuário';
    $output['error'] = true;
    $output['message'] = 'Código expirado ou ID não correspondem ao usuário';
}

$pdo->closeConection();

echo json_encode($output);

?>