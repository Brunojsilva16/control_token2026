<?php
session_start();
// Garanta que os caminhos para autoload e conexao estejam corretos
require_once '../vendor/autoload.php';
require_once '../conexao.php';
include '../includes/sessao.php';
include '../includes/timezone.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// --- NOVO: Inclusão de classes de Estilo ---
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


/**
 * Adiciona uma condição 'IN' de forma segura a uma query.
 * Esta função é a chave para a correção, copiada de list_condicao.php.
 * @param string $field O campo do banco de dados (ex: 'pf.id_prof').
 * @param array $values Os valores a serem incluídos na cláusula IN.
 * @param array &$conditions Referência ao array de condições da query.
 * @param array &$parameters Referência ao array de parâmetros da query.
 */
function addInCondition(string $field, array $values, array &$conditions, array &$parameters): void
{
    if (!empty($values) && (!isset($values[0]) || $values[0] !== 'todos')) {
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $conditions[] = "$field IN ($placeholders)";
        $parameters = array_merge($parameters, $values);
    }
}


// --- Início da Lógica Principal ---
$data = [];
$totals = [
    'valor_pagamento' => 0,
    'repasse_profissional' => 0,
    'repasse_clinica' => 0
];
$showClinica = ($_SESSION['usuario']['tipo'] ?? 0) > 1;
$filename = "relatorio_completo_formatado.xlsx";

// --- Constrói a Query de forma segura usando os parâmetros GET ---
$conditions = [];
$parameters = [];

if (!empty($_GET['nomepac'])) {
    $conditions[] = 'tg.paciente LIKE ?';
    $parameters[] = '%' . $_GET['nomepac'] . '%';
}

if (!empty($_GET['nomeresp'])) {
    $conditions[] = 'tg.responsavel_f LIKE ?';
    $parameters[] = '%' . $_GET['nomeresp'] . '%';
}

// Usa a função auxiliar para adicionar as cláusulas IN a partir do GET
addInCondition('pf.id_prof', $_GET['idprof'] ?? [], $conditions, $parameters);
addInCondition('tg.tipopag', $_GET['tipopag'] ?? [], $conditions, $parameters);
addInCondition('tg.modalidadepag', $_GET['modalidaderef'] ?? [], $conditions, $parameters);

// Validação de período
if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
    // ** CORREÇÃO: Filtrar por tg.datacad como no outro script, ou tg.pag_resp?
    // Mantendo tg.pag_resp conforme o original, mas garanta que esta é a data desejada.
    // Se quiser filtrar pela data do token, mude para DATE(tg.datacad)
    $conditions[] = 'DATE(tg.datacad) BETWEEN ? AND ?';
    $date_start = DateTime::createFromFormat('d/m/Y', $_GET['date_start']);
    $date_end = DateTime::createFromFormat('d/m/Y', $_GET['date_end']);
    if ($date_start && $date_end) {
        $parameters[] = $date_start->format('Y-m-d');
        $parameters[] = $date_end->format('Y-m-d');
    }
}

// Query SQL base (a mesma de list_condicao.php)
$sql = "SELECT tg.*, pf.id_prof, pf.porcento, pf.profissional 
        FROM gtoken as tg
        LEFT JOIN profissionais as pf on tg.id_prof = pf.id_prof";

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY tg.datacad DESC, tg.paciente ASC";

try {
    $conn = $pdo->open();
    $stmt = $conn->prepare($sql);
    $stmt->execute($parameters);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['tipopag'] == 'Plano de Saúde') continue;
        // --- Lógica de Negócio para cálculos (idêntica a list_condicao.php) ---
        $porcento = floatval($row['porcento']);
        $valorpag = floatval($row['valorpag']);

        switch ($row['modalidadepag']) {
            case 'Avaliação F':
                $porcento = 80;
                break;
            case 'Avaliação N':
                $porcento = 75;
                break;
            case 'Visita E':
                $porcento = 80;
                break;
            case 'Proase':
            case 'Proase Av':
                $porcento = 60;
                break;
        }

        $repasse_prof = ($porcento * $valorpag / 100);
        $repasse_clinica = $valorpag - $repasse_prof;

        // Verificação de datas (similar ao outro script)
        $data_pagamento_formatada = '';
        if (!empty($row['pag_resp'])) {
            try {
                $data_pagamento_formatada = date_format(date_create($row['pag_resp']), 'd/m/Y');
            } catch (Exception $e) {}
        }
        
        $data_token_formatada = '';
        if (!empty($row['datacad'])) {
            try {
                $data_token_formatada = date_format(date_create($row['datacad']), 'd/m/Y');
            } catch (Exception $e) {}
        }

        $data[] = [
            'paciente'             => $row['paciente'],
            'responsavel_f'        => $row['responsavel_f'] ?? '', // Adicionado para evitar erro se não existir
            'data_pagamento'       => $data_pagamento_formatada,
            'banco_pagamento'      => $row['nome_banco'],
            'data_token'           => $data_token_formatada,
            'modalidade'           => $row['modalidadepag'],
            'tipo_pagamento'       => $row['tipopag'],
            'profissional'         => $row['profissional'],
            'valor_pagamento'      => $valorpag,
            'repasse_profissional' => $repasse_prof,
            'repasse_clinica'      => $repasse_clinica,
        ];

        // Acumula os totais
        $totals['valor_pagamento']      += $valorpag;
        $totals['repasse_profissional'] += $repasse_prof;
        $totals['repasse_clinica']      += $repasse_clinica;
    }
    $pdo->closeConection();
} catch (PDOException $e) {
    // Em caso de erro, você pode querer logar ou exibir uma mensagem
    die("Erro ao gerar o relatório: " . $e->getMessage());
}

