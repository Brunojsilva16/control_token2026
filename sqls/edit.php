<?php
include_once('../conexao.php');
include '../includes/sessao.php';
include '../includes/timezone.php';
?>

<?php

// echo '<pre>';
// print_r($_POST);
// echo  '</pre>';
// exit;

// $output['tipo'] = print_r($_POST);
// exit;

$output = array('error' => false);

$pacientex = $_POST['paciente'];
$cpfx = $_POST['cpf'];
$respx = $_POST['resp'];
$respfinanc = $_POST['respfinanc'];
$idd = $_POST['id'];
$idprofx = $_POST['idprof'];

$pag_resp = $_POST['pag_resp'];
$listbanco = $_POST['listbanco'];

$dataHoraCompleta = $_POST["data_atual"];

// Separar a data e a hora
list($apenasData, $apenasHora) = explode(' ', $dataHoraCompleta);

if (isset($_POST["nova_data"])) {
    $novaData = $_POST["nova_data"]; // Recebe a data no formato YYYY-MM-DD do input type="date"
    $novaDataHora = $novaData . ' ' . $apenasHora;
} else {
    $novaDataHora = $_POST["data_atual"];
}

$v = "";
foreach ($_POST['datac'] as $id => $value) {
    if ($value != '') {
        $v .= $value . ", ";
    }
}
$v_datac = rtrim($v, ", ");

$modalidaderef = $_POST['modalidaderef'];
$v_valor = $_POST['v_negociavel'];
// remove somente e manter os números inteiros e divido-los por 100.
$valor = preg_replace('/[^0-9]/', '', $v_valor);
$valor = bcdiv($valor, 100, 2);
$vpag = strtr($valor, ',', '.');

$tipopag = $_POST['tipopag'];

$obs = (!empty($_POST['obs'])) ? $_POST['obs'] : "";
$tokken = $_POST['idtokk'];

// // retorno para página 1
$idpag = $_POST['idpag'];

try {
    $conn = $pdo->open();

    $sql = "UPDATE `gtoken` SET paciente=?, cpf=?, nomeresp=?, responsavel_f=?, pag_resp=?, nome_banco=?, id_prof=?, modalidadepag=?, valorpag=?, tipopag=?, datapag=?, datacad=?, obs=? WHERE id_token=?";

    $paramValue = array(
        $pacientex,
        $cpfx,
        $respx,
        $respfinanc,
        $pag_resp,
        $listbanco,
        $idprofx,
        $modalidaderef,
        $vpag,
        $tipopag,
        $v_datac,
        $novaDataHora,
        $obs,
        $idd
    );

    $result = $conn->prepare($sql);

    if ($paramValue) {
        foreach ($paramValue as $key => $val) {
            // $type = (is_numeric($val) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
            $result->bindValue($key + 1, $val);
        }
    }

    $result->execute();
    $row_count = $result->rowCount();

    //if-else statement executing query
    if ($row_count > 0) {
        $output['message'] = 'Cadastro atualizado com Sucesso!';
        // retorno para página 1
        $output['page'] = $idpag;
        $output['idtoken'] = $tokken;
    } else {
        $output['error'] = true;
        $output['message'] = 'Erro inesperado!';
    }
} catch (PDOException $e) {
    $output['error'] = true;
    $output['message'] = $e->getMessage();
}

//close connection
$pdo->closeConection();

echo json_encode($output);
?>