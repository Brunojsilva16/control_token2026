const simbolo = { style: "currency", currency: "BRL" };
const numberFormat1 = new Intl.NumberFormat("pt-br", simbolo);

// Carregar paginação
function listarUsuarios(pag) {
  //$.get("./sqls/list.php?pagina=" + pag + '&numb=' + numb, function (retorna) {
  $.get("./sqls/list.php?pagina=" + pag, function (retorna) {
    $(".listar-cliente").html(retorna);
    $(".modal-footer .idpage").val(pag);
    // scrollToTop();
  });
}

$(document).ready(function () {
  $(".boxmsg")
    .delay(3000)
    .fadeOut(1000, function () {
      $(this).css({ display: "none" });
    });
});

function resetForm(id) {
  document.getElementById(id).reset();
  document.getElementById("listarpesquisa").innerHTML = "";
}

function activatecad() {
  $("#flexRadio2").prop("checked", true);
  $("#flexRadio2").trigger("click");
  $("#crp").focus();
}

$('input[name="userTipoRadio"]').on("click", function () {
  if ($(this).val() == "1") {
    $('input[name="v_crp"]').val("");
    $("#crp").removeAttr("disabled");
  } else {
    $("#crp").prop("disabled", "disabled");
    $('input[name="v_crp"]').val("");
  }
});

$("#submitBtn").click(function () {
  $("#lname").text($("#lastname").val());
  $("#fname").text($("#firstname").val());
});

$("#submit").click(function () {
  //  alert('submitting');
  $("#formfield").submit();
});

var senhac = document.getElementById("senhac");
var senhav = document.getElementById("senhav");
var code = document.getElementById("code");
var user = document.getElementById("user");
var senhaInfo = document.getElementById("infoAlerta");

function checkedSenha() {
  valid = true;

  if (senhac.value != senhav.value) {
    senhaInfo.innerHTML = "\n* Senhas diferentes!";
    senhaInfo.style.color = "#fff";
    senhav.focus();
    valid = false;
  } else {
    senhav.innerHTML = "";
  }

  return valid;
}

$(".s-valid").on("click", function (e) {
  e.preventDefault();

  if (checkedSenha()) {
    Swal.fire({
      title: "Altera senha?",
      // text: "Click para confirmar sua alteração!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sim",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "sqls/edit_senha.php",
          method: "POST",
          contentType: "application/x-www-form-urlencoded",
          // accepts: { json: "json" },
          dataType: "json",
          data: {
            password: senhac.value,
            code: code.value,
            user: user.value,
          },

          success: function (response) {
            if (response.error) {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: response.message,
                // footer: '<a href="#">Why do I have this issue?</a>'
              });
            } else {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Alteração",
                text: response.message,
                showConfirmButton: false,
                timer: 1500,

                willClose: () => {
                  // clearInterval(timerInterval);
                  window.location.href = "home";
                },
              });
            }
          },
        });
      }
    });
  }
});

function submitForm(form) {
  var valid = true;

  $(".infoAlerta").html("");
  $(".infoAlerta").css("background-color", "");
  $(".input-required").css({ border: "1px solid #ced4da" });

  var inputNomepac = $("#inputNomepac").val();
  var inputCpf = $("#inputCpf").val();
  var pp = document.getElementById("profSelect");
  var profSelect = pp.options[pp.selectedIndex].value;
  var mm = document.getElementById("mesSelect");
  var mesSelect = mm.options[mm.selectedIndex].value;
  var inputData = $("#inputData").val();
  // var modalidadeRadio = $("input:radio[name=modalidadeRadio]:checked").val();
  var negociavel = $("#negociavel").val();
  var lis = document.getElementById("listforma");
  var listforma = lis.options[lis.selectedIndex].value;
  var fpag = document.getElementById("modalidaderef");
  var fpagamento = fpag.options[fpag.selectedIndex].value;

  if (inputNomepac == "null" || inputNomepac == "") {
    $(".inputNomepac-info").html(" (Required)");
    $(".inputNomepac-info").css("#e0dfdf");
    // document.getElementById("inputNomepac").style.border = "solid 2px #e66262";
    $("#inputNomepac").css({ border: "2px solid #e66262" });
    swal("Oops", "Você precisar informar o Nome Paciente.", "info");
    $("#inputNomepac").focus();
    valid = false;
    validForm(valid);
  }

  if (inputCpf == "null" || inputCpf == "") {
    $(".inputCpf-info").html(" (Required)");
    $(".inputCpf-info").css("#e0dfdf");
    $("#inputCpf").css({ border: "2px solid #e66262" });
    swal("Oops", "Você precisar informar o CPF.", "info");
    valid = false;
    validForm(valid);
  }

  if (profSelect == "todos" || profSelect == "") {
    $(".profSelect-info").html(" (Required)");
    $(".profSelect-info").css("#e0dfdf");
    $("#profSelect").css({ border: "2px solid #e66262" });
    swal("Oops", "Você precisar informar o Profissional.", "info");
    valid = false;
    validForm(valid);
  }

  return false;
}