// --- Gera planilha (O restante do seu código está ótimo) ---
if (empty($data)) {
    echo "Nenhum dado encontrado para os filtros informados.";
    exit;
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet()->setTitle("Relatório");

// Cabeçalhos
$headers = [
    "Nº",
    "Nome Paciente",
    "Responsável Financeiro",
    "Data Pagamento",
    "Banco",
    "Data Token",
    "Modalidade",
    "Tipo Pagamento",
    "Profissional",
    "Valor Pagamento",
    "Repasse Profissional"
];
if ($showClinica) {
    $headers[] = "Repasse Clínica";
}

$col = "A";
foreach ($headers as $h) {
    $sheet->setCellValue($col . "1", $h);
    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
    // A formatação de negrito será feita na seção de estilo abaixo
    $col++;
}

// Dados
$rowCount = 2;
foreach ($data as $index => $row) {
    // ** CORREÇÃO: Usar os dados do array $data[] formatado, não $row[...] brutos **
    $sheet->setCellValue("A" . $rowCount, $index + 1);
    $sheet->setCellValue("B" . $rowCount, $row["paciente"] ?? "");
    $sheet->setCellValue("C" . $rowCount, $row["responsavel_f"] ?? "");
    $sheet->setCellValue("D" . $rowCount, $row["data_pagamento"] ?? ""); // Corrigido
    $sheet->setCellValue("E" . $rowCount, $row["banco_pagamento"] ?? ""); // Corrigido
    $sheet->setCellValue("F" . $rowCount, $row["data_token"] ?? ""); // Corrigido
    $sheet->setCellValue("G" . $rowCount, $row["modalidade"] ?? "");
    $sheet->setCellValue("H" . $rowCount, $row["tipo_pagamento"] ?? "");
    $sheet->setCellValue("I" . $rowCount, $row["profissional"] ?? "");
    $sheet->setCellValue("J" . $rowCount, $row["valor_pagamento"] ?? 0);
    $sheet->setCellValue("K" . $rowCount, $row["repasse_profissional"] ?? 0);

    if ($showClinica) {
        $sheet->setCellValue("L" . $rowCount, $row["repasse_clinica"] ?? 0);
    }
    $rowCount++;
}

// Totais
$sheet->setCellValue("I" . $rowCount, "TOTAIS:"); // "TOTAIS:" está na coluna H
$sheet->setCellValue("J" . $rowCount, $totals["valor_pagamento"] ?? 0);
$sheet->setCellValue("K" . $rowCount, $totals["repasse_profissional"] ?? 0);
if ($showClinica) {
    $sheet->setCellValue("L" . $rowCount, $totals["repasse_clinica"] ?? 0);
}
$lastColLetter = $showClinica ? "L" : "K";
$sheet->getStyle("I" . $rowCount . ":" . $lastColLetter . $rowCount)->getFont()->setBold(true);

// Formatação moeda
$formatCode = '"R$ "#,##0.00';
$sheet->getStyle("J2:J" . $rowCount)->getNumberFormat()->setFormatCode($formatCode);
$sheet->getStyle("K2:K" . $rowCount)->getNumberFormat()->setFormatCode($formatCode);
if ($showClinica) {
    $sheet->getStyle("L2:L" . $rowCount)->getNumberFormat()->setFormatCode($formatCode);
}


// --- NOVO: Seção de Estilização ---

// Estilo do Cabeçalho (Fundo vermelho, fonte branca, negrito e centralizado)
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['argb' => 'FFFFFFFF'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'C00000'],
    ],
];
// Aplica o estilo ao intervalo do cabeçalho, que vai de A1 até a última coluna usada
$sheet->getStyle('A1:' . $lastColLetter . '1')->applyFromArray($headerStyle);


// Estilo de Bordas para toda a tabela
$lastRow = $rowCount;
$borderStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '00000000'],
        ],
    ],
];
// Aplica a borda ao intervalo completo da tabela
$sheet->getStyle('A1:' . $lastColLetter . $lastRow)->applyFromArray($borderStyle);

// Alinhamento da célula "TOTAIS" para a direita
// ** CORREÇÃO: A célula "TOTAIS:" está na coluna H, não G **
$sheet->getStyle('I' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

// --- Fim da Seção de Estilização ---


// Limpa buffer
if (ob_get_length()) ob_end_clean();

// Download
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");

$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
