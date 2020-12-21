<?php

require 'vendor/autoload.php';

use ApolloApi\Connection as Connection;
use Dotenv\Dotenv;

if(getenv('APP_ENV') === 'development') {
  $dotenv = new DotEnv(__DIR__);
  $dotenv->load();
}

$connection = Connection::get();
$connection->createTables();
?>
