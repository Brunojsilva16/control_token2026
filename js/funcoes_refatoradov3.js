// Configuração global para formatar valores como moeda brasileira (R$)
const currencyFormatter = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL'
});

// --- Executa quando o documento está pronto ---
$(document).ready(function () {

    // Inicializa os seletores customizados do Bootstrap
    $('.selectpicker').selectpicker();

    // Inicializa as máscaras de data
    $('.seudata').mask('00/00/0000');

    // Manipulador de clique para o botão de pesquisa principal
    $("#pfilter").on("click", function (event) {
        event.preventDefault();
        performSearch();
    });

    // Manipulador de clique para o botão de limpar
    $("#refresh").on("click", function () {
        $('#pform')[0].reset();
        // Atualiza os seletores para mostrar o texto do placeholder
        $('.selectpicker').selectpicker('refresh');
        // Limpa a tabela de resultados
        $("#listarpesquisa").html("");
    });

    // Usa "event delegation" para o botão de visualizar token, pois ele é criado dinamicamente
    $('#listarpesquisa').on('click', '.vtoken', function () {
        const token = $(this).data('id');
        if (token && typeof list_tokenPesquisa === 'function') {
            list_tokenPesquisa(token); // Chama a função do arquivo funcoes_antigas.js
        }
    });

    // Carrega os filtros iniciais da página
    initializeFilters();
});


// --- Funções Principais ---

/**
 * Executa a busca via AJAX e renderiza os resultados.
 */
function performSearch() {
    const searchForm = $("#pform");
    const resultsContainer = $("#listarpesquisa");
    const pfilterButton = $("#pfilter");

    // Exibe o estado de "carregando"
    resultsContainer.html(`
        <div class="d-flex justify-content-center align-items-center mt-5">
            <div class="spinner-border text-success" role="status">
                <span class="sr-only">Carregando...</span>
            </div>
            <strong class="ml-3">Buscando dados...</strong>
        </div>
    `);
    pfilterButton.prop('disabled', true).find('i').removeClass('fa-search').addClass('fa-spinner fa-spin');

    $.ajax({
        url: 'sqls/list_condicao.php',
        type: 'POST',
        dataType: 'json',
        data: searchForm.serialize()
    })
        .done(function (response) {
            if (response.success) {
                renderResultsTable(response);
            } else {
                showError(response.message || 'Ocorreu um erro desconhecido no servidor.');
            }
        })
        .fail(function (xhr, status, error) {
            console.error("Erro no AJAX:", status, error, xhr.responseText);
            showError('Falha na comunicação com o servidor. Verifique o console para mais detalhes.');
        })
        .always(function () {
            // Restaura o estado normal do botão
            pfilterButton.prop('disabled', false).find('i').removeClass('fa-spinner fa-spin').addClass('fa-search');
        });
}

/**
 * Cria a tabela de resultados a partir da resposta JSON do servidor.
 * @param {object} response - O objeto JSON vindo do servidor.
 */
