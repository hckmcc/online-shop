<?php
require_once '../Controller/UserController.php';
require_once '../Controller/ProductController.php';

class Route
{
    private string $route;
    private string $method;

    public function __construct(string $route, string $method)
    {
        $this->route = $route;
        $this->method = $method;
    }

    public function getPage(): void
    {
        switch ($this->route) {
            case '/login':
                $this->login($this->method);
                break;
            case '/register':
                $this->register($this->method);
                break;
            case '/catalog':
                $this->catalog($this->method);
                break;
            case '/cart':
                $this->cart($this->method);
                break;
            case '/add_product':
                $this->addProduct($this->method);
                break;
            default:
                http_response_code(404);
        }
    }

    private function login($requestMethod): void
    {
        if ($requestMethod === 'POST'){
            $user = new UserService();
            $login_response = $user->login($_POST["email"], $_POST["psw"]);
            if (is_bool($login_response)){
                header('Location: /catalog');
            }else{
                $errors=$login_response;
                require_once '../View/get_login.php';
            };
        }elseif ($requestMethod === 'GET'){
            require_once '../View/get_login.php';
        }else{
            echo 'Incorrect method';
        }
    }
    private function register($requestMethod): void
    {
        if ($requestMethod === 'POST'){
            $user = new UserService();
            $register_response = $user->register($_POST["name"], $_POST["email"], $_POST["psw"], $_POST["rpt_psw"]);
            if (is_bool($register_response)){
                header('Location: /login');
            }else{
                $errors=$register_response;
                require_once '../View/get_registration.php';
            };
        }elseif ($requestMethod === 'GET'){
            require_once '../View/get_registration.php';
        }else{
            echo 'Incorrect method';
        }
    }
    private function catalog($requestMethod): void
    {
        if ($requestMethod === 'GET'){
            $product = new ProductService();
            $result = $product->getProductsInCatalog();
            require_once '../View/catalog.php';
        }else{
            echo 'Incorrect method';
        }
    }
    private function cart($requestMethod): void
    {
        if ($requestMethod === 'GET'){
            $product = new ProductService();
            $result = $product->getProductsInCart();
            require_once '../View/cart.php';
        }else{
            echo 'Incorrect method';
        }
    }
    private function addProduct($requestMethod): void
    {
        if ($requestMethod === 'POST'){
            $product = new ProductService();
            $result = $product->addProductToCart($_POST["product_id"], $_POST["amount"]);
            if($result){
                header('Location: /catalog');
            }else{
                http_response_code(404);
            }
        }else{
            echo 'Incorrect method';
        }
    }
}