<?php
header('Content-Type: application/json; charset=utf-8');

if (!isset($_COOKIE['emin_id'])) {
    echo json_encode(['success' => false]);
    exit;
}

$user_socdo_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$status = isset($_POST['status']) ? addslashes(strip_tags($_POST['status'])) : '';

if (!$user_socdo_id || !in_array($status, ['1', '2', '3'])) {
    echo json_encode(['success' => false]);
    exit;
}

$update = mysqli_query($conn, "UPDATE user_info SET status_cre = '$status' WHERE user_id = $user_socdo_id");

echo json_encode(['success' => (bool)$update]);
exit;
?>