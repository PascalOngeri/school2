<?php
$ussd_menu = [
    ["text" => "enter phone number"],
    ["text" => "enter amount"]
];

header('Content-Type: application/json');

$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $command = $input['command'];
    $msisdn = $input['msisdn'];
    $session_id = $input['session_id'];
    $operator = $input['operator'];
    $request_id = $input['payload']['request_id'];
    $response = $input['payload']['response'];

    // generating response to the subscriber
    $request = isset($ussd_menu[$request_id]['text']) ? $ussd_menu[$request_id]['text'] : "";
    if (empty($request)) {
        $request = "default text message";
    }
    $command = ($request_id + 1 === count($ussd_menu)) ? 'terminate' : 'continue';

    // performing tasks based on received command
    if ($command === 'terminate') {
        // Handle terminate session here
    }
    if ($command === 'continue') {
        // Handle continue session here
    }

    // respond with the passed data and other data
    $response_data = [
        "msisdn" => $msisdn,
        "operator" => $operator,
        "session_id" => $session_id,
        "command" => $command,
        "payload" => [
            "request_id" => $request_id,
            "request" => $request
        ]
    ];

    echo json_encode($response_data);
} else {
    echo json_encode(["message" => "Only POST requests are accepted."]);
}