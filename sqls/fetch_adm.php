<?php
include_once('../conexao.php');
// $database = new connDB();
// $db = $database->open();

$conn = $pdo->open();

try {
    // $sql = 'SELECT * FROM members';

    $stmt = $conn->prepare("SELECT * FROM usuarios_a ORDER BY nome ASC");
    $stmt->execute();
    foreach ($stmt as $row) {

        $active = (!$row['id_status']) ? '<span class="pull-right"><a href="#activate" class="btn btn-success btn-md" onclick="setAtivaModal(' . $row['id_user'] . ',' . $row['user_tipo'] .')" data-toggle="modal" ><i class="fa fa-check"> Ativar</i></a></span>' : '<span class="pull-right"><a href="#desactivate" class=" btn btn-danger btn-md" onclick="setDesativaModal(' . $row['id_user'] . ',' . $row['user_tipo'] .')" data-toggle="modal" ><i class="fa fa-check"> Desativar</i></a></span>';

?>
        <tr>
            <td class="text-left"><?php echo $row['nome']; ?></td>
            <td class="text-center" width="200px">
                <?php echo $active ?>
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