<?php
$key = addslashes(strip_tags($_REQUEST['key']));

$list = $class_index->list_kq_timkiem_thanhviennhom($conn, 1, 10, $key, $user_id);

$list = '<tr>
        <th style="text-align: center;width: 50px;" class="hide_mobile">ID</th>
        <th style="text-align: left;">Họ và tên</th>
        <th style="text-align: left;">Điện thoại</th>
        <th style="text-align: center;">Vai trò</th>
        <th style="text-align: center;">Tổng đơn hàng</th>
        <th style="text-align: center;">Tổng doanh số</th>
        <th style="text-align: center;width: 150px;">Hành động</th>
        <th style="text-align: center;">Tình trạng</th>
    </tr>' . $list;

// Trả kết quả dưới dạng JSON
echo json_encode([
    'ok' => 1,
    'list' => $list
]);
?>
