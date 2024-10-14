<?php
require_once '../Controller/UserController.php';
require_once '../Controller/ProductController.php';
require_once '../Controller/OrderController.php';
class App
{
    private array $routes=[
        '/login'=>[
            'GET'=>[
                'object'=>'UserService',
                'method'=>'getLoginPage'
            ],
            'POST'=>[
                'object'=>'UserService',
                'method'=>'login'
            ]
        ],
        '/register'=>[
            'GET'=>[
                'object'=>'UserService',
                'method'=>'getRegistrationPage'
            ],
            'POST'=>[
                'object'=>'UserService',
                'method'=>'register'
            ]
        ],
        '/catalog'=>[
            'GET'=>[
                'object'=>'ProductService',
                'method'=>'getProductsInCatalog'
            ]
        ],
        '/cart'=>[
            'GET'=>[
                'object'=>'ProductService',
                'method'=>'getProductsInCart'
            ]
        ],
        '/add_product'=>[
            'POST'=>[
                'object'=>'ProductService',
                'method'=>'addProductToCart'
            ]
        ],
        '/delete_product'=>[
            'POST'=>[
                'object'=>'ProductService',
                'method'=>'deleteProductFromCart'
            ]
        ],
        '/order'=>[
            'GET'=>[
                'object'=>'OrderService',
                'method'=>'getOrderPage'
            ],
            'POST'=>[
                'object'=>'OrderService',
                'method'=>'createOrder'
            ]
        ],
        '/my_orders'=>[
            'GET'=>[
                'object'=>'OrderService',
                'method'=>'getUserOrderList'
            ]
        ]
    ];
    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if(array_key_exists($requestUri, $this->routes)) {
            if(array_key_exists($requestMethod, $this->routes[$requestUri])) {
                $object = new $this->routes[$requestUri][$requestMethod]['object'];
                $objectMethod = $this->routes[$requestUri][$requestMethod]['method'];
                $object->$objectMethod();
            }else{
                http_response_code(405);
            }
        }else{
            http_response_code(404);
        }
    }
}