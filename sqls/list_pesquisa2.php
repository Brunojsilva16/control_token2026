<?php
include_once('../conexao.php');
include '../includes/sessao.php';

$output = [];

$conn = $pdo->open();

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);
// $numb_pag = filter_input(INPUT_GET, "numb", FILTER_SANITIZE_NUMBER_INT);

if (!empty($pagina)) {

    // $output['page'] = $pagina;

    //Calcular o inicio visualização
    $qnt_result_pg = 15; //Quantidade de registro por página
    // $qnt_result_pg = $numb_pag + 1; //Quantidade de registro por página
    $inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;

    $iduser = $_SESSION['usuario']['id'];

    if ($_SESSION['usuario']['tipo'] != 2) {

        $query_usuarios = "SELECT * FROM gtoken as tg
        LEFT JOIN profissionais as pf on tg.id_prof = pf.id_prof
        LEFT JOIN usuarios_a as uss on tg.id_user = uss.id_user
        WHERE pf.id_prof = :e ORDER BY tg.datacad DESC, tg.paciente ASC LIMIT $inicio, $qnt_result_pg";

        $result_usuarios = $conn->prepare($query_usuarios);
        $result_usuarios->bindValue(":e", $iduser, PDO::PARAM_STR);
    } else {

        $query_usuarios = "SELECT * FROM gtoken as tg
        LEFT JOIN profissionais as pf on tg.id_prof = pf.id_prof
        LEFT JOIN usuarios_a as uss on tg.id_prof = uss.id_user

        ORDER BY tg.datacad DESC, tg.paciente ASC LIMIT $inicio, $qnt_result_pg";

        // $result_usuarios->bindValue(":tp", $tipolist, PDO::PARAM_STR);

        $result_usuarios = $conn->prepare($query_usuarios);
    }

    // $query_usuarios = "SELECT id, nome, email FROM usuarios ORDER BY id DESC LIMIT $inicio, $qnt_result_pg";
    $result_usuarios->execute();
    // $result_u = $result_usuarios->fetch(PDO::FETCH_ASSOC);

    $dados = "<div class='table-responsive'>
    <table class='table table-bordered table-striped' style='margin-top:20px;'>
    <thead>
        <th class='text-center'>Nº</th>
        <th class='text-center'>Nome paciente</th>
        <th class='text-center'>Token</th>
        <th class='text-center'>Profissional</th>
        <th class='text-center'>Data</th>
        <th class='text-center'>Status</th>
        <th class='text-center'>Pagamento</th>
        <th class='text-center'>Acão</th>
    </thead>
    <tbody";

    $numero = $inicio;

    while ($row = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $numero++;

        $viewToken = '<button class="btn btn-info btn-sm vtoken" data-toggle="modal" data-target="#viewModal" data-id="' . $token . '"><span class="glyphicon glyphicon-trash"></span> Token</button>';

        $edit = ($_SESSION['usuario']['tipo'] != 2) ? '' : '<button class="btn btn-warning btn-sm etoken" data-toggle="modal" data-target="#editt" data-id="' . $token . '"><span class="glyphicon glyphicon-trash"></span> Editar</button>';

        $delette = ($_SESSION['usuario']['tipo'] != 2) ? '' : '<button class="btn btn-danger btn-sm deletef" data-id="' . $id_token . '"><span class="glyphicon glyphicon-trash"></span> Excluir</button>';

        $dados .=  "<tr>
            <td class='text-center' max-width='70px'>" . $numero . "</td>
            <td class='text-left' max-width='250px'>" . $paciente . "</td>
            <td class='text-center' max-width='120px'>" . $token . "</td>
            <td class='text-left' max-width='260px'>" . $profissional . "</td>
            <td class='text-center' max-width='120px'>
                " . date_format(date_create($datacad), 'd/m/Y') . "
            </td>
            <td class='text-center' max-width='100px'>
                " . $statuspag . "
            </td>
            <td class='text-center' max-width='140px'>
                " . $tipopag . "
            </td>
            <td class='text-center' width='220px'>
                $viewToken
                $edit
                $delette
            </td>
        </tr>";
    }

    $dados .= "</tbody>
        </table>
    </div>";

    //Paginação - Somar a quantidade de usuários

    if ($_SESSION['usuario']['tipo'] != 2) {

        $query_pg = "SELECT COUNT(id_token) AS num_result FROM gtoken WHERE id_prof = :e";
        $result_pg = $conn->prepare($query_pg);
        $result_pg->bindValue(":e", $iduser, PDO::PARAM_STR);
    } else {
        $query_pg = "SELECT COUNT(id_token) AS num_result FROM gtoken";
        $result_pg = $conn->prepare($query_pg);
    }

    $result_pg->execute();
    $row_pg = $result_pg->fetch(PDO::FETCH_ASSOC);

    //Quantidade de pagina
    $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

    $max_links = 3;
    $dados .= '<nav aria-label="Page navigation example"><ul class="pagination pagination-sm justify-content-center">';
    $dados .= "<li class='page-item'><a href='#' class='page-link' onclick='listarUsuarios(1)'>Primeira</a></li>";

    for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
        if ($pag_ant >= 1) {
            $dados .= "<li class='page-item'><a class='page-link' href='#' onclick='listarUsuarios($pag_ant)' >$pag_ant</a></li>";
        }
    }

    $dados .= "<li class='page-item active'><a class='page-link' href='#'>$pagina</a></li>";
    for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
        if ($pag_dep <= $quantidade_pg) {
            $dados .= "<li class='page-item'><a class='page-link' href='#' onclick='listarUsuarios($pag_dep)'>$pag_dep</a></li>";
        }
    }

    $dados .= "<li class='page-item'><a class='page-link' href='#' onclick='listarUsuarios($quantidade_pg)'>Última</a></li>";
    $dados .=   '</ul></nav>';

    echo $dados;
} else {
    echo "<div class='alert alert-danger' role='alert'>Erro: Nenhum usuário encontrado!</div>";
}

//close connection
$pdo->closeConection();
// echo json_encode($output);
// $obj = $output['page'];
// echo $obj;
