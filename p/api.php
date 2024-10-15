<?php
header('Content-Type: application/json');
session_start(); // Start the session

// Database connection parameters
$servername = "localhost";
$username = "vpbgvvdz_simon";
$password = "40702314Simon?";
$dbname = "vpbgvvdz_pay";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $con->connect_error]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['publicApi'], $data['Token'], $data['username'], $data['password'], $data['Phone'], $data['Amount'])) {
        echo json_encode(['error' => 'Invalid input']);
        exit();
    }

    $public = $data['publicApi'];
    $token = $data['Token'];
    $username = $data['username'];
    $password = $data['password'];
    $phone = $data['Phone'];
    $amount = $data['Amount'];

    // Prepare the SQL query to avoid SQL injection
    $stmt = $con->prepare("SELECT id, subscription, token, publicapi, devapi, password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $subscription, $stored_token, $stored_publicapi, $stored_devapi, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    if ($hashed_password && password_verify($password, $hashed_password)) {
        if ($subscription == 0) {
            echo json_encode(['error' => 'Verify account by paying subscription fee']);
            exit();
        } elseif ($subscription == 1) {
            if ($token == $stored_token) {
                if ($public == $stored_publicapi) {
                    $base_url = "https://lipia-api.kreativelabske.com/api";
                    $endpoint = "/request/stk";
                    $api_key = $stored_devapi;

                    $data = [
                        "phone" => $phone,
                        "amount" => $amount
                    ];

                    $json_data = json_encode($data);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $base_url . $endpoint);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $api_key
                    ]);

                    $response = curl_exec($ch);

                    if (curl_errno($ch)) {
                        echo json_encode(['error' => 'You are offline']);
                        curl_close($ch);
                        exit();
                    }

                    curl_close($ch);
                    $decoded_response = json_decode($response, true);

                    if (isset($decoded_response['message']) && $decoded_response['message'] === 'callback received successfully') {
                        $amount = $decoded_response['data']['amount'];
                        $phone = $decoded_response['data']['phone'];
                        $reference = $decoded_response['data']['refference'];
                        $_SESSION["ref"] = $reference;

                        try {
                            $servername = "localhost";
$username = "vpbgvvdz_simon";
$password = "40702314Simon?";
$dbname = "vpbgvvdz_pay";
                            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $pdo->prepare('INSERT INTO till (phone_number, amount, reference, acc, status) VALUES (:phone, :amount, :reference, :id, :status)');
                            $stmt->execute([
                                'phone' => $phone,
                                'amount' => $amount,
                                'reference' => $reference,
                                'id' => $user_id,
                                'status' => "COMPLETED"
                            ]);

                            echo 'success: Payment received Successful from '.$phone.' amount '.$amount.' Reference '.$reference;
                        } catch (PDOException $e) {
                            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
                        }
                    } else {
                       echo 'error: Payment Cancelled by user  ';
                    }
                } else {
                    echo 'error: invalid public api  ';
                }
            } else {
                echo 'error: invalid token  ';
            }
        }
    } else {
       echo 'error: invalid username or password  ';
    }
}

$con->close();
?>
