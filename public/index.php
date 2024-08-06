<?php

use App\Core\Router;

require_once __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set("America/Sao_Paulo");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE, GET, POST, PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

new Router;