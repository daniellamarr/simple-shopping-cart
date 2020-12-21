<?php

namespace ApolloApi\helpers;

class Response {
  public $data;
  public $message;

  public function __construct($data, $message) {
    $this->data = $data;
    $this->message = $message;
  }
}
?>