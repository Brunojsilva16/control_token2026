<!-- Edit -->
<div class="modal fade" id="edittModal" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">Editar Dados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="editForm" name="editForm">
                <div class="modal-body">
                    <div id="elementSolicitadoEdit" style="letter-spacing: 1px;">

                        <div class="bg-success text-white form-group row" style="padding: 10px 0px 10px 0px; margin: 6px 0px 12px 0px;">

                            <label for="solicitanteLabel" class="col-sm-6">SOLICITADO EM:</label>
                            <div class="col-sm-6">
                                <?php

                                if (isset($_SESSION['usuario']['nivel'])) {

                                    if ($_SESSION['usuario']['nivel'] > 2) {
                                        echo "<input type='date' id='nova_data' name='nova_data'>";
                                    } else {
                                        echo "<span class='solicitado' id='solicitado'></span>";
                                    }
                                }

                                ?>
                                <input type="hidden" id="data_atual" name="data_atual">
                            </div>

                            <label for="solicitanteLabel" class="col-sm-6">Solicitante:</label>
                            <div class="col-sm-6">
                                <span class="solicitante" id="solicitanteLabel"></span>
                            </div>

                            <label class="col-sm-6">Token gerado:</label>
                            <div class="col-sm-6">
                                <span class="tokeng"></span>
                            </div>

                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="pacienteeLabel" class="col-sm-4 col-form-label col-form-label-sm">Paciente:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm paciente" id="pacienteeLabel" name="paciente">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cpfLabel" class="col-sm-4 col-form-label col-form-label-sm">CPF:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm cpf" id="cpfLabel" name="cpf">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="responsavelfinLabel" class="col-sm-4 col-form-label col-form-label-sm">Responsável:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm resp" id="responsavelfinLabel" name="resp">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="responsavelLabel" class="col-sm-4 col-form-label col-form-label-sm">Responsável Financeiro:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm respfinanc" id="responsavelLabel" name="respfinanc">
                        </div>
                    </div>

                    <div class="row col-md-12 align-self-start">

                        <div class="col-sm-6 upp">
                            <label for="edit_pag_resp">
                                <strong>Data Pag. Responsável:</strong>
                            </label>
                            <input class="form-control" type="date" name="pag_resp" id="edit_pag_resp">
                        </div>


                        <div class="form-group col-md-6 upp doww">
                            <label for="listbanco"><strong>Banco:</strong></label>
                            <span class="listforma-info infoAlerta"></span>
                            <select name="listbanco" id="listbanco" class="form-control" data-style="btn-light border">
                                <!-- As opções serão populadas pelo JavaScript -->
                            </select>
                        </div>

                    </div>


                    <input type="hidden" class="id" name="id">
                    <div class="form-group row upp">
                        <label for="nomeLabel" class="col-sm-4 col-form-label col-form-label-sm">Profissional:</label>
                        <div class="select-dropdown">
                            <select id="nomeprof" name="idprof" style="width: 300px">
                            </select>
                        </div>
                    </div>

                    <div class="module doww">
                        <div class="collapse" id="collapseE00" aria-expanded="false">

                            <label class="lbdt"><strong>Data das sessões</strong></label>
                            <div class="row align-self-start">
                                <div class="col-4 upp">
                                    <label class="lbdt" for="data1">Sessão 1:</label>
                                    <input type="text" class="form-control dt seudiames" name="datac[]">
                                </div>
                                <div class="col-4 upp">
                                    <label class="lbdt" for="data2">Sessão 2:</label>
                                    <input type="text" class="form-control dt seudiames" name="datac[]">
                                </div>
                                <div class="col-4 upp">
                                    <label class="lbdt" for="data3">Sessão 3:</label>
                                    <input type="text" class="form-control dt seudiames" name="datac[]">
                                </div>

                                <div class="col-4 upp">
                                    <label class="lbdt" for="data4">Sessão 4:</label>
                                    <input type="text" class="form-control dt seudiames" name="datac[]">
                                </div>
                                <div class="col-4 upp">
                                    <label class="lbdt" for="data5">Sessão 5:</label>
                                    <input type="text" class="form-control dt seudiames" name="datac[]">
                                </div>
                                <div class="col-4 upp">
                                    <label class="lbdt" for="data1">Sessão 6:</label>
                                    <input type="text" class="form-control dt seudiames" name="datac[]">
                                </div>

                                <div class="col-4 upp">
                                    <label class="lbdt" for="data1">Sessão 7:</label>
                                    <input type="text" class="form-control dt seudiames" name="datac[]">
                                </div>
                                <div class="col-4 upp">
                                    <label class="lbdt" for="data1">Sessão 8:</label>
                                    <input type="text" class="form-control dt seudiames" name="datac[]">
                                </div>
                                <div class="col-4 upp">
                                </div>

                                <div class="col-4 upp">
                                    <label class="lbdt" for="data1">Sessão 9:</label>
                                    <input type="text" class="form-control dt seudiames" name="datac[]">
                                </div>
                                <div class="col-4 upp">
                                    <label class="lbdt" for="data1">Sessão 10:</label>
                                    <input type="text" class="form-control dt seudiames" name="datac[]">
                                </div>
                                <div class="col-4 upp">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-light cllbt collapsed" data-toggle="collapse" data-target="#collapseE00"></button>
                    </div>

                    <div class="col-12 align-self-start upp doww">
                        <label for="modalidaderef"><strong>Modalidade de atendimento:</strong></label>
                        <select id="modalidaderef" name="modalidaderef" class="form-control">
                        </select>
                    </div>


                    <div class="row col-12 upp">
                        <div class="form-group col-md-6 upp">
                            <label for="tipopag"><strong>Forma de pag:</strong></label>
                            <select id="tipopag" name="tipopag" class="form-control">
                            </select>
                        </div>

                        <div class="col-sm-6 upp">

                            <label for="negociavel"><strong>Valor:</strong></label>
                            <input class="form-control v_negociavel" type="text" name="v_negociavel" id="negociavel" onInput="mascaraMoeda(event);" required>
                        </div>

                    </div>

                    <div class="col-12 upp">
                        <label class="form-check-label" for="avulso">
                            <strong>Observação: </strong>
                        </label>
                        <input type="text" class="form-control obs" name="obs" id="obs">
                    </div>

                    <div class="carregando" style="color:green"></div>
                    <div class="resultadoLoading" style="color: red;"></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                        <button type="submit" id="idtok" class="btn btn-success edittClass"><span class="glyphicon glyphicon-check"></span> Update</button>
                        <input type="hidden" class="form-control form-control-sm idpage" name="idpag">
                        <input type="hidden" class="form-control form-control-sm idtoken" name="idtokk">
                    </div>

            </form>

        </div>
    </div>
</div>