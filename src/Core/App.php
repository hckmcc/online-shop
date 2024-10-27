<?php

namespace Core;
use Request\Request;
use Service\Logger\LoggerServiceInterface;

class App
{
    private LoggerServiceInterface $loggerService;
    private array $routes = [];
    public function __construct(LoggerServiceInterface $loggerService)
    {
        $this->loggerService = $loggerService;
    }
    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($requestUri, $this->routes)) {
            if (array_key_exists($requestMethod, $this->routes[$requestUri])) {
                $className = $this->routes[$requestUri][$requestMethod]['class'];
                $class = new $className($this->routes[$requestUri][$requestMethod]['properties']);
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
                    $this->loggerService->addErrorToLog('An error occurred',
                        ['Message'=>$e->getMessage(),
                        'File'=>$e->getFile(),
                        'Line'=>$e->getLine(),
                        ]
                    );
                    http_response_code(500);
                }

            } else {
                http_response_code(405);
            }
        } else {
            http_response_code(404);
        }
    }
    public function addRoute(string $routeUri, string $routeMethod, string $class, string $classMethod, array $properties, string $requestClass=null): void
    {
        $this->routes[$routeUri][$routeMethod]['class']=$class;
        $this->routes[$routeUri][$routeMethod]['method']=$classMethod;
        $this->routes[$routeUri][$routeMethod]['properties']=$properties;
        $this->routes[$routeUri][$routeMethod]['request']=$requestClass;
    }
}