<?php
require_once '../../includes/config.php';
$conn = $GLOBALS['conn'];
$action = $_POST['action'] ?? '';
$id = intval($_POST['id'] ?? 0);

if ($action == 'duyet') {
    $q = mysqli_query($conn, "UPDATE product_reviews SET status=1 WHERE id='$id'");
    echo json_encode(['success'=>true, 'message'=>'Đã duyệt đánh giá!']);
    exit;
}
if ($action == 'an') {
    $q = mysqli_query($conn, "UPDATE product_reviews SET status=0 WHERE id='$id'");
    echo json_encode(['success'=>true, 'message'=>'Đã ẩn đánh giá!']);
    exit;
}
if ($action == 'xoa') {
    $q = mysqli_query($conn, "DELETE FROM product_reviews WHERE id='$id'");
    echo json_encode(['success'=>true, 'message'=>'Đã xóa đánh giá!']);
    exit;
}
echo json_encode(['success'=>false, 'message'=>'Yêu cầu không hợp lệ']); 