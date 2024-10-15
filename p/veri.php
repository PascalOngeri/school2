<?php
date_default_timezone_set("Etc/GMT+8");
error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "localhost";
$username = "vpbgvvdz_simon";
$password = "40702314Simon?";
$dbname = "vpbgvvdz_pay";

// Create Connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['id'];
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


$u="2";
$sd = "SELECT * FROM user WHERE id = ?";
$stmt = $con->prepare($sd);
$stmt->bind_param("i",$u );
$stmt->execute();
$result = $stmt->get_result();
$de = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shabanet banking</title>
    <link href="css/all.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
     <style>
        .custom-h1 {
            color: #FF5733; /* Change the color as per your preference */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Shabanet Online Banking System</a>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="p-5">
                    <div class="text-center">
                        <span>
        <?php
       if (isset($_POST['login'])) {
  $phone_number = $_POST['phone'];
  $amount = $_POST['amount'];
 

  $base_url = "https://lipia-api.kreativelabske.com/api";
$endpoint = "/request/stk";
$api_key = $de['devapi']; // Replace with your actual API key

// Data to be sent in JSON format
$data = [
    "phone" =>  $phone_number,
    "amount" => $amount
];

// Encode the data to JSON
$json_data = json_encode($data);

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $base_url . $endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
]);

// Execute cURL session
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    // Handle the error as per your requirement (e.g., log it, notify someone)
} else {
    // Close cURL session
    curl_close($ch);

    // Decode the response JSON
    $decoded_response = json_decode($response, true);

    // Check if the response indicates success or failure
    if (isset($decoded_response['message']) && $decoded_response['message'] === 'callback received successfully') {
        // Extract data to be inserted into the database
        $amount = $decoded_response['data']['amount'];
        $phone = $decoded_response['data']['phone'];
        $reference = $decoded_response['data']['refference']; // Note: 'refference' might be a typo, should it be 'reference'?
  $_SESSION["ref"]= $reference;
        // Now, insert this data into your database
        // Example assuming you are using PDO for database operations
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=shabanetbank', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare SQL statement
            $stmt = $pdo->prepare('INSERT INTO till (phone_number, amount, reference,acc,status) VALUES (:phone, :amount, :reference,:id,:status)');
            $stmt->execute(array(
                'phone' => $phone,
                'amount' => $amount,
                'reference' => $reference,
                 'id' => $user_id,
                  'status' => "Subscription fee"

            ));

           
                                  $d="1";
             $query = $pdo->prepare("UPDATE user SET subscription = :sub WHERE idno = :ido");
            $query->execute(array(
                'sub' => $d,
                'ido' => $user_id
        

            ));


 if ($stmt->execute()) {
                   // echo "SMS sent successfully!";
                     echo '<script>alert("Registration succsessfull login to proceed!")</script>';

        echo "<script>window.location.href='index.php'</script>";
                } else {
                   // echo "Error updating units: " . $stmt->error;
                    echo '<script>alert("Payment cancelled bt user ")</script>';
        echo "<script>window.location.href='pay.php'</script>";
                }
           $class = 'alert-success';
            $message = 'Payment Successful';
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {

        // $decoded_response = json_decode($response, true);
         
         $class = 'alert-error';
            $message = 'Payment Cancelled';
    }

}




 

     
         
      
        ?>
          <div class="alert <?php echo $class; ?> shadow-lg max-w-sm" id="statusAlert" style="width:400px!important;">
            <div>
              <span><?php echo $message; ?></span>
            
            
            </div>
          </div>
        <?php } ?>

      </span> <img src="path/to/your/gif.gif" alt="Your GIF" style="width: 100px; height: auto;">
                        <h1 class="h4 text-gray-900 mb-4">hii <?php echo ($user['username']); ?> Your Acount is still pending , it has not been verified this should not take more than a working day </h1>
                    </div>
                   
                    <br>
                    <center><a href="index.php" style="color: red">Back?</a></center>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <span style="color:#ffffff;">&copy; Copyright Shabanet Technologies</span>
        <span style="color:#ffffff;">All Rights Reserved <?php echo date("Y")?></span>
    </nav>
</body>
</html>
