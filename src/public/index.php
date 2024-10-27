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
use Service\Auth\AuthSessionService;
use Service\Logger\LoggerFileService;
use Service\Logger\LoggerDBService;
use Service\CartService;
use Service\OrderService;

Autoload::register(dirname(__DIR__,1));
$loggerServiceFile = new LoggerFileService();
$loggerServiceDB = new LoggerDBService();
$userControllerProperties = ['AuthService' => new AuthSessionService()];
$productControllerProperties = ['CartService' => new CartService(), 'AuthService' => new AuthSessionService()];
$orderControllerProperties = ['OrderService' => new OrderService(), 'AuthService' => new AuthSessionService()];

$app = new App($loggerServiceDB);
$app->addRoute('/login','GET', UserController::class,'getLoginPage', $userControllerProperties);
$app->addRoute('/login','POST', UserController::class,'login', $userControllerProperties,LoginRequest::class);
$app->addRoute('/logout','GET', UserController::class,'logout', $userControllerProperties);
$app->addRoute('/register','GET', UserController::class,'getRegistrationPage', $userControllerProperties);
$app->addRoute('/register','POST', UserController::class,'register', $userControllerProperties,RegisterRequest::class);
$app->addRoute('/catalog','GET', ProductController::class,'getProductsInCatalog',$productControllerProperties);
$app->addRoute('/cart','GET', ProductController::class,'getProductsInCart', $productControllerProperties);
$app->addRoute('/add_product','POST', ProductController::class,'addProductToCart', $productControllerProperties,AddProductRequest::class);
$app->addRoute('/delete_product','POST', ProductController::class,'deleteProductFromCart', $productControllerProperties,DeleteProductRequest::class);
$app->addRoute('/order','GET', OrderController::class,'getOrderPage', $orderControllerProperties);
$app->addRoute('/order','POST', OrderController::class,'createOrder', $orderControllerProperties, OrderRequest::class);
$app->addRoute('/my_orders','GET', OrderController::class,'getUserOrderList', $orderControllerProperties);

$app->run();