function validForm(value) {
  if (value) {
    alert("fomrulário válido!");
  } else {
    alert("formulário inválido!");
  }
}

function showAlert(tipo, mensagem) {
  var cssMessage =
    "display: block; position: fixed; top: 0px; left: 60%; right: 10%; width: 25%; padding-top: 100px; z-index: 9999;";
  var cssInner = "margin: 0 auto; box-shadow: 1px 1px 5px black;";

  // monta o html da mensagem com Bootstrap
  var conteudo = "";
  conteudo += '<div id="alert" style="' + cssMessage + '">';
  conteudo +=
    '    <div class="alert alert-' + tipo + '" style="' + cssInner + '">';
  conteudo +=
    '    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>';
  conteudo += mensagem;
  conteudo += "    </div>";
  conteudo += "</div>";

  $("#alert").fadeIn(2000);
  setTimeout(function () {
    $("#alert").fadeOut(2000);
  }, 2000);

  $("#alert_message").html(conteudo);
}

$(".chavesearch").click(function () {
  var x, text;
  x = document.getElementById("chave").value;

  if (x == "") {
    text = "Nenhum token digitado!";
    document.getElementById("tokenOnly").innerHTML = "";
  } else {
    seach_token(x);
    text = "";
  }
  document.getElementById("msgg").innerHTML = text;
});

function ocultocpf(cpf) {
  var str = cpf.split("");

  var w = 3;
  var e = 4;
  var z = 5;
  var x = 6;
  var c = 7;
  var d = 8;
  var f = 9;

  str[w] = "*";
  str[e] = "*";
  str[z] = "*";
  str[x] = "*";
  str[c] = "*";
  str[d] = "*";
  str[f] = "*";

  return str.join("");
  // alert(str.join(''));
}

function data_hora(d) {
  var dia = d.getDate() < 10 ? "0" + d.getDate() : d.getDate();
  var mes = d.getMonth() + 1 < 10 ? "0" + (d.getMonth() + 1) : d.getMonth() + 1;
  var ano = d.getFullYear();
  var h =
    d.getHours() < 10
      ? "0" + d.getHours()
      : d.getHours(); /*variável h recebe valor de parâmetro para pegar 
as horas*/
  var m =
    d.getMinutes() < 10
      ? "0" + d.getMinutes()
      : d.getMinutes(); /*variável m recebe valor de parâmetro para pegar 
os minutos*/
  var s =
    d.getSeconds() < 10
      ? "0" + d.getSeconds()
      : d.getSeconds(); /*variável s recebe valor de parâmetro para pegar 
os segundos*/
  var hora_atual = h + ":" + m + "h"; /*variável hora_atual recebe os valores 
concatenados das variáveis h m s */
  // p.innerHTML = `Hora atual: ${hora_atual}`; /* elemento HTML <p> é modificado*/
  // return (dia + "/" + mes + "/" + ano + " - " + hora_atual);
  return dia + "/" + mes + "/" + ano + " - " + hora_atual;
  //ou
}

function setAtivaModal(x, y) {
  document.getElementById("u_ativo").value = x;
  document.getElementById("s_ativo").value = y;
  return;
}

