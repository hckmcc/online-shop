<?php
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$pdo= new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');
include './classes/route_class.php';
$route = new Route($requestUri, $requestMethod);
$route->getPage($pdo);