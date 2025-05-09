<?php
header('Content-Type: application/json');

// API Key của bạn từ Wit.ai
$witApiKey = "V7MZBM2YSI2ADY5VLCML36HUL6JASKCT";

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['text'])) {
    echo json_encode(["error" => "Không có văn bản để xử lý."]);
    exit;
}

// Gửi yêu cầu tới Wit.ai
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.wit.ai/message?v=20230225&q=' . urlencode($data['text']));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $witApiKey
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => "Lỗi khi gửi yêu cầu đến Wit.ai: " . curl_error($ch)]);
} else {
    echo $response;
}

curl_close($ch);
?>