function setDesativaModal(x, y) {
  document.getElementById("u_desativo").value = x;
  document.getElementById("s_desativo").value = y;
  return;
}

// dropdraw
function selectChange(e) {
  let id = e.target.value;
  list_pagamento(id);
}

function fetchAno(ano) {
  $("#" + ano).empty();
  // $('#' + ano).append("<option value='" + 'todos' + "'>Todos</option>");
  const d = new Date();
  let year = d.getFullYear();
  var i = year;

  // for (i; i <= 2025; i++) {
  $("#" + ano).append("<option value='" + i + "'>" + i + "</option>");
  // }
}

function fetchAnoPesq(ano) {
  $("#" + ano).empty();
  // $('#' + ano).append("<option value='" + 'todos' + "'>Todos</option>");

  let anoAtual = new Date().getFullYear();
  let anoFinal = 2024;

  for (let ano = anoAtual; ano >= anoFinal; ano--) {
    console.log(ano);
  }

  const d = new Date();
  let year = d.getFullYear();
  var i = year;

  for (i; i >= 2024; i++) {
    $("#" + ano).append("<option value='" + i + "'>" + i + "</option>");
  }
}

function fetchMes(mes) {
  // --- INÍCIO DA ALTERAÇÃO ---

  // Pega a data atual
  const dataAtual = new Date();
  // Pega o índice do mês atual (0-11) e adiciona 1 para corresponder à estrutura do array 'meses' (1-12)
  const indiceMesAtual = dataAtual.getMonth() + 1;
  // Pega o nome do mês atual a partir do array 'meses' (ex: 'Agosto')
  const nomeMesAtual = meses[indiceMesAtual].valor;

  // --- FIM DA ALTERAÇÃO ---

  $("#" + mes).empty();

  meses.forEach((score, index, array) => {
    // --- ALTERAÇÃO NA CONDIÇÃO 'selected' ---
    // Verifica se o valor da opção atual é igual ao nome do mês atual
    let isSelected = score.valor === nomeMesAtual ? "selected" : "";
    $("#" + mes).append(
      "<option value='" +
      score.valor +
      "' " +
      isSelected +
      ">" +
      score.texto +
      "</option>"
    );
  });
}

function fetchPagamento(tipo) {
  $("#" + tipo).empty();
  // $('#' + tipo).append("<option value='" + 'todos' + "' selected>Todos</option>");
  tipopagamento.forEach((score, index, array) => {
    $("#" + tipo).append(
      "<option value='" +
      score.valor +
      "' " +
      (score.valor == "todos" ? "selected" : "") +
      ">" +
      score.texto +
      "</option>"
    );
  });
}

function fetchModal(mod) {
  $("#" + mod).empty();
  // $('#' + mod).append("<option value='" + 'todos' + "' selected>Todos</option>");
  modalidade.forEach((score, index, array) => {
    $("#" + mod).append(
      "<option value='" +
      score.valor +
      "' " +
      (score.valor == "todos" ? "selected" : "") +
      ">" +
      score.texto +
      "</option>"
    );
  });
}

function fetchModaGerar(mod) {
  $("#" + mod).empty();
  // $('#' + mod).append("<option value='" + 'todos' + "' selected>Todos</option>");
  modalidadeGerar.forEach((score, index, array) => {
    $("#" + mod).append(
      "<option value='" +
      score.valor +
      "' " +
      (score.valor == "todos" ? "selected" : "") +
      ">" +
      score.texto +
      "</option>"
    );
  });
}

function fetchModaPesqui(mod) {
  $("#" + mod).empty();
  // $('#' + mod).append("<option value='" + 'todos' + "' selected>Todos</option>");
  modalidadePes.forEach((score, index, array) => {
    $("#" + mod).append(
      "<option value='" +
      score.valor +
      "' " +
      (score.valor == "todos" ? "selected" : "") +
      ">" +
      score.texto +
      "</option>"
    );
  });
}

