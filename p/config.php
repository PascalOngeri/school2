
<?php
// config.php
$host = 'localhost';
$dbname = 'vpbgvvdz_pay';
$user = 'vpbgvvdz_simon';
$password = '40702314Simon?';

$con = new mysqli($host, $user, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
