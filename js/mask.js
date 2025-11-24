// $(document).ready(function () {


//   alert('texte de conexão!');

// });


$(function () {

    $(".seudiames").mask("00/00");

    $(".seutel").mask("(00) 00000-0000");

    $(".seucpf").mask("000.000.000-00");

    $(".seucep").mask("00000-000");

    $('.horatime').mask('00:00');

    $('input.seudata').mask("00/00/0000");
    // $('input.seudata').mask("00/00/0000", { reverse: true });

    $('span#seudata').mask("00/00/0000");

    $('.seunumero').mask("0");

});



function mascaraMoeda(event) {

    const onlyDigits = event.target.value

      .split("")

      .filter(s => /\d/.test(s))

      .join("")

      .padStart(3, "0")

    const digitsFloat = onlyDigits.slice(0, -2) + "." + onlyDigits.slice(-2)

    event.target.value = maskCurrency(digitsFloat)

  }

  function maskCurrency(valor, locale = 'pt-BR', currency = 'BRL') {

    return new Intl.NumberFormat(locale, {

      style: 'currency',

      currency

    }).format(valor)

  }