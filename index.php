<?php
require "bootstrap.php";

use ApolloApi\controllers\ProductController;
use ApolloApi\controllers\OrderController;

header("Referrer-Policy: no-referrer");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: *");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($uri[1]) {
  case 'products':
    $controller = new ProductController($connection->connect(), $requestMethod);
    $controller->processRequest();
    break;
  case 'orders':
    $controller = new OrderController($connection->connect(), $requestMethod);
    $controller->processRequest();
    break;
  default:
    echo 'Welcome to apollo11 api';
    break;
}
?>
