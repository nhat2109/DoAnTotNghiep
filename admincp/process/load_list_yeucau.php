<?php
$phien = addslashes(strip_tags($_REQUEST['phien']));
$thongtin = mysqli_query($conn, "SELECT * FROM chat WHERE phien='$phien' ORDER BY id DESC LIMIT 1");
$r_tt = mysqli_fetch_assoc($thongtin);
$list_yeucau = $class_index->list_yeucau($conn, $user_info['id'], $user_info['bo_phan'], $r_tt['thanh_vien']);
$info = array(
    'ok' => 1,
    'list' => $list_yeucau,
);
echo json_encode($info);
