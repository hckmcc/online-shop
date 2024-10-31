<?php

namespace Core;
use Request\Request;
use Service\Logger\LoggerServiceInterface;

class App
{
    private array $routes = [];
    private Container $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    public function run(): void
    {
        $requestUri = $this->getRequestURI();
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($requestUri, $this->routes)) {
            if (array_key_exists($requestMethod, $this->routes[$requestUri])) {
                $class = $this->routes[$requestUri][$requestMethod]['class'];
                $object = $this->container->get($class);
                $method = $this->routes[$requestUri][$requestMethod]['method'];
                $requestClass = $this->routes[$requestUri][$requestMethod]['request'];
                if (!empty($requestClass)){
                    if($requestMethod === 'POST'){
                        $request = new $requestClass($requestUri, $requestMethod, $_POST);
                    }elseif ($requestMethod === 'GET'){
                        $request = new $requestClass($requestUri, $requestMethod, $_GET);
                    }else{
                        $request = new Request($requestUri, $requestMethod);
                    }
                }else{
                    $request = new Request($requestUri, $requestMethod);
                }
                try {
                    $object->$method($request);
                } catch (\Throwable $e) {
                    $this->container->get(LoggerServiceInterface::class)->addErrorToLog('An error occurred',
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
    public function addRoute(string $routeUri, string $routeMethod, string $class, string $classMethod, string $requestClass=null): void
    {
        $this->routes[$routeUri][$routeMethod]['class']=$class;
        $this->routes[$routeUri][$routeMethod]['method']=$classMethod;
        $this->routes[$routeUri][$routeMethod]['request']=$requestClass;
    }
    private function getRequestURI(): string
    {
        $requestUri = strstr($_SERVER['REQUEST_URI'],'?',true);
        if(!$requestUri){
            $requestUri = $_SERVER['REQUEST_URI'];
        }
        return $requestUri;
    }
}