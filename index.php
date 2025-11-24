<?php

//Incluir o arquivo de configuração
include_once __DIR__.'/config/s_config.php';


// require_once('./vendor/autoload.php');

require_once(__DIR__.'/vendor/autoload.php');

try {
    $dotenv = Dotenv\Dotenv::createUnsafeMutable(__DIR__);
    $dotenv->load();
    // print_r($dotenv);
} catch (Exception $e) {
    exit('Could not find a .env file Index.');
}

// Receber a URL do .htaccess. Se não existir o nome da página, carregar a página inicial (home).
$params = (!empty(filter_input(INPUT_GET, 'params', FILTER_DEFAULT)) ? filter_input(INPUT_GET, 'params', FILTER_DEFAULT) : 'home');
// var_dump($params);
// echo '<br>';

// Converter a URL de uma string para um array.
$params = array_filter(explode('/', $params)); 
// var_dump($params);
// echo '<br>';

// Criar o caminho da página com o nome que está na primeira posição do array criado acima e atribuir a extensão .php.
$page = 'pages/' . $params[0] . '.php';
// var_dump($page);

// Verificar se existe o arquivo no servidor. Se não existir, acessar o ELSE e carregar a página de erro.
if(is_file($page)){
    include $page;
}else{
    include __DIR__.'/pages/page404.php';
}