<?php
// chat.php - acts as a secure proxy for your Gemini API calls

// Your secret API key here (hardcoded server-side only)
$apiKey = 'AIzaSyDaNS63l9P-ASSZ3ky0oqBVAo0KvaqWlyI';

// Read raw POST data from frontend
$requestBody = file_get_contents('php://input');

if (!$requestBody) {
    http_response_code(400);
    echo json_encode(['error' => 'No data received']);
    exit;
}

// Google Gemini API URL with your key
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";

// Initialize cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

// Execute the request
$response = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    http_response_code(500);
    echo json_encode(['error' => $curlError]);
    exit;
}

// Set JSON header and output the response from Google Gemini API
header('Content-Type: application/json');
echo $response;
