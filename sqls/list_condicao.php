<?php
// Define o cabeçalho para retornar JSON
header('Content-Type: application/json');

require_once '../vendor/autoload.php';
include_once('../conexao.php');
include '../includes/sessao.php';
include '../includes/timezone.php';

/**
 * Adiciona uma condição 'IN' de forma segura a uma query.
 * @param string $field O campo do banco de dados (ex: 'pf.id_prof').
 * @param array $values Os valores a serem incluídos na cláusula IN.
 * @param array &$conditions Referência ao array de condições da query.
 * @param array &$parameters Referência ao array de parâmetros da query.
 */
function addInCondition(string $field, array $values, array &$conditions, array &$parameters): void {
    // Garante que o array não está vazio e que 'todos' não foi selecionado
    if (!empty($values) && (!isset($values[0]) || $values[0] !== 'todos')) {
        // Cria os placeholders (?) para a query
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $conditions[] = "$field IN ($placeholders)";
        // Mescla os valores no array de parâmetros principal
        $parameters = array_merge($parameters, $values);
    }
}

$conditions = [];
$parameters = [];

// --- Constrói a Query de forma segura ---
if (!empty($_POST['nomepac'])) {
    $conditions[] = 'tg.paciente LIKE ?';
    $parameters[] = '%' . $_POST['nomepac'] . '%';
}

if (!empty($_POST['nomeresp'])) {
    $conditions[] = 'tg.responsavel_f LIKE ?';
    $parameters[] = '%' . $_POST['nomeresp'] . '%';
}
// Usa a função auxiliar para adicionar as cláusulas IN
addInCondition('pf.id_prof', $_POST['idprof'] ?? [], $conditions, $parameters);
addInCondition('tg.tipopag', $_POST['tipopag'] ?? [], $conditions, $parameters);
addInCondition('tg.modalidadepag', $_POST['modalidaderef'] ?? [], $conditions, $parameters);

// Validação de período
if (!empty($_POST['date_start']) && !empty($_POST['date_end'])) {
    // Usar DATE() no campo do banco garante que a comparação ignore a parte de hora/minuto
    $conditions[] = 'DATE(tg.datacad) BETWEEN ? AND ?';
    $date_start = DateTime::createFromFormat('d/m/Y', $_POST['date_start']);
    $date_end = DateTime::createFromFormat('d/m/Y', $_POST['date_end']);
    
    // Procede apenas se as datas forem válidas
    if ($date_start && $date_end) {
        $parameters[] = $date_start->format('Y-m-d');
        $parameters[] = $date_end->format('Y-m-d');
    }
}

// Query SQL base
$sql = "SELECT tg.*, pf.id_prof, pf.porcento, pf.profissional 
        FROM gtoken as tg
        LEFT JOIN profissionais as pf on tg.id_prof = pf.id_prof";

// Adiciona as condições à query se existirem
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY tg.datacad DESC, tg.paciente ASC";

try {
    $conn = $pdo->open();
    $stmt = $conn->prepare($sql);
    $stmt->execute($parameters);
    
    $results = [];
    $soma_valorpag = 0;
    $soma_repasse_prof = 0;
    $soma_repasse_clinica = 0;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['tipopag'] == 'Plano de Saúde') continue;

        // --- Lógica de Negócio para cálculos ---
        $porcento = floatval($row['porcento']);
        $valorpag = floatval($row['valorpag']);
        
        // Sobrescreve a porcentagem com base na modalidade, se necessário
        switch ($row['modalidadepag']) {
            case 'Avaliação F': $porcento = 80; break;
            case 'Avaliação N': $porcento = 75; break;
            case 'Visita E': $porcento = 80; break;
            case 'Proase':
            case 'Proase Av': $porcento = 60; break;
        }

        $repasse_prof = ($porcento * $valorpag / 100);
        $repasse_clinica = $valorpag - $repasse_prof;

        // Acumula os totais
        $soma_valorpag += $valorpag;
        $soma_repasse_prof += $repasse_prof;
        $soma_repasse_clinica += $repasse_clinica;
        
        // Adiciona o resultado processado ao array de saída
        $results[] = [
            'paciente' => $row['paciente'],
            'responsavel_f' => $row['responsavel_f'],
            'token' => $row['token'],
            'referencia' => $row['mes_ref'] . ' ' . $row['ano_ref'],
            'modalidade' => $row['modalidadepag'],
            'tipo_pagamento' => $row['tipopag'],
            'profissional' => $row['profissional'],
            'data_pagamento' => date_format(date_create($row['pag_resp']), 'd/m/Y'),
            'banco_pag' => $row['nome_banco'],
            'data_token' => date_format(date_create($row['datacad']), 'd/m/Y'),
            'valor_pagamento' => $valorpag,
            'repasse_profissional' => $repasse_prof,
            'repasse_clinica' => $repasse_clinica
        ];
    }
    
    $pdo->closeConection();

    // Envia a resposta final em formato JSON
    echo json_encode([
        'success' => true,
        'data' => $results,
        'totals' => [
            'valor_pagamento' => $soma_valorpag,
            'repasse_profissional' => $soma_repasse_prof,
            'repasse_clinica' => $soma_repasse_clinica
        ],
        'showClinica' => ($_SESSION['usuario']['tipo'] > 1) // Informa o frontend se deve mostrar a coluna da clínica
    ]);

} catch (PDOException $e) {
    // Em caso de erro, envia uma resposta de erro em JSON
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false,
        'message' => 'Erro na base de dados: ' . $e->getMessage()
    ]);
}
?>
