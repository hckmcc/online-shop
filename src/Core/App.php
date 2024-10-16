<?php

namespace Core;
class App
{
    private array $routes = [
        '/login' => [
            'GET' => [
                'object' => 'Controller\UserController',
                'method' => 'getLoginPage'
            ],
            'POST' => [
                'object' => 'Controller\UserController',
                'method' => 'login'
            ]
        ],
        '/logout' => [
            'GET' => [
                'object' => 'Controller\UserController',
                'method' => 'logout'
            ]
        ],
        '/register' => [
            'GET' => [
                'object' => 'Controller\UserController',
                'method' => 'getRegistrationPage'
            ],
            'POST' => [
                'object' => 'Controller\UserController',
                'method' => 'register'
            ]
        ],
        '/catalog' => [
            'GET' => [
                'object' => 'Controller\ProductController',
                'method' => 'getProductsInCatalog'
            ]
        ],
        '/cart' => [
            'GET' => [
                'object' => 'Controller\ProductController',
                'method' => 'getProductsInCart'
            ]
        ],
        '/add_product' => [
            'POST' => [
                'object' => 'Controller\ProductController',
                'method' => 'addProductToCart'
            ]
        ],
        '/delete_product' => [
            'POST' => [
                'object' => 'Controller\ProductController',
                'method' => 'deleteProductFromCart'
            ]
        ],
        '/order' => [
            'GET' => [
                'object' => 'Controller\OrderController',
                'method' => 'getOrderPage'
            ],
            'POST' => [
                'object' => 'Controller\OrderController',
                'method' => 'createOrder'
            ]
        ],
        '/my_orders' => [
            'GET' => [
                'object' => 'Controller\OrderController',
                'method' => 'getUserOrderList'
            ]
        ]
    ];

    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($requestUri, $this->routes)) {
            if (array_key_exists($requestMethod, $this->routes[$requestUri])) {
                $object = new $this->routes[$requestUri][$requestMethod]['object'];
                $objectMethod = $this->routes[$requestUri][$requestMethod]['method'];
                $object->$objectMethod();
            } else {
                http_response_code(405);
            }
        } else {
            http_response_code(404);
        }
    }
}