<?php
require 'vendor/autoload.php';

// Specify the path to the .env file in the includes directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/includes');
$dotenv->load();

$con = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

if (mysqli_connect_errno()) {
    echo "Connection Fail: " . mysqli_connect_error();
}
?>

