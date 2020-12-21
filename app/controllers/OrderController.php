<?php
namespace ApolloApi\controllers;

use ApolloApi\models\Order;
use ApolloApi\helpers\Response;
use ApolloApi\helpers\Paystack;

class OrderController {
  private $db;
  private $requestMethod;
  private $order;

  public function __construct($db, $requestMethod) {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->order = new Order($db);
  }

  public function processRequest() {
    switch ($this->requestMethod) {
      case 'POST':
        $response = $this->createOrder();
        break;
      default:
        // $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
        break;
    }
    header($response['status_code_header']);
    $responseData = new Response(
      $response['body'],
      $response['message']
    );
    echo json_encode($responseData);
  }

  private function createOrder() {
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    if (!$this->validateFields($input)) {
      return $this->unprocessableEntityResponse();
    }
    $makePayment = Paystack::initiatePayment($input['email'], $input['price']);
    $makePayment = json_decode($makePayment);

    if ($makePayment && $makePayment->status === true) {
      $input['reference'] = $makePayment->data->reference;
      $result = $this->order->create($input);
      $response['status_code'] = 201;
      $response['message'] = 'order created successfully';
      $response['status_code_header'] = 'HTTP/1.1 201 Created';
      $response['body'] = $input;
      $submitOtp = Paystack::submitOtp($input['reference']);
      $submitPhone = Paystack::submitPhone($input['reference']);
    } else {
      $response['message'] = 'error creating order';
      $response['body'] = null;
      $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
    }
    return $response;
  }

  private function notFoundResponse() {
    $response['message'] = "No resource found here";
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }

  private function validateFields($input) {
    if (!isset($input['products'])) {
      return false;
    }
    if (!isset($input['price'])) {
      return false;
    }
    if (!isset($input['phone'])) {
      return false;
    }
    return true;
  }

  private function unprocessableEntityResponse() {
    $response['message'] = 'Invalid input';
    $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
    $response['body'] = json_encode([
      'error' => 'Invalid input'
    ]);
    return $response;
  }
}
?>
