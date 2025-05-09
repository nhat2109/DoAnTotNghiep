<?php
$search = isset($_POST['input_search_ncc']) ? trim($_POST['input_search_ncc']) : '';
$status = isset($_POST['status_filter']) ? (int)$_POST['status_filter'] : '';
$date_from = isset($_POST['date_from']) ? $_POST['date_from'] : '';
$date_to = isset($_POST['date_to']) ? $_POST['date_to'] : '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 20; // Số đơn hàng mỗi trang

$list = $class_index->list_donhang_ncc($conn,$user_id, $search,$status,$date_from,$date_to,$page,$limit);
$info = array(
    'ok' => 1,
    'list' => $list ,
);
echo json_encode($info);
?>