<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestUri==='/login'){
    $pageArr=['post'=>'./handle_login.php','get'=>'./get_login.php'];
    getPage($pageArr, $requestMethod);
}elseif ($requestUri==='/register'){
    $pageArr=['post'=>'./handle_registration.php','get'=>'./get_registration.php'];
    getPage($pageArr, $requestMethod);
}elseif ($requestUri==='/catalog'){
    $pageArr=['post'=>null,'get'=>'./catalog.php'];
    getPage($pageArr, $requestMethod);
}else{
    http_response_code(404);
}

function getPage ($pageArr, $requestMethod){
    if ($requestMethod === 'POST'){
        require_once $pageArr['post'];
    }elseif ($requestMethod === 'GET'){
        require_once($pageArr['get']);
    }else{
        echo 'Incorrect method';
    }
}