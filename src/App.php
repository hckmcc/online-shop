<?php
require_once '../Controller/UserController.php';
require_once '../Controller/ProductController.php';
require_once '../Controller/OrderController.php';
class App
{
    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        switch ($requestUri) {
            case '/login':
                $this->login($requestMethod);
                break;
            case '/register':
                $this->register($requestMethod);
                break;
            case '/catalog':
                $this->catalog($requestMethod);
                break;
            case '/cart':
                $this->cart($requestMethod);
                break;
            case '/add_product':
                $this->addProduct($requestMethod);
                break;
            case '/order':
                $this->order($requestMethod);
                break;
            default:
                http_response_code(404);
        }
    }

    private function login($requestMethod): void
    {
        if ($requestMethod === 'POST'){
            $user = new UserService();
            $user->login($_POST["email"], $_POST["psw"]);
        }elseif ($requestMethod === 'GET'){
            $user = new UserService();
            $user->getLoginPage();
        }else{
            echo 'Incorrect method';
        }
    }
    private function register($requestMethod): void
    {
        if ($requestMethod === 'POST'){
            $user = new UserService();
            $user->register($_POST["name"], $_POST["email"], $_POST["psw"], $_POST["rpt_psw"]);
        }elseif ($requestMethod === 'GET'){
            $user = new UserService();
            $user->getRegistrationPage();
        }else{
            echo 'Incorrect method';
        }
    }
    private function catalog($requestMethod): void
    {
        if ($requestMethod === 'GET'){
            $product = new ProductService();
            $product->getProductsInCatalog();
        }else{
            echo 'Incorrect method';
        }
    }
    private function cart($requestMethod): void
    {
        if ($requestMethod === 'GET'){
            $product = new ProductService();
            $product->getProductsInCart();
        }else{
            echo 'Incorrect method';
        }
    }
    private function addProduct($requestMethod): void
    {
        if ($requestMethod === 'POST'){
            $product = new ProductService();
            $product->addProductToCart($_POST["product_id"], $_POST["amount"]);
        }else{
            echo 'Incorrect method';
        }
    }
    private function order($requestMethod): void
    {
        if ($requestMethod === 'POST'){
            $order = new OrderService();
            $order->createOrder($_POST["name"], $_POST["phone"], $_POST["address"], $_POST["comment"]);
        }elseif ($requestMethod === 'GET'){
            $order = new OrderService();
            $order->getOrderPage();
        }else{
            echo 'Incorrect method';
        }
    }
}