<?php

$id = intval($_REQUEST['id']);
mysqli_query($conn, "UPDATE giao_viec SET xac_nhan='0' WHERE id='$id'");
$info = array(
    'ok' => 1,
    'thongbao' => 'Đã phê duyệt',
);
echo json_encode($info);