function getMes(mes) {
  return this.meses[mes];
}
var meses = new Array(13);
meses[0] = { valor: "todos", texto: "Todos" };
meses[1] = { valor: "Janeiro", texto: "Janeiro" };
meses[2] = { valor: "Fevereiro", texto: "Fevereiro" };
meses[3] = { valor: "Março", texto: "Março" };
meses[4] = { valor: "Abril", texto: "Abril" };
meses[5] = { valor: "Maio", texto: "Maio" };
meses[6] = { valor: "Junho", texto: "Junho" };
meses[7] = { valor: "Julho", texto: "Julho" };
meses[8] = { valor: "Agosto", texto: "Agosto" };
meses[9] = { valor: "Setembro", texto: "Setembro" };
meses[10] = { valor: "Outubro", texto: "Outubro" };
meses[11] = { valor: "Novembro", texto: "Novembro" };
meses[12] = { valor: "Dezembro", texto: "Dezembro" };

function getPagamento(tipopag) {
  return this.tipopagamento[tipopag];
}
var tipopagamento = new Array(5);
tipopagamento[0] = { valor: "todos", texto: "Todos" };
tipopagamento[1] = { valor: "Crédito", texto: "Crédito" };
tipopagamento[2] = { valor: "Débito", texto: "Débito" };
tipopagamento[3] = { valor: "Espécie", texto: "Espécie" };
tipopagamento[4] = { valor: "Pix", texto: "Pix" };
tipopagamento[5] = { valor: "Pix / Qrcode", texto: "Pix / Qrcode" };

var modalidade = new Array(11);
modalidade[0] = { valor: "todos", texto: "Todos" };
modalidade[1] = {
  valor: "Avaliação T",
  texto: "Avaliação Terapia (Psicologia / Terapia Casal / TO)",
};
modalidade[2] = { valor: "Avaliação F", texto: "Avaliação Fono" };
modalidade[3] = { valor: "Avaliação N", texto: "Avaliação Neuropsicológica" };
modalidade[4] = { valor: "Visita E", texto: "Visita Escolar" };
modalidade[5] = { valor: "Proase", texto: "Proase" };
modalidade[6] = { valor: "Proase Av", texto: "Sessão Avulsa Proase" };
modalidade[7] = { valor: "Pacote", texto: "Pacote" };
modalidade[8] = { valor: "Pacote Av", texto: "Sessão Avulsa Pacote" };
modalidade[9] = { valor: "Consulta Psiquiatra", texto: "Consulta Psiquiatria" };
modalidade[10] = { valor: "Consulta Nutrição", texto: "Consulta Nutrição" };

var modalidadeGerar = new Array(9);
modalidadeGerar[0] = { valor: "todos", texto: "Todos" };
modalidadeGerar[1] = {
  valor: "Avaliação T",
  texto: "Avaliação Terapia (Psicologia / Terapia Casal / TO)",
};
modalidadeGerar[2] = { valor: "Avaliação F", texto: "Avaliação Fono" };
modalidadeGerar[3] = {
  valor: "Avaliação N",
  texto: "Avaliação Neuropsicológica",
};
modalidadeGerar[4] = { valor: "Visita E", texto: "Visita Escolar" };
modalidadeGerar[5] = { valor: "Proase", texto: "Proase" };
modalidadeGerar[6] = { valor: "Plano Mensal", texto: "Plano Mensal" };
modalidadeGerar[7] = {
  valor: "Consulta Psiquiatra",
  texto: "Consulta Psiquiatria",
};
modalidadeGerar[8] = { valor: "Consulta Nutrição", texto: "Consulta Nutrição" };

var modalidadePes = new Array(10);
modalidadePes[0] = { valor: "todos", texto: "Todos" };
modalidadePes[1] = {
  valor: "Avaliação T",
  texto: "Avaliação Terapia (Psicologia / Terapia Casal / TO)",
};
modalidadePes[2] = { valor: "Avaliação F", texto: "Avaliação Fono" };
modalidadePes[3] = {
  valor: "Avaliação N",
  texto: "Avaliação Neuropsicológica",
};
modalidadePes[4] = { valor: "Visita E", texto: "Visita Escolar" };
modalidadePes[5] = { valor: "Proase", texto: "Proase" };
modalidadePes[6] = { valor: "Proase Av", texto: "Sessão Avulsa Proase" };
modalidadePes[7] = { valor: "Pacote", texto: "Pacote" };
modalidadePes[8] = { valor: "Pacote Av", texto: "Sessão Avulsa Pacote" };
modalidadePes[9] = { valor: "Plano Mensal", texto: "Plano Mensal" };
modalidadePes[10] = {
  valor: "Consulta Psiquiatra",
  texto: "Consulta Psiquiatria",
};
modalidadePes[11] = { valor: "Consulta Nutrição", texto: "Consulta Nutrição" };

