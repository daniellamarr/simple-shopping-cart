<?php
require 'bootstrap.php';

$query = "INSERT INTO products
    (id, name, description, price, image)
    VALUES
    (1, 'Nike Air Max 720', 'A nice shoe', 8000, 'https://images.pexels.com/photos/2529148/pexels-photo-2529148.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500'),
    (2, 'Nike Air Force', 'A nice shoe', 12000, 'https://images.pexels.com/photos/1698359/pexels-photo-1698359.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500'),
    (3, 'Kind is the new cool', 'A nice shoe', 4000, 'https://images.pexels.com/photos/2205839/pexels-photo-2205839.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500'),
    (4, 'Summer Shirt', 'A nice shoe', 10000, 'https://images.pexels.com/photos/3854982/pexels-photo-3854982.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500'),
    (5, 'All Star Converse', 'A nice shoe', 20000, 'https://images.pexels.com/photos/3622624/pexels-photo-3622624.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=500')";

try {
  $runSeed = $connection->connect()->exec($query);
  echo "Success!\n";
} catch (\PDOException $e) {
  exit($e->getMessage());
}
?>
