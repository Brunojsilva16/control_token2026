<!-- Modal View -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="Labeltitulo">Token</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            
            <form id="viewForm">
                <div class="modal-body">
                    <div class="container text-star">

                        <div style="letter-spacing: 1px;">

                            <div class="bg-success text-white form-group row" style="padding: 10px 0px 10px 0px; margin: 6px 0px 12px 0px;">

                                <label for="solicitanteLabel" class="col-sm-6">SOLICITADO EM:</label>
                                <div class="col-sm-6">
                                    <span class="solicitado" id="solicitado"></span>
                                </div>

                                <label for="solicitanteLabel" class="col-sm-6">Solicitante:</label>
                                <div class="col-sm-6">
                                    <span class="solicitante" id="solicitanteLabel"></span>
                                </div>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pacienteeLabel" class="col-sm-4 ">Paciente:</label>
                            <div class="col-sm-8">
                                <span class="paciente" id="pacienteeLabel"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="respLabel" class="col-sm-4 ">
                                <span class="resplabel"></span></label>
                            <div class="col-sm-8">
                                <span class="resp"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="respLabelFinanc" class="col-sm-4 ">
                                <span class="resplabelFinanc"></span></label>
                            <div class="col-sm-8">
                                <span class="respfinanc"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cpfLabel" class="col-sm-4 ">CPF:</label>
                            <div class="col-sm-8">
                                <span class="cpf" id="cpfLabel"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomeLabel" class="col-sm-4 ">Profissional:</label>
                            <div class="col-sm-8">
                                <span class="nomep" id="nomeLabel"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="agendamentoLabel" class="col-sm-4 ">Data(s):</label>
                            <div class="col-sm-8">
                                <span class="agendamento" id="agendamentoLabel"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="modLabel" class="col-sm-4 ">Modalidade: </label>
                            <div class="col-sm-8">
                                <span class="modalidade" id="modLabel"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipopagLabel" class="col-sm-4 ">Tipo pagamento:</label>
                            <div class="col-sm-8">
                                <span class="tipopag" id="tipopagLabel"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pagamentoLabel" class="col-sm-4">Pagamento: </label>
                            <div class="col-sm-8">
                                <span class="pagamento" id="pagamentoLabel"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="obsLabel" class="col-sm-4 "><span class="obss"></span></label>
                            <div class="col-sm-8">
                                <span class="obsvalor" id="obsLabel"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tokenGLabel" class="col-sm-4">Token gerado:</label>
                            <div class="col-sm-8">
                                <span class="tokeng" id="tokenGLabel"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                    <!-- <button type="button" class="btn btn-primary">Salvar changes</button> -->
                </div>

            </form>

        </div>
    </div>
</div>