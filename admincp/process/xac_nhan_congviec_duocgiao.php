<?php
$id = intval($_REQUEST['id']);
mysqli_query($conn, "UPDATE giao_viec SET status = '1' WHERE id = '$id'");
$thongbao = 'Xác nhận công việc thành công';
$ok = 1;
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);