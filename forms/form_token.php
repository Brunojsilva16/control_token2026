<form id="frmValidar" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12 align-self-start upp">
            <label class="labelObrigatorio"><strong>NOME DO PACIENTE:<span class="obrig"> *</span> <span class="inputNomepac-info infoAlerta"></span></strong></label>
        </div>
        <div class="col-6 align-self-start">
            <input type="text" id="inputNomepac" class="form-control input-required" maxlength="80" name="nomepaciente" placeholder="Nome do paciente">
        </div>

        <div class="col-12 align-self-start">
            <label class="upp" for="cpf"><strong>CPF<span class="obrig"> *</span><span class="inputCpf-info infoAlerta"></span></strong></label>
        </div>
        <div class="col-6 align-self-start">
            <input type="text" id="inputCpf" name="cpf" placeholder="CPF" class="form-control seucpf input-required" maxlength="20">
        </div>

        <div class="col-12 align-self-start upp">
            <label id="nResponsavel"><strong>NOME DO RESPONSÁVEL:</strong></label>
        </div>
        <div class="col-6 align-self-start doww">
            <input type="text" class="form-control" maxlength="80" name="nomeresp" placeholder="Nome responsável" aria-label="nResponsavel">
        </div>
        <div class="col-12 align-self-start upp">
            <label id="fResponsavel"><strong>RESPONSÁVEL FINANCEIRO:</strong></label>
        </div>
        <div class="col-6 align-self-start doww">
            <input type="text" class="form-control" maxlength="80" name="fresponsavel" placeholder="Responsável financeiro" aria-label="fResponsavel">
        </div>
        <div class="row col-md-12 align-self-start">

            <div class="form-group col-md-2 upp doww">
                <label><strong>Data Pagamento:</strong></label>
                <input class="form-control seudata" type="text" name="pag_resp" id="pag_resp">
            </div>

            <div class="form-group col-md-1 upp doww" style="padding-top: 30px;"> <button type="button" class="btn btn-info btn-sm" id="btnDataAtual">Hoje</button>
            </div>

            <div class="form-group col-md-3 upp doww">
                <label for="listf"><strong>Banco:</strong></label>
                <span class="listforma-info infoAlerta"></span>
                <select name="listbanco" id="listbanco" class="form-control input-required selectpicker" data-style="btn-success" data-live-search="true">
                    <option value="Itau">Banco Itau</option>
                    <option value="Bradesco">Banco Bradesco</option>
                </select>

            </div>

        </div>
        <div class="col-12 align-self-start upp doww">
            <strong>Profissional<span class="profSelect-info infoAlerta"></span> </strong>
        </div>
        <div class="col-11 align-self-start">

            <select id="profSelect" name="profSelect" class="form-control col-6 input-required picker" data-style="btn-success" data-live-search="true">
            </select>

        </div>

        <div class="module doww">
            <div class="collapse" id="collapseE00" aria-expanded="false">
                <label class="lbdt"><strong>Data das sessões</strong></label>
                <span class="inputData-info infoAlerta"></span>
                <div class="row align-self-start">
                    <?php
                    // Total de sessões
                    $total = 10;

                    for ($i = 1; $i <= $total; $i++) {
                        echo '<div class="col-2 upp">';
                        echo '<label class="lbdt" for="data' . $i . '">Sessão ' . $i . ':</label>';
                        echo '<input type="text" id="data' . $i . '" class="form-control dt seudiames' . ($i == 1 ? ' input-required' : '') . '" name="datac[]">';
                        echo '</div>';

                        // Após a 3ª e 6ª sessão, adiciona espaçamento col-6
                        if ($i == 3 || $i == 6) {
                            echo '<div class="col-6 upp"></div>';
                        }

                        // Após a 8ª e 10ª sessão, adiciona espaçamento col-8
                        if ($i == 8 || $i == 10) {
                            echo '<div class="col-8 upp"></div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <button type="button" class="btn btn-light cllbt collapsed"
                data-toggle="collapse" data-target="#collapseE00">
                Datas das Sessões
            </button>
        </div>

        <div class="row col-md-12 align-self-start upp doww">

            <div class="form-group col-md-6 upp doww">
                <label for="modalid" id="modalidadeRadio-info"><strong>Modalidade de atendimento:</strong></label><span class="modalidadeRadio-info infoAlerta"></span>
                <select id="modalidadeRadio" name="modalidadeRadio" class="form-control selectpicker" data-style="btn-success" data-live-search="true" aria-label="modalid">
                </select>
            </div>



        </div>

        <div class="row col-md-12 align-self-start">

            <div class="form-group col-md-4 upp doww">
                <label for="listf"><strong>Forma de pagamento:</strong></label><span class="listforma-info infoAlerta"></span>
                <select id="listforma" name="listforma" class="form-control input-required selectpicker" data-style="btn-success" data-live-search="true" aria-label="listf">
                </select>

            </div>
            <div class="form-group col-md-2 upp doww">
                <label id="nResponsavel"><strong>valor:</strong></label>
                <input id="negociavel" class="form-control" type="text" name="v_negociavel" value="" onInput="mascaraMoeda(event);">
                </span>
            </div>

        </div>

        <div class="col-10 align-self-start upp doww">
            <div class="row align-self-start">

                <div class="col-8 upp">
                    <label class="form-check-label" for="avulso">
                        <strong>Observação </strong>
                    </label>
                    <input type="text" class="form-control" name="obs" value="" id="obs">
                </div>
                <div class="col-4">
                </div>
            </div>

            <input type="hidden" name="userSelect" value="<?= isset($_SESSION['usuario']) ? $_SESSION['usuario']['id'] : 'Usuário não logado'; ?>">

        </div>

        <div style="margin-bottom: 20px;" class="col-12 align-self-start upp doww">
            <div class="row align-self-start">

                <div class="col-8 upp">
                    <button type="submit" id="sbmGerar" class="btn btn-info upp doww frmValidar">Gerar Token</button>
                </div>
            </div>
        </div>

</form>