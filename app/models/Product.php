<?php

namespace ApolloApi\models;

class Product {
  private $db = null;

  public function __construct($db) {
    $this->db = $db;
  }

  public function findAll() {
    $query = "SELECT * FROM products";

    try {
      $fetch = $this->db->query($query);
      $result = $fetch->fetchAll(\PDO::FETCH_ASSOC);
      return $result;
    } catch (\PDO_EXCEPTION $e) {
      exit($e->getMessage());
    }
  }
}

?>