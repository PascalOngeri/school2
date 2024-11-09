<?php
require __DIR__ . '/../vendor/autoload.php';  // Correct relative path from includes to vendor

// Load the .env file from the root and includes directories
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');  // Load root .env file
$dotenv->load();

$dotenvIncludes = Dotenv\Dotenv::createImmutable(__DIR__);  // Load .env from includes directory
$dotenvIncludes->load();

// Create the database connection using the loaded environment variables
try {
    $dbh = new PDO(
        "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
    );
    echo "Connected successfully!";
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
?>