function renderResultsTable(response) {
    const { data, totals, showClinica } = response;
    const resultsContainer = $("#listarpesquisa");

    if (!data || data.length === 0) {
        resultsContainer.html('<div class="alert alert-info text-center mt-4"><strong>Nenhum resultado encontrado para os filtros informados.</strong></div>');
        return;
    }

    // Cria cabeçalhos e totais condicionais (só mostra para admin)
    const headerClinica = showClinica ? '<th class="text-center">Repasse Clínica</th>' : '';
    const totalClinica = showClinica ? `<td class="text-right"><strong>${currencyFormatter.format(totals.repasse_clinica)}</strong></td>` : '';

    let tableHTML = `
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nome Paciente</th>
                        <th>Responsável Financeiro</th>
                        <th>Token</th>
                        <th class="text-center">Modalidade</th>
                        <th class="text-center">Tipo Pag.</th>
                        <th>Profissional</th>
                        <th class="text-center">Data Token.</th>
                        <th class="text-right">Valor Pag.</th>
                        <th class="text-right">Repasse Prof.</th>
                        ${headerClinica}
                    </tr>
                </thead>
                <tbody>
    `;

    data.forEach((row, index) => {
        const rowClinica = showClinica ? `<td class="text-right">${currencyFormatter.format(row.repasse_clinica)}</td>` : '';
        tableHTML += `
            <tr>
                <td class="text-center">${index + 1}</td>
                <td>${escapeHtml(row.paciente)}</td>
                <td>${escapeHtml(row.responsavel_f)}</td>
                <td class="text-nowrap">
                    ${escapeHtml(row.token)}
                    <button class="btn btn-info btn-sm vtoken ml-1" data-id="${escapeHtml(row.token)}" title="Visualizar Token">
                        <i class="fa fa-eye"></i>
                    </button>
                </td>
                <td class="text-center">${escapeHtml(row.modalidade)}</td>
                <td class="text-center">${escapeHtml(row.tipo_pagamento)}</td>
                <td>${escapeHtml(row.profissional)}</td>
                <td class="text-center">${row.data_pagamento}</td>
                <td class="text-right">${currencyFormatter.format(row.valor_pagamento)}</td>
                <td class="text-right">${currencyFormatter.format(row.repasse_profissional)}</td>
                ${rowClinica}
            </tr>
        `;
    });

    tableHTML += `
                </tbody>
                <tfoot class="bg-light font-weight-bold">
                    <tr>
                        <td colspan="8" class="text-right"><strong>TOTAIS:</strong></td>
                        <td class="text-right"><strong>${currencyFormatter.format(totals.valor_pagamento)}</strong></td>
                        <td class="text-right"><strong>${currencyFormatter.format(totals.repasse_profissional)}</strong></td>
                        ${totalClinica}
                    </tr>
                </tfoot>
            </table>
        </div>
    `;

    resultsContainer.html(tableHTML);
}

/**
 * Popula os filtros dropdown na carga da página e atualiza seus componentes visuais.
 */
function initializeFilters() {
    // Popula os dropdowns que usam arrays locais
    if (typeof fetchPagamento === 'function') {
        fetchPagamento('listforma');
        $('#listforma').selectpicker('refresh'); // ATUALIZA o selectpicker
    }
    if (typeof fetchModaPesqui === 'function') {
        fetchModaPesqui('modalidaderef');
        $('#modalidaderef').selectpicker('refresh'); // ATUALIZA o selectpicker
    }

    // Lógica para carregar os profissionais (função assíncrona)
    if (typeof fetchProf === 'function') {
        if (userType > 1) { // A variável userType vem do PHP em pesquisa.php
            // A própria função fetchProf já chama o 'refresh' em seu callback de sucesso.
            fetchProf('nomeprof', 'Todos os profissionais', 'adm');
        }
    }
}


// --- Funções Utilitárias ---

/**
 * Exibe uma mensagem de erro no container de resultados.
 * @param {string} message - A mensagem de erro a ser exibida.
 */
function showError(message) {
    $("#listarpesquisa").html(`<div class="alert alert-danger mt-4"><strong>Erro:</strong> ${escapeHtml(message)}</div>`);
}

/**
 * Escapa HTML para prevenir ataques de Cross-Site Scripting (XSS).
 * @param {string} unsafe - A string a ser escapada.
 * @returns {string} A string segura.
 */
function escapeHtml(unsafe) {
    if (typeof unsafe !== 'string') return '';
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


// $("#btnExportar").on("click", function () {
//     // Serializa o formulário com os filtros
//     const params = $("#pform").serialize();
//     // Abre o list_excel.php com os filtros aplicados
//     window.open("list_excel.php?" + params, "_blank");
// });


// $("#btnDownloadExcel").on("click", function () {
//     const params = $("#pform").serialize();
//     window.open("list_excel_download.php?" + params, "_blank");
// });



