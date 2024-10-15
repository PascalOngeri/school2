<?php
// URL ya API
$apiurl = "https://infinityschools.xyz/p/api.php";

// Data ya usajili
$data = array(
    "publicApi" => "ISpublic_Api_Keysitq2v5mutip95ra.shabanet", // partner id
    "Token" => "ISSecrete_Token_Keya8x3xi4z32959rt1.shabanet",
    "Phone" => "0757563475", // message
     "username" => "Pascal Ongeri", // message simon shaban
      "password" => "2222",  // message
    "Amount" => "1" // phone 
);

// Badilisha data kuwa JSON
$data_json = json_encode($data);




// Anzisha cURL session
$ch = curl_init($apiurl);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

// Tuma ombi
$response = curl_exec($ch);

// Angalia makosa
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Onyesha majibu kutoka kwa server
    echo $response;
}

// Funga cURL session
curl_close($ch);
?>
