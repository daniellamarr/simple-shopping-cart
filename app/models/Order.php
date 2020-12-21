<?php

namespace ApolloApi\models;

class Order {
  private $db = null;

  public function __construct($db) {
    $this->db = $db;
  }

  public function findAll() {
    $query = "SELECT * FROM orders";

    try {
      $fetch = $this->db->query($query);
      $result = $fetch->fetchAll(\PDO::FETCH_ASSOC);
      return $result;
    } catch (\PDO_EXCEPTION $e) {
      exit($e->getMessage());
    }
  }

  public function create(Array $input) {
    $query = "INSERT INTO orders
      (reference, products, price, email, name, phone) VALUES
      (:reference, :products, :price, :email, :name, :phone);";

    try {
      $insert = $this->db->prepare($query);
      $insert->execute(array(
        'reference' => $input['reference'],
        'products' => json_encode($input['products']),
        'price' => $input['price'],
        'email' => $input['email'],
        'name' => $input['name'],
        'phone' => $input['phone'],
      ));
      return $insert->rowCount();
    } catch (\PDO_EXCEPTION $e) {
      exit($e->getMessage());
    }
  }
}

?>