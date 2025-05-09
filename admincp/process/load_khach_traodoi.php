<?php
$thanh_vien = intval($_REQUEST['thanh_vien']);
$thongtin = mysqli_query($conn, "SELECT chat.*,user_info.name FROM chat INNER JOIN user_info ON user_info.user_id=chat.thanh_vien WHERE chat.active='1' AND chat.noi_dung='' AND chat.thanh_vien='$thanh_vien' ORDER BY chat.id DESC LIMIT 1");
$total = mysqli_num_rows($thongtin);
$r_tt = mysqli_fetch_assoc($thongtin);
$thongtin_thanhvien = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['thanh_vien']}'");
$r_user = mysqli_fetch_assoc($thongtin_thanhvien);
$phien = $r_tt['phien'];
$thongtin_cuoi = mysqli_query($conn, "SELECT * FROM chat WHERE phien='$phien' ORDER BY id DESC LIMIT 1");
$r_c = mysqli_fetch_assoc($thongtin_cuoi);
$sms_id = $r_c['id'] + 1;
$tach_chat = json_decode($class_index->list_chat($conn, $user_info['id'], $user_info['name'], $user_info['avatar'], $r_user['name'], $r_user['avatar'], $r_c['user_out'], $phien, $sms_id, 10), true);
$list_yeucau = $class_index->list_yeucau($conn, $user_info['id'], $user_info['bo_phan'], $thanh_vien);
$ho_ten = $r_tt['name'];
$note = $r_tt['tieu_de'];
$info = array(
    'ok' => 1,
    'list_chat' => $tach_chat['list'],
    'list' => $list_yeucau,
    'ho_ten' => $ho_ten,
    'note' => $note,
    'phien' => $phien,
    'thanh_vien' => $thanh_vien,
    'user_id' => $user_info['id'],
);
echo json_encode($info);
