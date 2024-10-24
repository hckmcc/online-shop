<?php

namespace Core;
use Request\Request;
use Service\LoggerService;

class App
{
    private array $routes = [];
    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($requestUri, $this->routes)) {
            if (array_key_exists($requestMethod, $this->routes[$requestUri])) {
                $class = new $this->routes[$requestUri][$requestMethod]['class'];
                $method = $this->routes[$requestUri][$requestMethod]['method'];
                $requestClass = $this->routes[$requestUri][$requestMethod]['request'];
                if (!empty($requestClass)){
                    $request = new $requestClass($requestUri, $requestMethod, $_POST);
                }else{
                    $request = new Request($requestUri, $requestMethod);
                }
                try {
                    $class->$method($request);
                } catch (\Throwable $e) {
                    LoggerService::addErrorToLog($e);
                    http_response_code(500);
                }

            } else {
                http_response_code(405);
            }
        } else {
            http_response_code(404);
        }
    }
    public function addRoute(string $routeUri, string $routeMethod, string $class, string $classMethod, string $requestClass=null): void
    {
        $this->routes[$routeUri][$routeMethod]['class']=$class;
        $this->routes[$routeUri][$routeMethod]['method']=$classMethod;
        $this->routes[$routeUri][$routeMethod]['request']=$requestClass;
    }
}