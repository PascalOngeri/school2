<?php
// Function to send SMS
function sendSms($to, $message) {
    // Your custom SMS gateway logic here
   $url = 'https://sms-service.smsafrica.tech/message/send/transactional';

// Retrieve the latest API key from the database
$selectQuery = "SELECT apikey FROM api ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $selectQuery);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $token = $row['apikey'];
} else {
    echo "Error fetching latest API key from the database.\n";
    exit();
}

// Prepare data for the API request
$postData = json_encode([
    "message" => $,
    "msisdn" => $to,
    "sender_id" => "SMSAFRICA",
    "callback_url" => "https://callback.io/123/dlr"
]);

// Send the SMS using cURL
$httpRequest = curl_init($url);
curl_setopt($httpRequest, CURLOPT_POST, true);
curl_setopt($httpRequest, CURLOPT_POSTFIELDS, $postData);
curl_setopt($httpRequest, CURLOPT_TIMEOUT, 60);
curl_setopt($httpRequest, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($httpRequest, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "api-key: $token"
));

$response = curl_exec($httpRequest);
$httpCode = curl_getinfo($httpRequest, CURLINFO_HTTP_CODE);
curl_close($httpRequest);

// Log the activity
$u = $_SESSION['username'];
$activityMessage = $httpCode == 200 
    ? "Send SMS to $phone_number. Message body: $mess" 
    : "Failed in sending SMS to $phone_number. Message body: $mess";

$query = mysqli_query($con, "INSERT INTO logs(user, activities) VALUES('$u', '$activityMessage')");

// Display the result
if ($httpCode == 200) {
    echo '<div class="popup" style="background-color: green; font-size: 24px; border-radius: 20px;">&#10003; Message sent successfully to ' . $phone_number . '</div>';
} else {
    echo '<div class="popup" style="background-color: red; font-size: 24px; border-radius: 20px;">&#10007; Failed to send message to ' . $phone_number . '</div>';
}
    // Log or handle the response from the SMS gateway as needed
}

// Function to get phone numbers from the database
function getPhoneNumbers() {
    include('dbconnection.php');

    // Query to select phone numbers from the database
    $sql = "SELECT MobileNumber FROM tbladmin";
    $result = $dbh->query($sql);

    $phoneNumbers = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $phoneNumbers[] = $row['MobileNumber'];
    }

    return $phoneNumbers;
}

// Function to get message data from the database
function getMessageData() {
    include('dbconnection.php');

    // Query to select message data from the database
    $sql = "SELECT user, activities,date FROM logs";
    $result = $dbh->query($sql);

    $data = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    return $data;
}

// Check if today is Friday
if (date('N') == 5) {
    $phoneNumbers = getPhoneNumbers();
    $messageData = getMessageData();

    // Create the message from the data
    $message = "Data for this Friday:\n";
    foreach ($messageData as $item) {
        $message .= $item['user'] . ": " . $item['activities']  . $item['date'] . "\n"; // Customize based on your data
    }

    // Send SMS to each phone number
    foreach ($phoneNumbers as $phoneNumber) {
        sendSms($phoneNumber, $message);
    }
}
?>