// Dropdown com id selecionado
function fetchDropdownEdit(getValue) {
  $.ajax({
    method: "POST",
    url: "sqls/fetch_pac.php",
    // data: {id:id},
    dataType: "json",
    success: function (response) {
      var len = response.dataprof.length;

      $("#nomeprof").empty();
      var getid = getValue;
      for (var i = 0; i < len; i++) {
        var id = response.dataprof[i]["id_prof"];
        var name = response.dataprof[i]["profissional"];
        $("#nomeprof").append(
          "<option value='" +
          id +
          "' " +
          (id == getid ? "selected" : "") +
          ">" +
          name +
          "</option>"
        );
      }
    },
  });
}

function fetchProf(id, descricao, tipo) {
  let idd = id;
  let desc = descricao;
  let tip = tipo;

  if (tip != "prof") {
    $.ajax({
      method: "POST",
      url: "./sqls/list_prof.php",
      // data: { e_id: getvalt },
      dataType: "json",
      success: function (response) {
        let len = response.listaprof.length;

        $("#" + idd).empty();
        $("#" + idd).append(
          "<option value='" + "todos" + "' selected>" + desc + "</option>"
        );
        for (var i = 0; i < len; i++) {
          var idvalue = response.listaprof[i]["id_prof"];
          var name = response.listaprof[i]["profissional"];
          $("#" + idd).append(
            "<option value='" + idvalue + "'>" + name + "</option>"
          );
        }
        $(".picker").selectpicker();
      },
    });
  } else {
    $("#" + idd).append("<option value='" + idd + "'>" + desc + "</option>");
  }
}

function fetchDropdownPac() {
  $.ajax({
    method: "POST",
    url: "sqls/fetch_pac.php",
    // data: {id:id},
    dataType: "json",
    success: function (response) {
      var len = response.dataprof.length;

      $("#nomeprof").empty();
      for (var i = 0; i < len; i++) {
        var id = response.dataprof[i]["id_prof"];
        var name = response.dataprof[i]["profissional"];
        $("#nomeprof").append(
          "<option value='" + id + "'>" + name + "</option>"
        );
      }
    },
  });
}

function reloadPage() {
  window.location.reload();
}

function formatarDataString(dataString) {
  // Se a data do banco já vem como 'YYYY-MM-DD', não precisa de muita formatação aqui.
  // Mas se viesse como 'YYYY-MM-DD HH:MM:SS', faríamos:
  return dataString.split(" ")[0];
  // return dataString; // Assumimos que o PHP já enviou 'YYYY-MM-DD'
}
function formatarDataHora(dataString) {
  // Se a data do banco já vem como 'YYYY-MM-DD', não precisa de muita formatação aqui.
  // Mas se viesse como 'YYYY-MM-DD HH:MM:SS', faríamos:
  return dataString.split(" ")[1];
  // return dataString; // Assumimos que o PHP já enviou 'YYYY-MM-DD'
}

