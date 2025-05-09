<?php
header('Content-Type: application/json; charset=utf-8');

try {
    $customer_id = (int) $_POST['customer_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (!in_array($status, ['1', '2', '3'])) {
        echo json_encode(['success' => false]);
        exit;
    }

    $update = mysqli_query($conn, "UPDATE user_info SET status_cre = '$status' 
        WHERE user_id = $customer_id");

    echo json_encode(['success' => (bool)$update]);
} catch (Exception $e) {
    echo json_encode(['success' => false]);
}
exit;
?>