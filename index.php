<?php

$_apis = __DIR__.'/api.json';
$_api = file_get_contents($_apis);
$apiData = json_decode($_api, true);

$message = $_GET['message'];
$channel = $_GET['channel'];

$data = [
    'content' => $message,
];
$jsonData = json_encode($data);

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => $jsonData,
    ],
];

$context = stream_context_create($options);
$result = file_get_contents($apiData[$channel], false, $context);

header('Content-Type: application/json'); // Move this line here

if ($result === false) {
    echo json_encode(["status" => "error", "message" => "Failed to send webhook"]);
} else {
    echo json_encode(["status" => "success", "message" => "Webhook sent successfully"]);
}