// Abre o modal de edição e popula os campos
function getEditlsT(id, tip) {
  $.ajax({
    method: "POST",
    url: "sqls/my_tok.php",
    data: { chave: id, tipo: tip },
    dataType: "json",
    success: function (response) {
      var venDate = response.data.datacad;
      var curDate = new Date(venDate);

      if (response.error) {
        showAlert();
        $("#alert_message").html(response.message);
      } else {
        $(".id").val(response.data.id_token);
        fetchDropdownEdit(response.data.id_prof);
        $(".solicitado").text(data_hora(curDate));
        $(".solicitante").text(response.data.nome);

        $("#nova_data").val(formatarDataString(response.data.datacad));
        $("#data_atual").val(response.data.datacad);

        if (response.typeconsulta != "view") {
          $(".paciente").val(response.data.paciente);
          $(".resp").val(response.data.nomeresp);
          $(".respfinanc").val(response.data.responsavel_f);
          $(".cpf").val(response.data.cpf);

                    // Verifica se a data existe e não é um valor nulo/padrão do banco
          if (response.data.pag_resp && response.data.pag_resp !== '0000-00-00' && response.data.pag_resp !== null) {
            // Usa a função formatarDataString para pegar apenas a data (YYYY-MM-DD)
            $("#edit_pag_resp").val(formatarDataString(response.data.pag_resp));
          } else {
            $("#edit_pag_resp").val(""); // Limpa o campo se não houver data válida
          }

          console.log(response.data.pag_resp);
          // --- FIM DA ADIÇÃO ---

          var testeString = response.data.datapag;
          if (testeString !== null) {
            var resultado = testeString.split(/[\s,]+/);
            for (let index = 0; index < resultado.length; index++) {
              let element = resultado[index];
              document.querySelectorAll('[name="datac[]"]')[index].value =
                element;
            }
          }
          document.querySelectorAll('[name="obs"]')[0].value =
            response.data.obs;
          document.querySelectorAll('[name="v_negociavel"]')[0].value =
            numberFormat1.format(response.data.valorpag);

          // $('.obs').val(response.data.obs);
          // $('.v_negociavel').val(numberFormat1.format(response.data.valorpag));
        } else {
          $(".nomep").text(response.data.profissional);
          $(".paciente").text(response.data.paciente);

          if (response.data.nomeresp) {
            $(".resplabel").text("Responsável: ");
            $(".respname").text(response.data.nomeresp);
          } else {
            $(".resplabel").text("");
            $(".respname").text("");
          }
          if (response.data.responsavel_f) {
            $(".resplabelFinanc").text("Responsável Financeiro: ");
            $(".respfinanc").text(response.data.responsavel_f);
          } else {
            $(".resplabelFinanc").text("");
            $(".respfinanc").text("");
          }

          $(".resp").text(response.data.nomeresp);
          $(".respfinanc").text(response.data.responsavel_f);
          $(".cpf").text(response.data.cpf);
          $(".referencia").text(
            response.data.mes_ref + "/" + response.data.ano_ref
          );
          let fruits = new Array(response.data.datapag);
          for (let index = 0; index < fruits.length; index++) {
            let element = fruits[index];
            // var ttt = element.slice(8, 10);
            $(".agendamento").text(element);
          }
          $(".pagamento").text(numberFormat1.format(response.data.valorpag));

          if (response.data.obs) {
            $(".obss").text("Observação: ");
            $(".obsvalor").text(response.data.obs);
          } else {
            $(".obss").text("");
            $(".obsvalor").text("");
          }

          switch (response.data.modalidadepag) {
            case "Avaliação T":
              var tipomod = "Avaliação Terapia";
              break;
            case "Avaliação F":
              var tipomod = "Avaliação Fono";
              break;
            case "Avaliação N":
              var tipomod = "Avaliação Neuropsicológica";
              break;
            case "Visita E":
              var tipomod = "Visita Escolar";
              break;
            case "Proase":
              var tipomod = "Proase";
              break;
            case "Plano Mensal":
              var tipomod = "Plano Mensal";
              break;
            case "Consulta Psiquiatra":
              var tipomod = "Consulta Psiquiatra";
              break;
            case "Consulta Nutrição":
              var tipomod = "Consulta Nutrição";
              break;
            default:
              var tipomod = "";
              break;
          }

          $(".modalidade").text(tipomod);
          $(".tipopag").text(response.data.tipopag);
        }

        var getmod = response.data.modalidadepag;
        $("#modalidaderef").empty();
        modalidadeGerar.forEach((score, index, array) => {
          $("#modalidaderef").append(
            "<option value='" +
            score.valor +
            "' " +
            (score.valor == getmod ? "selected" : "") +
            ">" +
            score.texto +
            "</option>"
          );
        });

        var gettipo = response.data.tipopag;
        $("#tipopag").empty();
        tipopagamento.forEach((score, index, array) => {
          $("#tipopag").append(
            "<option value='" +
            score.valor +
            "' " +
            (score.valor == gettipo ? "selected" : "") +
            ">" +
            score.texto +
            "</option>"
          );
        });

        // 1. Pega o valor pré-selecionado
        var bancoParaSelecionar = response.data.nome_banco;

        popularDropdownBancoFixo(bancoParaSelecionar);

        // 6. [IMPORTANTE] Se for selectpicker, precisa do refresh
        // $("#edit_listbanco").selectpicker('refresh');

        $(".obs").text(response.data.obs);
        $(".v_negociavel").text(numberFormat1.format(response.data.valorpag));

        $(".tokeng").text(response.data.token);
        $(".idtoken").val(response.data.token);
      }
    },
  });
}


