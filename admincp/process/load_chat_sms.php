<?php
$phien = addslashes(strip_tags($_REQUEST['phien']));
$sms_id = intval($_REQUEST['sms_id']);
$thongtin_cuoi = mysqli_query($conn, "SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id' ORDER BY id DESC LIMIT 1");
$r_c = mysqli_fetch_assoc($thongtin_cuoi);
$thongtin_thanhvien = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_c['thanh_vien']}'");
$r_user = mysqli_fetch_assoc($thongtin_thanhvien);
$tach_chat = json_decode($class_index->list_chat($conn, $user_info['id'], $user_info['name'], $user_info['avatar'], $r_user['name'], $r_user['avatar'], $r_c['user_out'], $phien, $sms_id, 10), true);
$list_yeucau = $class_index->list_yeucau($conn, $user_info['id'], $user_info['bo_phan'], $thanh_vien);
$ho_ten = $r_tt['name'];
$note = $r_tt['tieu_de'];
$info = array(
    'ok' => 1,
    'list_chat' => $tach_chat['list'],
    'list' => $list_yeucau,
    'load_chat' => $tach_chat['load'],
    'ho_ten' => $ho_ten,
    'note' => $note,
    'phien' => $phien,
    'thanh_vien' => $thanh_vien,
    'user_id' => $user_info['id'],
);
echo json_encode($info);
