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
if (isset($_POST['chave'])) {

    $token = $_POST['chave'];

    $conn = $pdo->open();
    try {
        $stmt = $conn->prepare("SELECT * FROM gtoken as tg
        LEFT JOIN profissionais as pf on tg.id_prof = pf.id_prof
        LEFT JOIN usuarios_a as uss on tg.id_user = uss.id_user
        WHERE tg.token = :e ORDER BY tg.paciente ASC LIMIT 1");
        $stmt->bindValue(":e", $token, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $timestamp = strtotime($row['datacad']);

            $edit = ($_SESSION['usuario']['tipo'] != 2) ? '' : '<button class="btn btn-warning btn-sm etoken" data-toggle="modal" data-target="#editt" data-id="' . $row["token"] . '"><span class="glyphicon glyphicon-trash"></span> Editar</button>';

            $delette = ($_SESSION['usuario']['tipo'] != 2) ? '' : '<button class="btn btn-danger btn-sm deletec" data-id="' . $row["id_token"] . '"><span class="glyphicon glyphicon-trash"></span> Excluir</button>';

?>


            <?php include '../includes/msg.php'; ?>
            <?php $exbdata = date("d/m/Y - H:i", $timestamp) . "h"; ?>

            <div class="col-5 p-3 mb-2 bg-success text-white" style="margin-top: 20px"><strong>TOKEN GERADO EM: </strong><?= $exbdata ?>
                <p>
                    <strong>Solicitante do token: </strong><?= $row['nome'] ?>
                </p>
            </div>


            <div class="row">
                <div class="col-6 align-self-start">

                    <p><strong>Paciente: </strong><?= $row['paciente']; ?></p>
                    <p><strong>CPF: </strong><?php echo ofuscaCpf($row['cpf'], 3, 7); ?></p>
                    <p><strong class='doww'><?php echo $row['nomeresp'] ? 'Responsável: ' : ''; ?></strong><?php echo $row['nomeresp']; ?></p>
                    <p><strong class='doww'><?php echo $row['responsavel_f'] ? 'Responsável Financeiro: ' : ''; ?></strong><?php echo $row['responsavel_f']; ?></p>
                    <p><strong class="upp">Profissional: </strong><?= $row['profissional']; ?></p>
                    <p><strong>Data(s): </strong><?= $row['datapag'] ?></p>

                    <?php

                    switch ($row['modalidadepag']) {
                        case 'Avaliação T':
                            $tipo = 'Avaliação Terapia';
                            break;
                        case 'Avaliação F':
                            $tipo = 'Avaliação Fono';
                            break;
                        case 'Avaliação N':
                            $tipo = 'Avaliação Neuropsicológica';
                            break;
                        case 'Visita E':
                            $tipo = 'Visita Escolar';
                            break;
                        case 'Proase':
                            $tipo = 'Proase';
                            break;
                        case 'Plano Mensal':
                            $tipo = 'Plano Mensal';
                            break;
                        case 'Consulta Psiquiatra':
                            $tipo = 'Consulta Psiquiatra';
                            break;
                        case 'Consulta Nutrição':
                            $tipo = 'Consulta Nutrição';
                            break;
                        default:
                            $tipo = '';
                            break;
                    }

                    ?>

                    <p><strong>Tipo de pagamento: </strong><?= $row['tipopag']; ?></p>
                    <p><strong class='doww'>Modalidade: </strong><?php echo $tipo; ?></p>
                    <p><strong>Valor R$ </strong> <?= number_format($row['valorpag'], 2, ",", "."); ?></p>
                    <?php
                    if ($row['obs']) {
                        echo '<p><strong>Observação: </strong>' . $row['obs'] . '';
                    };
                    ?></p>

                    <p><strong class="doww">Token gerado: </strong><?= $row['token']; ?></p>
                    <div class="text-left" width="200px" style="margin-top: 50px">
                        <?php echo  $edit; ?>
                        <?php echo $delette; ?>
                    </div>

                </div>
            </div>


        <?php
        } else {

        ?>
            <?php include '../includes/msg.php'; ?>
            <div class="row">
                <div class="col-12 align-self-start">
                    <p>
                        <strong class="upp">Token inválido! </strong>
                    </p>
                    <p style="color: red;">
                        Verifique o número e digite novamente.
                    </p>
                </div>
            </div>
<?php

        }
        // $_SESSION['msg_modal'] = 'msg';
    } catch (PDOException $e) {
        $_SESSION['error'] = "Problema com a conexão: " . $e->getMessage();
        header('location: gerar_codigo.php?status=Erro');
        exit;
    }
    $pdo->closeConection();
}
?>
<?php

function ofuscaCpf($cpf, $inicio, $qtd)
{
    $caracter = str_repeat('*', $qtd);
    return substr_replace($cpf, $caracter, $inicio, $qtd);
}

?>