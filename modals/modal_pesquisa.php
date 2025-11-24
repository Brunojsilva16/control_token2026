<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="viewPesquisa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Token</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container text-star">

                    <div id="elementSolicitado" style="letter-spacing: 1px;">SOLICITADO EM: <span class="solicitado"></span>
                        <br>
                        <div class="form-group row">
                            <label for="solicitanteLabel" class="col-sm-4 col-form-label col-form-label-sm">Solicitante:</label>
                            <div class="col-sm-8">
                                <span class="solicitante" id="solicitanteLabel"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pacienteeLabel" class="col-sm-4 col-form-label col-form-label-sm">Paciente:</label>
                        <div class="col-sm-8">
                            <span class="paciente" id="pacienteeLabel"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="respLabel" class="col-sm-4 col-form-label col-form-label-sm">
                            <span class="resplabel"></span></label>
                        <div class="col-sm-8">
                            <span class="respname"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cpfLabel" class="col-sm-4 col-form-label col-form-label-sm">CPF:</label>
                        <div class="col-sm-8">
                            <span class="cpf" id="cpfLabel"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomeLabel" class="col-sm-4 col-form-label col-form-label-sm">Profissional:</label>
                        <div class="col-sm-8">
                            <span class="nomep" id="nomeLabel"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="referenciaLabel" class="col-sm-4 col-form-label col-form-label-sm">Mês de referência:</label>
                        <div class="col-sm-8">
                            <span class="referencia" id="referenciaLabel"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="agendamentoLabel" class="col-sm-4 col-form-label col-form-label-sm">Data(s):</label>
                        <div class="col-sm-8">
                            <span class="agendamento" id="agendamentoLabel"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="statusLabel" class="col-sm-4 col-form-label col-form-label-sm">Status Pagamento:</label>
                        <div class="col-sm-8">
                            <span class="status" id="statusLabel"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="modLabel" class="col-sm-4 col-form-label col-form-label-sm"><span class="modlab"></span></label>
                        <div class="col-sm-8">
                            <span class="modalidade" id="modLabel"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tipopagLabel" class="col-sm-4 col-form-label col-form-label-sm">Tipo pagamento:</label>
                        <div class="col-sm-8">
                            <span class="tipopag" id="tipopagLabel"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pagamentoLabel" class="col-sm-4 col-form-label col-form-label-sm"><span class="pagg"></span></label>
                        <div class="col-sm-8">
                            <span class="pagamento" id="pagamentoLabel"></span>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="obsLabel" class="col-sm-4 col-form-label col-form-label-sm"><span class="obss"></span></label>
                        <div class="col-sm-8">
                            <span class="obsvalor" id="obsLabel"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label col-form-label-sm">Token gerado:</label>
                        <div class="col-sm-8">
                            <span class="tokeng"></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                <!-- <button type="button" class="btn btn-primary">Salvar changes</button> -->
            </div>
        </div>
    </div>
</div>