<?php

namespace ApolloApi;

class Connection {
  private static $conn;

  public function connect() {
    $host = getenv('host');
    $port = getenv('port');
    $db   = getenv('database');
    $user = getenv('user');
    $pass = getenv('password');

    $connection = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
      $host,
      $port,
      $db,
      $user,
      $pass
    );

    $pdo = new \PDO($connection);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    return $pdo;
  }

  public static function get() {
    if (null === static::$conn) {
      static::$conn = new static();
    }

    return static::$conn;
  }

  public function createTables() {
    $productTable = "CREATE TABLE IF NOT EXISTS products (
      id SERIAL PRIMARY KEY,
      name CHARACTER VARYING(100) NOT NULL,
      description CHARACTER VARYING(100) NOT NULL,
      price INT DEFAULT NULL,
      image CHARACTER VARYING(1000) NOT NULL
    );";

    $orderTable = "CREATE TABLE IF NOT EXISTS orders (
      id SERIAL PRIMARY KEY,
      reference CHARACTER VARYING(100) NOT NULL,
      products JSONB,
      price INT DEFAULT NULL,
      email CHARACTER VARYING(100) NOT NULL,
      name CHARACTER VARYING(100) NOT NULL,
      phone CHARACTER VARYING(100) NOT NULL
    );";

    $sqlList = [$productTable, $orderTable];

    foreach ($sqlList as $sql) {
      Connection::get()->connect()->exec($sql);
    }
    return $this;
  }
}
?>
