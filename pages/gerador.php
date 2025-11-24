<?php $title = "Controle"; ?>
<?php include 'includes/timezone.php'; ?>
<?php include './conexao.php'; ?>
<?php include 'includes/sessao.php'; ?>
<?php
if ($_SESSION['usuario']['tipo'] != 2) {
    header('Location: home');
    exit();
} else {
    $sideb = 'includes/siderbar.php';
}
?>
<?php include 'includes/head.php'; ?>

<body>
    <?php
    // echo '<pre>';
    // print_r($_POST);
    // echo  '</pre>';
    // exit;
    ?>

    <div class="wrapper">
        <div class="section">
            <div class="top_navbar">
                <div class="hamburger">
                    <a href="#">
                        <div id="hamburgerBar" class="container" onclick="myFunction(this)">
                            <div class="bar1"></div>
                            <div class="bar2"></div>
                            <div class="bar3"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="container-fluid" style="background-color: #f5f6fa;">
                <?php include $sideb; ?>
                <div class="container">

                    <span id="alert_message"></span>
                    <?php

                    // echo $vdt . "<br>";                    
                    // echo $v;
                    // exit();

                    //VALIDAÇÃO DO POST
                    $nomepaciente = $_POST['nomepaciente'];
                    $cpf = $_POST['cpf'];
                    $nomeresp = (!empty($_POST['nomeresp'])) ? $_POST['nomeresp'] : NULL;
                    $profSelect = $_POST['profSelect'];
                    $sMes = $_POST['mesSelect'];
                    $sAno = $_POST['anoSelect'];
                    $v = "";
                    foreach ($_POST['datac'] as $id => $value) {
                        if ($value != '') {
                            $v .= $value . ", ";
                        }
                    }
                    $v_datac = rtrim($v, ", ");

                    $modalidadeRadio = $_POST['modalidadeRadio'];
                    $v_valor = $_POST['v_negociavel'];
                    $tipopag = (!empty($_POST['listforma'])) ? $_POST['listforma'] : NULL;
                    $statuspag = $_POST['pagamentoRadio'];
                    $obs = (!empty($_POST['obs'])) ? $_POST['obs'] : NULL;
                    $usuario = $_POST['userSelect'];
                    $exib = $_POST['userExib'];
                    // remover somente manter os números inteiros e divido-los por 100.
                    $valor = preg_replace('/[^0-9]/', '', $v_valor);
                    $valor = bcdiv($valor, 100, 2);
                    $vpag = strtr($valor, ',', '.');

                    $conn = $pdo->open();
                    try {

                        $stmt = $conn->prepare("SELECT * FROM profissionais WHERE id_prof = :e LIMIT 1");
                        $stmt->bindValue(":e", $profSelect, PDO::PARAM_STR);
                        $stmt->execute();

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        $_SESSION['error'] = "Problema com a conexão: " . $e->getMessage();
                    }
                    $pdo->closeConection();

                    $setstr = '0123456789';
                    $tokenNew = substr(str_shuffle($setstr), 0, 2);
                    $tokenNew .= time();
                    $tokenNew .= substr(str_shuffle($setstr), 0, 4);

                    $datacad = date("Y-m-d H:i:h");
                    $timestamp = strtotime($datacad);

                    try {
                        $conn = $pdo->open();

                        $stmt = $conn->prepare("INSERT INTO `gtoken`(`paciente`, `cpf`, `nomeresp`, `id_prof`, `modalidadepag`, `valorpag`, `tipopag`, `mes_ref`, `ano_ref`, `datapag`, `statuspag`, `obs`, `token`, `id_user`, `datacad`)
                        VALUES (:npacient, :cpf, :nResponsavel, :id_pro, :modpag, :vpag, :tipopag, :mesref, :anoref, :datapag, :statuspag, :obs, :token, :usuario, :datacad)");

                        $stmt->bindValue(":npacient", $nomepaciente);
                        $stmt->bindValue(":cpf", $cpf);
                        $stmt->bindValue(":nResponsavel", $nomeresp);
                        $stmt->bindValue(":id_pro", $profSelect);
                        $stmt->bindValue(":modpag", $modalidadeRadio);
                        $stmt->bindValue(":vpag", $vpag);
                        $stmt->bindValue(":tipopag", $tipopag);
                        $stmt->bindValue(":mesref", $sMes);
                        $stmt->bindValue(":anoref", $sAno);
                        $stmt->bindValue(":datapag", $v_datac);
                        $stmt->bindValue(":statuspag", $statuspag);
                        $stmt->bindValue(":obs", $obs);
                        $stmt->bindValue(":token", $tokenNew);
                        $stmt->bindValue(":usuario", $usuario);
                        $stmt->bindValue(":datacad", $datacad);
                        $stmt->execute();

                        $output['error'] = 'Cadastro realizado com sucesso!';
                        // $_SESSION['msg_modal'] = 'msg';
                    } catch (PDOException $e) {
                        $output['error'] = "Problema com a conexão: " . $e->getMessage();
                        exit;
                    }
                    $pdo->closeConection();
                    ?>

                    <div class="container text-star">
                        <?php include 'includes/msg.php'; ?>

                        <?php $exbdata = date("d/m/Y - H:i", $timestamp) . "h"; ?>

                        <div class="col-5 p-3 mb-2 bg-success text-white" style="margin-top: 30px;"><strong>TOKEN GERADO EM: </strong><?= $exbdata ?>
                            <p>
                                <strong>Solicitante do token: </strong><?= $exib ?>
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-12 align-self-start">
                                <p><strong>Paciente: </strong><?= $nomepaciente ?></p>
                                <p><strong>CPF: </strong><?php echo ofuscaCpf($cpf, 3, 7); ?></p>
                                <p><strong class='doww'><?php echo $nomeresp ? 'Responsável: ' : ''; ?></strong><?php echo $nomeresp; ?></p>
                                <p><strong class="upp">Profissional: </strong><?= $row['profissional'];  ?></p>
                                <p><strong>Mês de referência: </strong><?= $sMes . '/' . $sAno ?></p>
                                <p><strong>Data(s): </strong><?= $v_datac ?></p>
                                <p><strong>Tipo de pagamento: </strong><?php echo $tipopag ?></p>

                                <?php

                                switch ($modalidadeRadio) {
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
                                    case 'Proase Av':
                                        $tipo = 'Sessão Avulsa Proase';
                                        break;
                                    case 'Pacote':
                                        $tipo = 'Pacote';
                                        break;
                                    case 'Pacote Av':
                                        $tipo = 'Sessão Avulsa Pacote';
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

                                <p><strong class='doww'>Modalidade: </strong><?php echo $tipo; ?></p>
                                <p><strong>Valor: </strong> <?php echo 'R$ ' . $vpag; ?></p>
                                <p><strong>Status Pagamento: </strong><?php echo $statuspag; ?></p>
                                <p><strong class='doww'><?php echo $obs ? 'Obs: ' : ''; ?></strong><?php echo $obs; ?></p>
                                <p><strong class="doww">Token gerado: </strong><?php echo $tokenNew ?></p>
                            </div>
                            <?php

                            function ofuscaCpf($cpf, $inicio, $qtd)
                            {
                                $caracter = str_repeat('*', $qtd);
                                return substr_replace($cpf, $caracter, $inicio, $qtd);
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include 'includes/scripts.php'; ?>

    <script>
        var hamburger = document.querySelector(".hamburger");
        hamburger.addEventListener("click", function() {
            document.querySelector("body").classList.toggle("active");
        })

        function myFunction(x) {
            x.classList.toggle("change");
        }
    </script>

</body>

</html>