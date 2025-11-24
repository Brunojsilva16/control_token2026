/**
 * export_excel.js - Versão Corrigida com Pré-visualização
 *
 * Este script gerencia a exportação de dados em duas etapas:
 * 1. Ao clicar em "Exportar", busca os dados via AJAX e renderiza uma tabela de pré-visualização.
 * 2. Um botão "Baixar Excel" é exibido abaixo da tabela, permitindo o download direto do arquivo.
 *
 * Correções aplicadas:
 * - Removidos os manipuladores de evento duplicados e conflitantes.
 * - O botão "Baixar Excel" agora apenas dispara o download, sem fazer uma nova chamada AJAX.
 * - Centralizada a lógica de carregamento nos botões.
 */

// --- Manipuladores de Clique para os Botões Principais ---
// CÓDIGO NOVO E CORRIGIDO

$(document).ready(function () {

    // Botão Exportar Completo
    $("#btnExportar").on("click", function (event) {
        event.preventDefault();
        performSearchAndPreview({
            buttonElement: $(this),
            ajaxUrl: "sqls/list_condicao.php",
            renderFunction: renderResultsTableExcel,
            containerId: "#listarpesquisa",
            downloadScript: "sqls/list_excel_download.php", // <-- CORRIGIDO
            downloadButtonId: "btnDownloadExcel"
        });
    });

    // Botão Exportar Reduzido
    $("#btnExportarReduzido").on("click", function (event) {
        event.preventDefault();
        performSearchAndPreview({
            buttonElement: $(this),
            ajaxUrl: "sqls/list_condicao.php",
            renderFunction: renderResultsTableExcelReduz,
            containerId: "#listarpesquisa",
            downloadScript: "sqls/list_excel_download_reduzido.php", // <-- CORRIGIDO
            downloadButtonId: "btnDownloadExcelReduz"
        });
    });

});


/**
 * Função centralizada para buscar dados via AJAX e exibir uma pré-visualização.
 * @param {object} config - Objeto de configuração.
 */
function performSearchAndPreview(config) {
    const searchForm = $("#pform");
    const resultsContainer = $(config.containerId);

    // Mostra o estado de "carregando" no botão e na área de resultados
    toggleButtonLoading(config.buttonElement, true);
    resultsContainer.html(`
        <div class="d-flex justify-content-center align-items-center mt-5">
            <div class="spinner-border text-success" role="status">
                <span class="sr-only">Carregando...</span>
            </div>
            <strong class="ml-3">Gerando prévia para Excel...</strong>
        </div>
    `);

    $.ajax({
        url: config.ajaxUrl,
        type: "POST",
        dataType: "json",
        data: searchForm.serialize()
    })
        .done(function (response) {
            if (response.success && response.data && response.data.length > 0) {
                // Chama a função de renderização apropriada (passada via config)
                config.renderFunction(response);

                // Adiciona o botão de download abaixo da tabela renderizada
                resultsContainer.append(`
                <div class="mt-3 text-right">
                    <button id="${config.downloadButtonId}" class="btn btn-success">
                        <i class="fa fa-download"></i> Baixar Excel
                    </button>
                </div>
            `);

                // Adiciona o listener para o botão de download recém-criado
                // Este listener apenas abre a URL de download, sem fazer outro AJAX.
                $("#" + config.downloadButtonId).on("click", function () {
                    const params = searchForm.serialize();
                    window.open(config.downloadScript + "?" + params, "_blank");
                });

            } else {
                // Mostra mensagem de erro ou "nenhum resultado"
                showPreviewError(resultsContainer, response.message || "Nenhum dado encontrado para os filtros informados.");
            }
        })
        .fail(function (xhr, status, error) {
            console.error("Erro no AJAX (Excel):", status, error, xhr.responseText);
            showPreviewError(resultsContainer, "Falha na comunicação com o servidor.");
        })
        .always(function () {
            // Restaura o estado normal do botão
            toggleButtonLoading(config.buttonElement, false);
        });
}


/**
 * Renderiza a tabela de pré-visualização para o relatório COMPLETO.
 * @param {object} response - A resposta do AJAX.
 */
