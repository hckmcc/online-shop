<?php
class Route
{
    private string $route;
    private string $method;

    public function __construct(string $route, string $method)
    {
        $this->route = $route;
        $this->method = $method;
    }

    public function getPage($pdo=null): void
    {
        switch ($this->route) {
            case '/login':
                $this->login($this->method, $pdo);
                break;
            case '/register':
                $this->register($this->method, $pdo);
                break;
            case '/catalog':
                $this->catalog($this->method);
                break;
            case '/cart':
                $this->cart($this->method);
                break;
            case '/add_product':
                $this->addProduct($this->method, $pdo);
                break;
            default:
                http_response_code(404);
        }
    }

    private function login($requestMethod, $pdo): void
    {
        if ($requestMethod === 'POST'){
            include './classes/user_class.php';
            $user = new UserService();
            $login_response = $user->login($pdo, $_POST["email"], $_POST["psw"]);
            if (is_bool($login_response)){
                header('Location: /catalog');
            }else{
                $errors=$login_response;
                require_once './get_login.php';
            };
        }elseif ($requestMethod === 'GET'){
            require_once './get_login.php';
        }else{
            echo 'Incorrect method';
        }
    }
    private function register($requestMethod, $pdo): void
    {
        if ($requestMethod === 'POST'){
            include './classes/user_class.php';
            $user = new UserService();
            $register_response = $user->register($pdo, $_POST["name"], $_POST["email"], $_POST["psw"], $_POST["rpt_psw"]);
            if (is_bool($register_response)){
                header('Location: /login');
            }else{
                $errors=$register_response;
                require_once './get_registration.php';
            };
        }elseif ($requestMethod === 'GET'){
            require_once './get_registration.php';
        }else{
            echo 'Incorrect method';
        }
    }
    private function catalog($requestMethod): void
    {
        if ($requestMethod === 'GET'){
            include './classes/product_class.php';
            $product = new ProductService();
            $result = $product->getProductsInCatalog();
            require_once './catalog.php';
        }else{
            echo 'Incorrect method';
        }
    }
    private function cart($requestMethod): void
    {
        if ($requestMethod === 'GET'){
            include './classes/product_class.php';
            $product = new ProductService();
            $result = $product->getProductsInCart();
            require_once './cart.php';
        }else{
            echo 'Incorrect method';
        }
    }
    private function addProduct($requestMethod, $pdo): void
    {
        if ($requestMethod === 'POST'){
            include './classes/product_class.php';
            $product = new ProductService();
            $result = $product->addProductToCart($pdo, $_POST["product_id"], $_POST["amount"]);
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