<?php
require_once '../Core/Autoload.php';

use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use Core\App;
use Core\Autoload;
use Request\AddProductRequest;
use Request\DeleteProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegisterRequest;

Autoload::register(dirname(__DIR__,1));

$app = new App();
$app->addRoute('/login','GET', UserController::class,'getLoginPage');
$app->addRoute('/login','POST', UserController::class,'login', LoginRequest::class);
$app->addRoute('/logout','GET', UserController::class,'logout');
$app->addRoute('/register','GET', UserController::class,'getRegistrationPage');
$app->addRoute('/register','POST', UserController::class,'register', RegisterRequest::class);
$app->addRoute('/catalog','GET', ProductController::class,'getProductsInCatalog');
$app->addRoute('/cart','GET', ProductController::class,'getProductsInCart');
$app->addRoute('/add_product','POST', ProductController::class,'addProductToCart', AddProductRequest::class);
$app->addRoute('/delete_product','POST', ProductController::class,'deleteProductFromCart', DeleteProductRequest::class);
$app->addRoute('/order','GET', OrderController::class,'getOrderPage');
$app->addRoute('/order','POST', OrderController::class,'createOrder', OrderRequest::class);
$app->addRoute('/my_orders','GET', OrderController::class,'getUserOrderList');

$app->run();