function renderResultsTableExcel(response) {
    const { data, totals, showClinica } = response;
    const resultsContainer = $("#listarpesquisa");

    const headerClinica = showClinica ? '<th class="text-right">Repasse Clínica</th>' : '';
    let tableHTML = `
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nome Paciente</th>
                        <th>Responsável Financeiro</th>
                        <th class="text-center">Data Pag.</th>
                        <th class="text-center">Banco</th>
                        <th class="text-center">Data Token.</th>
                        <th class="text-center">Modalidade</th>
                        <th class="text-center">Tipo Pag.</th>
                        <th>Profissional</th>
                        <th class="text-right">Valor Pag.</th>
                        <th class="text-right">Repasse Prof.</th>
                        ${headerClinica}
                    </tr>
                </thead>
                <tbody>`;

    data.forEach((row, index) => {
        const rowClinica = showClinica ? `<td class="text-right">${currencyFormatter.format(row.repasse_clinica)}</td>` : '';
        tableHTML += `
            <tr>
                <td class="text-center">${index + 1}</td>
                <td>${escapeHtml(row.paciente)}</td>
                <td>${escapeHtml(row.responsavel_f)}</td>
                <td class="text-center">${row.data_pagamento}</td>
                <td class="text-center">${row.banco_pag ? escapeHtml(row.banco_pag) : ''}</td>
                <td class="text-center">${row.data_token}</td>
                <td class="text-center">${escapeHtml(row.modalidade)}</td>
                <td class="text-center">${escapeHtml(row.tipo_pagamento)}</td>
                <td>${escapeHtml(row.profissional)}</td>
                <td class="text-right">${currencyFormatter.format(row.valor_pagamento)}</td>
                <td class="text-right">${currencyFormatter.format(row.repasse_profissional)}</td>
                ${rowClinica}
            </tr>`;
    });

    const totalClinica = showClinica ? `<td class="text-right"><strong>${currencyFormatter.format(totals.repasse_clinica)}</strong></td>` : '';
    tableHTML += `
                </tbody>
                <tfoot class="bg-light font-weight-bold">
                    <tr>
                        <td colspan="9" class="text-right"><strong>TOTAIS:</strong></td>
                        <td class="text-right"><strong>${currencyFormatter.format(totals.valor_pagamento)}</strong></td>
                        <td class="text-right"><strong>${currencyFormatter.format(totals.repasse_profissional)}</strong></td>
                        ${totalClinica}
                    </tr>
                </tfoot>
            </table>
        </div>`;
    resultsContainer.html(tableHTML);
}


/**
 * Renderiza a tabela de pré-visualização para o relatório REDUZIDO.
 * @param {object} response - A resposta do AJAX.
 */
function renderResultsTableExcelReduz(response) {
    const { data, totals } = response;
    const resultsContainer = $("#listarpesquisa");

    let tableHTML = `
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nome Paciente</th>
                        <th>Responsável Financeiro</th>
                        <th class="text-center">Data Token</th>
                        <th>Profissional</th>
                        <th class="text-right">Repasse Prof.</th>
                    </tr>
                </thead>
                <tbody>`;

    data.forEach((row, index) => {
        tableHTML += `
            <tr>
                <td class="text-center">${index + 1}</td>
                <td>${escapeHtml(row.paciente)}</td>
                <td>${escapeHtml(row.responsavel_f)}</td>
                <td class="text-center">${row.data_token}</td>
                <td>${escapeHtml(row.profissional)}</td>
                <td class="text-right">${currencyFormatter.format(row.repasse_profissional)}</td>
            </tr>`;
    });

    tableHTML += `
                </tbody>
                <tfoot class="bg-light font-weight-bold">
                    <tr>
                        <td colspan="5" class="text-right"><strong>TOTAIS:</strong></td>
                        <td class="text-right"><strong>${currencyFormatter.format(totals.repasse_profissional)}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>`;
    resultsContainer.html(tableHTML);
}


// --- Funções Utilitárias ---

/**
 * Exibe uma mensagem de erro no contêiner de pré-visualização.
 * @param {jQuery} container - O elemento do contêiner.
 * @param {string} message - A mensagem de erro.
 */
function showPreviewError(container, message) {
    container.html(`<div class="alert alert-warning text-center mt-4"><strong>Aviso:</strong> ${escapeHtml(message)}</div>`);
}

/**
 * Alterna o estado visual de um botão (loading/normal).
 * @param {jQuery} button - O elemento do botão.
 * @param {boolean} isLoading - True para mostrar o estado de carregando, false para o normal.
 */
function toggleButtonLoading(button, isLoading) {
    const icon = button.find("i");
    if (isLoading) {
        button.prop("disabled", true);
        icon.removeClass("fa-file-excel").addClass("fa-spinner fa-spin");
    } else {
        button.prop("disabled", false);
        icon.removeClass("fa-spinner fa-spin").addClass("fa-file-excel");
    }
}

/**
 * Escapa HTML para prevenir ataques XSS. (Função de segurança)
 * @param {string} unsafe - A string a ser escapada.
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

// Supondo que esta variável já exista em outro script (funcoes_refatorado.js)
// Se não existir, descomente a linha abaixo.
// const currencyFormatter = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' });