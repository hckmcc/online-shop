<?php
require_once '../Core/Autoload.php';
use Core\App;
use Core\Autoload;

Autoload::register(dirname(__DIR__,1));

$app = new App();
$app->addRoute('/login','GET', 'Controller\UserController','getLoginPage');
$app->addRoute('/login','POST', 'Controller\UserController','login');
$app->addRoute('/logout','GET', 'Controller\UserController','logout');
$app->addRoute('/register','GET', 'Controller\UserController','getRegistrationPage');
$app->addRoute('/register','POST', 'Controller\UserController','register');
$app->addRoute('/catalog','GET', 'Controller\ProductController','getProductsInCatalog');
$app->addRoute('/cart','GET', 'Controller\ProductController','getProductsInCart');
$app->addRoute('/add_product','POST', 'Controller\ProductController','addProductToCart');
$app->addRoute('/delete_product','POST', 'Controller\ProductController','deleteProductFromCart');
$app->addRoute('/order','GET', 'Controller\OrderController','getOrderPage');
$app->addRoute('/order','POST', 'Controller\OrderController','createOrder');
$app->addRoute('/my_orders','GET', 'Controller\OrderController','getUserOrderList');

$app->run();