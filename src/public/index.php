<?php
require_once '../Core/Autoload.php';

use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use Core\App;
use Core\Autoload;
use Core\Container;
use Request\AddProductRequest;
use Request\DeleteProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegisterRequest;
use Service\Logger\LoggerDBService;

Autoload::register(dirname(__DIR__,1));
$container = new Container();

$container->set(\Service\Auth\AuthServiceInterface::class, function(){
    return new \Service\Auth\AuthSessionService();
});
$container->set(\Service\Logger\LoggerServiceInterface::class, function(){
    return new LoggerDBService();
});

$container->set(UserController::class, function(Container $container){
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    return new UserController($authService);
});
$container->set(ProductController::class, function(Container $container){
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    $cartService = new \Service\CartService();
    return new ProductController($authService, $cartService);
});
$container->set(OrderController::class, function(Container $container){
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    $orderService = new \Service\OrderService();
    return new OrderController($authService, $orderService);
});

$app = new App($container);
$app->addRoute('/login','GET', UserController::class,'getLoginPage');
$app->addRoute('/login','POST', UserController::class,'login',LoginRequest::class);
$app->addRoute('/logout','GET', UserController::class,'logout');
$app->addRoute('/register','GET', UserController::class,'getRegistrationPage');
$app->addRoute('/register','POST', UserController::class,'register',RegisterRequest::class);
$app->addRoute('/catalog','GET', ProductController::class,'getProductsInCatalog');
$app->addRoute('/cart','GET', ProductController::class,'getProductsInCart');
$app->addRoute('/add_product','POST', ProductController::class,'addProductToCart',AddProductRequest::class);
$app->addRoute('/delete_product','POST', ProductController::class,'deleteProductFromCart',DeleteProductRequest::class);
$app->addRoute('/order','GET', OrderController::class,'getOrderPage');
$app->addRoute('/order','POST', OrderController::class,'createOrder', OrderRequest::class);
$app->addRoute('/my_orders','GET', OrderController::class,'getUserOrderList');
$app->addRoute('/product','GET', ProductController::class,'getProductPage', \Request\GetProductRequest::class);
$app->addRoute('/product','POST', ProductController::class,'addReview', \Request\AddReviewRequest::class);

$app->run();