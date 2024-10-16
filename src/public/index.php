<?php
require_once '../Core/Autoload.php';
use Core\App;
use Core\Autoload;

Autoload::register(dirname(__DIR__,1));

$app = new App();
$app->run();