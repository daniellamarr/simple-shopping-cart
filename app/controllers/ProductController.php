<?php
namespace ApolloApi\controllers;

use ApolloApi\models\Product;
use ApolloApi\helpers\Response;

class ProductController {
  private $db;
  private $requestMethod;
  private $product;

  public function __construct($db, $requestMethod) {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->product = new Product($db);
  }

  public function processRequest() {
    switch ($this->requestMethod) {
      case 'GET':
        $response = $this->getAllProducts();
        break;
      default:
        $response = $this->notFoundResponse();
        break;
    }
    header($response['status_code_header']);
    $responseData = new Response(
      $response['body'],
      $response['message']
    );
    echo json_encode($responseData);
  }

  private function getAllProducts() {
    $result = $this->product->findAll();
    $response['status_code'] = 200;
    $response['message'] = 'products returned successfully';
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = $result;
    return $response;
  }

  private function notFoundResponse() {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }
}
?>