/**
 * Popula o dropdown de bancos e pré-seleciona um valor.
 * @param {string} bancoParaSelecionar - O valor (ex: "Itau") do banco a ser selecionado.
 */
function popularDropdownBancoFixo(bancoParaSelecionar) {

  // 1. Defina sua lista de opções aqui
  var listaDeOpcoes = [
    { valor: "", texto: "Nenhum" },
    { valor: "Itau", texto: "Banco Itau" },
    { valor: "Bradesco", texto: "Banco Bradesco" }
  ];

  // 2. Limpa espaços em branco do valor que veio do response (MUITO IMPORTANTE)
  if (bancoParaSelecionar && typeof bancoParaSelecionar === 'string') {
    bancoParaSelecionar = bancoParaSelecionar.trim();
    console.log("Valor para selecionar (tratado): " + bancoParaSelecionar);
  } else {
    bancoParaSelecionar = ""; // Define um padrão seguro (Nenhum)
    console.log("Nenhum valor fornecido, selecionando padrão: " + bancoParaSelecionar);
  }

  // 3. Seleciona o elemento dropdown
  var $dropdown = $("#listbanco");

  // 4. Limpa opções antigas
  $dropdown.empty();

  // 5. Itera sobre sua lista fixa e cria as <option>
  listaDeOpcoes.forEach((banco) => {

    // Verifica se esta é a opção que deve ser selecionada
    var selecionado = (banco.valor == bancoParaSelecionar) ? "selected" : "";

    // Debug: Verifica qual opção está sendo marcada como selecionada
    // console.log(`Opção: ${banco.valor} | Para Selecionar: ${bancoParaSelecionar} | Selecionado: ${selecionado}`);

    $dropdown.append(
      "<option value='" + banco.valor + "' " + selecionado + ">" + banco.texto + "</option>"
    );
  });

  // 6. [MUITO IMPORTANTE] Atualize o plugin selectpicker
  // Sem isso, o dropdown não será atualizado na tela.
  $dropdown.selectpicker('refresh');
}



