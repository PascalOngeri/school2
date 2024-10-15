<?php
// Start output buffering to prevent issues with headers
ob_start();

// Set default timezone and error reporting
date_default_timezone_set("Etc/GMT+8");
error_reporting(0);


// Database Credentials
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

// Start session
session_start();

// Redirect if user not logged in
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

// Prepare the database query for another user
$u = "2";
$sd = "SELECT * FROM user WHERE id = ?";
$stmt = $con->prepare($sd);
$stmt->bind_param("i", $u);
$stmt->execute();
$result = $stmt->get_result();
$de = $result->fetch_assoc();

// Handle form submission
if (isset($_POST['login'])) {
    $phone_number = $_POST['phone'];
    $amount = $_POST['amount'];
    
    $base_url = "https://lipia-api.kreativelabske.com/api";
    $endpoint = "/request/stk";
    $api_key = $de['devapi']; // Replace with your actual API key

    // Data to be sent in JSON format
    $data = [
        "phone" => $phone_number,
        "amount" => $amount
    ];

    // Encode the data to JSON
    $json_data = json_encode($data);

    // Initialize cURL session
    $ch = curl_init();
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
    if (curl_errno($ch)) {
        echo 'An Error has occurred: ' . curl_error($ch);
    } else {
        curl_close($ch);
        $decoded_response = json_decode($response, true);
        if (isset($decoded_response['message']) && $decoded_response['message'] === 'callback received successfully') {
            $amount = $decoded_response['data']['amount'];
            $phone = $decoded_response['data']['phone'];
            $reference = $decoded_response['data']['refference']; // Check this spelling
            $_SESSION["ref"] = $reference;

            try {
                $pdo = new PDO('mysql:host=localhost;dbname=vpbgvvdz_pay', 'vpbgvvdz_simon', '40702314Simon?');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Insert into till table
                $stmt = $pdo->prepare('INSERT INTO till (phone_number, amount, reference, acc, status) VALUES (:phone, :amount, :reference, :id, :status)');
                $stmt->execute([
                    'phone' => $phone,
                    'amount' => $amount,
                    'reference' => $reference,
                    'id' => $user_id,
                    'status' => "Subscription fee"
                ]);

                // Update subscription status
                $d = "1";
                $query = $pdo->prepare("UPDATE user SET subscription = :sub WHERE idno = :ido");
                $query->execute([
                    'sub' => $d,
                    'ido' => $user_id
                ]);

                echo '<script>alert("Registration successful. Login to proceed!")</script>';
                echo "<script>window.location.href='index.php'</script>";

            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            $class = 'alert-error';
            $message = 'Payment Cancelled';
        }
    }
    ob_end_flush(); // Send the buffered output
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shabanet banking system</title>
    <link href="css/all.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
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
                            <?php if (isset($class) && isset($message)): ?>
                                <div class="alert <?php echo $class; ?> shadow-lg max-w-sm" id="statusAlert" style="width:400px!important;">
                                    <div>
                                        <span><?php echo $message; ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </span>
                        <h1 class="h4 text-gray-900 mb-4">Pay subscription fee</h1>
                    </div>
                    <form method="POST" class="user" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <h4 class="h4 text-gray-900 mb-4">Amount</h4>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="amount" value="500" required readonly="true">
                        </div>
                        <br>
                        <h4 class="h4 text-gray-900 mb-4">Phone number to complete payment</h4>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="phone" placeholder="Enter phone number here to complete payment..." required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block" name="login">PAY</button>
                        <br>
                    </form>
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
