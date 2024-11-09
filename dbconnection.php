<?php
require __DIR__ . '/vendor/autoload.php';  // Correct relative path to autoload.php in the root directory

// Load the .env file from the root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);  // Loads .env from the root directory
$dotenv->load();

// Debugging: Check if environment variables are loaded correctly (you can remove these later)
echo 'DB_HOST: ' . $_ENV['DB_HOST'] . '<br>';
echo 'DB_USER: ' . $_ENV['DB_USER'] . '<br>';
echo 'DB_PASS: ' . $_ENV['DB_PASS'] . '<br>';
echo 'DB_NAME: ' . $_ENV['DB_NAME'] . '<br>';

// Create the database connection using the loaded environment variables
$con = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

// Check for connection errors
if (mysqli_connect_errno()) {
    echo "Connection failed: " . mysqli_connect_error();
    exit();  // Exit if connection fails
} else {
    echo "Connected successfully!";
}
?>

