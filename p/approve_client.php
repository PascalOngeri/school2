<?php
session_start();
   $servername = "localhost";
$username = "vpbgvvdz_simon";
$password = "40702314Simon?";
$dbname = "vpbgvvdz_pay";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}// Replace with your database connection details
else{

if (isset($_GET['id'])) {
    $clientId = $_GET['id'];

    // Update 'verified' status to 1 in the database for the specified client ID
    $updateSql = "UPDATE user SET very = 1 WHERE id = ?";
    $stmt = $con->prepare($updateSql);
    $stmt->bind_param("i", $clientId);
    $stmt->execute();

    // Redirect back to admin dashboard after updating
    header("Location: adminhome.php");
    exit();
} else {
    // Handle error if client ID is not provided
    echo "Client ID not provided.";
    exit();
}

}
?>


