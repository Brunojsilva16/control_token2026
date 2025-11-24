<?php
include_once('../conexao.php');
include '../includes/sessao.php';
// $database = new connDB();
// $db = $database->open();

$conn = $pdo->open();

try {

    $token = $_SESSION['usuario']['id'];

    if ($_SESSION['usuario']['tipo'] != 2) {

        $stmt = $conn->prepare("SELECT * FROM gtoken as tg
        -- LEFT JOIN profissionais as pf on tg.id_prof = pf.id_prof
        LEFT JOIN usuarios_a as uss on tg.id_user = uss.id_user
        WHERE pf.id_prof = :e ORDER BY tg.datacad DESC, tg.paciente ASC LIMIT 10");
        $stmt->bindValue(":e", $token, PDO::PARAM_STR);

    } else {

        $stmt = $conn->prepare("SELECT * FROM gtoken as tg
        LEFT JOIN usuarios_a as uss on tg.id_prof = uss.id_prof
        -- LEFT JOIN usuarios_a as uss on tg.id_user = uss.id_user
        ORDER BY tg.datacad DESC, tg.paciente ASC LIMIT 50");
  
    }

    $stmt->execute();

    foreach ($stmt as $row) {

        $viewToken = '<button class="btn btn-info btn-sm vtoken" data-toggle="modal" data-target="#viewModal" data-id="' . $row["token"] . '" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-trash"></span> Token</button>';

        $edit = ($_SESSION['usuario']['tipo'] != 2) ? '' : '<button class="btn btn-warning btn-sm etoken" data-toggle="modal" data-target="#editt" data-id="' . $row["token"] . '" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-trash"></span> Editar</button>';

        $delette = ($_SESSION['usuario']['tipo'] != 2) ? '' : '<button class="btn btn-danger btn-sm deletef" data-id="' . $row["id_token"] . '" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-trash"></span> Excluir</button>';

    ?>
        <tr>
            <td class="text-left"><?php echo $row['paciente']; ?></td>
            <td class="text-center" width="180px"><?php echo $row['token']; ?></td>
            <td class="text-left"><?php echo $row['nomep']; ?></td>
            <td class="text-center" width="180px">
                <?php
                $date = date_create($row['datacad']);
                echo date_format($date, 'd/m/Y');
                ?>
            </td>
            <td class="text-center" width="180px">
                <?php echo $row['statuspag']; ?>
            </td>
            <td class="text-center" width="200px">
                <?php echo  $viewToken; ?>
                <?php echo  $edit; ?>
                <?php echo  $delette; ?>
            </td>
        </tr>
<?php
    }
} catch (PDOException $e) {
    echo "There is some problem in connection: " . $e->getMessage();
}

//close connection
$pdo->closeConection();
?>