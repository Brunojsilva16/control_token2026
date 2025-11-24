<body onload = carregar()> //na TAG <body> coloquei a função que será chamada no JS
.
     <p> A hora será exibida aqui... </p>
.
</body>
JavaScript

function carregar() { /*no script chamei a função declarada na TAG <body>*/
    var data = new Date;  /*objeto Date foi instanciado na variável data*/
    var h = data.getHours();  /*variável h recebe valor de parâmetro para pegar 
                               as horas*/
    var m = data.getMinutes(); /*variável m recebe valor de parâmetro para pegar 
                               os minutos*/
    var s = data.getSeconds(); /*variável s recebe valor de parâmetro para pegar 
                               os segundos*/
    var hora_atual = h+ ':' +m+ ':' +s; /*variável hora_atual recebe os valores 
                                        concatenados das variáveis h m s */
    p.innerHTML = `Hora atual: ${hora_atual}`; /* elemento HTML <p> é 
                                                modificado*/ 
    setInterval('carregar()', 1000); /*comando para chamar a função dentro de um 
                                       intervalo de tempo, 1000 é igual a 1 
                                       segundo */
    }