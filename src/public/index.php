<?php
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
switch ($requestUri){
    case '/login':
        $pageArr=['post'=>'./handle_login.php','get'=>'./get_login.php'];
        getPage($pageArr, $requestMethod);
        break;
    case '/register':
        $pageArr=['post'=>'./handle_registration.php','get'=>'./get_registration.php'];
        getPage($pageArr, $requestMethod);
        break;
    case '/catalog':
        $pageArr=['post'=>null,'get'=>'./catalog.php'];
        getPage($pageArr, $requestMethod);
        break;
    case '/add_product':
        $pageArr=['post'=>'./handle_add_product.php','get'=>null];
        getPage($pageArr, $requestMethod);
        break;
    case '/cart':
        $pageArr=['post'=>null,'get'=>'./cart.php'];
        getPage($pageArr, $requestMethod);
        break;
    default:
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