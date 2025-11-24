/**
 * Arquivo para manter funções legadas que ainda são necessárias para o sistema,
 * como popular dropdowns e exibir modais de detalhes.
 */

// --- DADOS PARA OS DROPDOWNS ---

var tipopagamento = [
    { valor: 'todos', texto: 'Todos' },
    { valor: 'Crédito', texto: 'Crédito' },
    { valor: 'Débito', texto: 'Débito' },
    { valor: 'Espécie', texto: 'Espécie' },
    { valor: 'Pix', texto: 'Pix' },
    { valor: 'Pix / Qrcode', texto: 'Pix / Qrcode' }
];

var modalidadePes = [
    { valor: 'todos', texto: 'Todos' },
    { valor: 'Avaliação T', texto: 'Avaliação Terapia (Psicologia / Terapia Casal / TO)' },
    { valor: 'Avaliação F', texto: 'Avaliação Fono' },
    { valor: 'Avaliação N', texto: 'Avaliação Neuropsicológica' },
    { valor: 'Visita E', texto: 'Visita Escolar' },
    { valor: 'Proase', texto: 'Proase' },
    { valor: 'Proase Av', texto: 'Sessão Avulsa Proase' },
    { valor: 'Pacote', texto: 'Pacote' },
    { valor: 'Pacote Av', texto: 'Sessão Avulsa Pacote' },
    { valor: 'Plano Mensal', texto: 'Plano Mensal' },
    { valor: 'Consulta Psiquiatra', texto: 'Consulta Psiquiatria' },
    { valor: 'Consulta Nutrição', texto: 'Consulta Nutrição' }
];


// --- FUNÇÕES PARA POPULAR DROPDOWNS ---

/**
 * Popula o select de Profissionais via AJAX.
 * @param {string} id - O ID do elemento <select>.
 * @param {string} descricao - Texto da opção padrão (ex: "Todos").
 * @param {string} tipo - 'adm' para buscar todos, 'prof' para usuário específico.
 */
function fetchProf(id, descricao, tipo) {
    let idd = id;
    let selectElement = $('#' + idd);

    if (tipo === 'adm') {
        $.ajax({
            method: 'POST',
            url: './sqls/list_prof.php',
            dataType: 'json',
            success: function (response) {
                selectElement.empty();
                // A opção 'todos' não é necessária pois o placeholder do selectpicker já serve
                // selectElement.append("<option value='todos'>" + descricao + "</option>");

                if (response && response.listaprof) {
                    response.listaprof.forEach(prof => {
                        selectElement.append(`<option value="${prof.id_prof}">${prof.profissional}</option>`);
                    });
                }
                // ATUALIZA O SELECTPICKER APÓS ADICIONAR AS OPÇÕES
                selectElement.selectpicker('refresh');
            },
            error: function () {
                console.error("Erro ao buscar a lista de profissionais.");
                selectElement.selectpicker('refresh');
            }
        });
    }
    // O caso 'prof' é tratado diretamente no PHP, então não precisa de AJAX aqui.
}

/**
 * Popula o select de Formas de Pagamento.
 * @param {string} tipo - O ID do elemento <select>.
 */
function fetchPagamento(tipo) {
    let selectElement = $('#' + tipo);
    selectElement.empty();
    tipopagamento.forEach(item => {
        // A opção 'todos' é tratada pelo título do selectpicker
        if (item.valor !== 'todos') {
            selectElement.append(`<option value="${item.valor}">${item.texto}</option>`);
        }
    });
}

/**
 * Popula o select de Modalidades.
 * @param {string} mod - O ID do elemento <select>.
 */
function fetchModaPesqui(mod) {
    let selectElement = $('#' + mod);
    selectElement.empty();
    modalidadePes.forEach(item => {
        // A opção 'todos' é tratada pelo título do selectpicker
        if (item.valor !== 'todos') {
            selectElement.append(`<option value="${item.valor}">${item.texto}</option>`);
        }
    });
}


// --- FUNÇÕES DE APOIO PARA MODAL DE VISUALIZAÇÃO ---

// Formata data e hora
function data_hora(d) {
    var dia = (d.getDate() < 10 ? '0' + d.getDate() : d.getDate());
    var mes = ((d.getMonth() + 1) < 10 ? '0' + (d.getMonth() + 1) : (d.getMonth() + 1));
    var ano = d.getFullYear();
    var h = (d.getHours() < 10 ? '0' + d.getHours() : d.getHours());
    var m = (d.getMinutes() < 10 ? '0' + d.getMinutes() : d.getMinutes());
    var hora_atual = h + ':' + m + 'h';
    // return (dia + "/" + mes + "/" + ano + " - " + hora_atual);
    return (dia + "/" + mes + "/" + ano);
}

// Busca os dados de um token específico para exibir no modal
function getEditlsT(id, tip) {
    $.ajax({
        method: 'POST',
        url: 'sqls/my_tok.php',
        data: { chave: id, tipo: tip },
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                alert(response.message); // Usar um modal melhor no futuro
            } else {
                const data = response.data;
                $('.id').val(data.id_token);
                $('.solicitado').text(data_hora(new Date(data.datacad)));
                $('.solicitante').text(data.nome);
                $('.nomep').text(data.profissional);
                $('.paciente').text(data.paciente);

                if (data.nomeresp) {
                    $('.resplabel').text('Responsável: ');
                    $('.respname').text(data.nomeresp);
                } else {
                    $('.resplabel').text('');
                    $('.respname').text('');
                }

                $('.cpf').text(data.cpf);
                $('.referencia').text(data.mes_ref + '/' + data.ano_ref);
                $('.agendamento').text(data.datapag); // Assumindo que é uma string
                $('.pagamento').text(currencyFormatter.format(data.valorpag));

                if (data.obs) {
                    $('.obss').text('Observação: ');
                    $('.obsvalor').text(data.obs);
                } else {
                    $('.obss').text('');
                    $('.obsvalor').text('');
                }

                $('.modalidade').text(data.modalidadepag);
                $('.tipopag').text(data.tipopag);
                $('.tokeng').text(data.token);
                $('.idtoken').val(data.token);
            }
        }
    });
}

// Abre o modal de visualização
function list_tokenPesquisa(chave) {
    // $("#viewForm")[0].reset(); // Pode causar problemas com o modal
    getEditlsT(chave, 'view');
    $('#viewModal').modal('show');
}