function validarFormularioToken() {
  // Primeiro, removemos todos os destaques de erro anteriores para uma nova validação.
  const campos = [
    "#inputNomepac",
    "#inputCpf",
    "#profSelect",
    "#mesSelect",
    "#anoSelect",
    "#inputData",
    "#modalidadeRadio",
    "#negociavel",
    "#listforma",
  ];
  campos.forEach((campo) => {
    $(campo).css("border", "1px solid #ced4da");
    // Tratamento especial para o selectpicker do Bootstrap
    if ($(campo).is("select")) {
      $(campo)
        .next(".bootstrap-select")
        .find("button")
        .css("border", "1px solid #ced4da");
    }
  });

  // Função auxiliar para exibir o erro e destacar o campo
  function mostrarErro(idCampo, mensagem) {
    Swal.fire({
      icon: "warning",
      title: "Campo Obrigatório",
      text: mensagem,
    });

    const elemento = $(idCampo);
    elemento.css("border", "2px solid #e66262");

    // Foca no campo com erro, tratando o selectpicker
    if (elemento.is("select")) {
      elemento.next(".bootstrap-select").find("button").focus();
      elemento
        .next(".bootstrap-select")
        .find("button")
        .css("border", "2px solid #e66262");
    } else {
      elemento.focus();
    }

    return false; // Retorna false para indicar que a validação falhou
  }

  // 1. Validação do Nome do Paciente
  if ($.trim($("#inputNomepac").val()) === "") {
    return mostrarErro(
      "#inputNomepac",
      "Por favor, preencha o nome do paciente."
    );
  }

  // 2. Validação do CPF
  if ($.trim($("#inputCpf").val()) === "") {
    return mostrarErro("#inputCpf", "Por favor, preencha o CPF.");
  }

    // 3. Validação do Profissional
    if ($('#profSelect').val() === null || $('#profSelect').val() === 'todos' || $('#profSelect').val() === '') {
        return mostrarErro('#profSelect', 'Por favor, selecione o profissional.');
    }


  // Validação do Profissional
  if ($("#pag_resp").val() === null || $("#pag_resp").val() === "") {
    return mostrarErro(
      "#pag_resp",
      "Por favor, selecione a data de pagamento."
    );
  }

  // Validação do campo banco
  if ($("#listbanco").val() === null || $("#listbanco").val() === "") {
    return mostrarErro(
      "#profSelect",
      "Por favor, selecione o banco de pagamento."
    );
  }

  // 5. Validação das Datas de Sessão (pelo menos uma deve ser preenchida)
  let algumaDataPreenchida = false;
  $('input[name="datac[]"]').each(function () {
    if ($.trim($(this).val()) !== "") {
      algumaDataPreenchida = true;
      return false; // Sai do loop .each()
    }
  });
  if (!algumaDataPreenchida) {
    return mostrarErro(
      "#inputData",
      "É necessário preencher pelo menos uma data de sessão."
    );
  }

  // 6. Validação da Modalidade de Atendimento
  if (
    $("#modalidadeRadio").val() === null ||
    $("#modalidadeRadio").val() === "todos" ||
    $("#modalidadeRadio").val() === ""
  ) {
    return mostrarErro(
      "#modalidadeRadio",
      "Por favor, selecione a modalidade de atendimento."
    );
  }

  // 7. Validação do Valor
  if (
    $.trim($("#negociavel").val()) === "" ||
    $.trim($("#negociavel").val()) === "R$ 0,00"
  ) {
    return mostrarErro("#negociavel", "Por favor, preencha o valor.");
  }

  // 8. Validação da Forma de Pagamento
  if (
    $("#listforma").val() === null ||
    $("#listforma").val() === "todos" ||
    $("#listforma").val() === ""
  ) {
    return mostrarErro(
      "#listforma",
      "Por favor, selecione a forma de pagamento."
    );
  }

  // Se todas as validações passaram
  return true;
}

function fetch() {
  $.ajax({
    method: "POST",
    url: "sqls/fetch.php",
    success: function (response) {
      $("#tbody").html(response);
    },
  });
  // fetchAdm();
}

function fetchAdm() {
  $.ajax({
    method: "POST",
    url: "sqls/fetch_adm.php",
    success: function (response) {
      $("#admbody").html(response);
    },
  });
}

function fetchProfStatus() {
  $.ajax({
    method: "POST",
    url: "sqls/fetch_prof.php",
    success: function (response) {
      $("#profbody").html(response);
    },
  });
}

function fetchToken() {
  $.ajax({
    method: "POST",
    url: "sqls/fetch_token.php",
    success: function (response) {
      $("#tokenbody").html(response);
    },
  });
}

function seach_token(dataid) {
  var dados = {
    chave: dataid,
  };
  $.post("sqls/my_tokens.php", dados, function (retorna) {
    //Subtitui o valor no seletor id="conteudo"
    $("#tokenOnly").html(retorna);
  });
}

// lista o modal no campo de pesquisa via link
function list_tokenPesquisa(chave) {
  $("#viewForm")[0].reset();
  getEditlsT(chave, "view");
  $("#viewModal").modal("show");
}

function deselectOption(id) {
  var opVal = $("#" + id + " option:selected").text();
  if (opVal.toLowerCase() != "todos") {
    $("#" + id + " option")
      .eq(0)
      .prop("selected", false);
  }
}

function refresRoload() {
  setTimeout(
    () => {
      document.location.reload();
    },
    300,
    "linear"
  );
}
