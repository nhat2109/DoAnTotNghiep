<?php
$phien = addslashes(strip_tags($_REQUEST['phien']));
$thongtin = mysqli_query($conn, "SELECT * FROM chat WHERE phien='$phien' ORDER BY id ASC LIMIT 1");
$r_tt = mysqli_fetch_assoc($thongtin);
if ($r_tt['bo_phan'] == $user_info['bo_phan'] or $user_info['emin_group'] == 1) {
    mysqli_query($conn, "UPDATE chat SET active='0',doc='1' WHERE phien='$phien'");
    $ok = 1;
    $thongbao = 'Đóng yêu cầu thành công';
} else {
    $ok = 0;
    $thongbao = 'Hành động không được hoàn thành';
}
$info = array(
    'ok' => $ok,
    'phien' => $phien,
    'bo_phan' => $r_tt['bo_phan'],
    'thanh_vien' => $r_tt['thanh_vien'],
    'user_out' => $user_info['id'],
    'thongbao' => $thongbao,
);
echo json_encode($info);
