<?php
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
include '../Controller/RouteController.php';
$route = new Route($requestUri, $requestMethod);
$route->getPage();