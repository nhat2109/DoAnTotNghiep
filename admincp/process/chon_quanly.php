<?php
$quanly = intval($_REQUEST['quanly']);
$user_id = intval($_REQUEST['user_id']);
$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$user_id'");
$r_tt = mysqli_fetch_assoc($thongtin);
if ($r_tt['aff'] > 0) {
    $ok = 0;
    $thongbao = 'Thất bại! Thành viên này đã có quản lý';
} else {
    $thongtin_quanly = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$quanly'");
    $r_ql = mysqli_fetch_assoc($thongtin_quanly);
    $ok = 1;
    $thongbao = 'Cập nhật quản lý thành công';
    mysqli_query($conn, "UPDATE user_info SET aff='$quanly' WHERE user_id='$user_id'");
}
$info = array(
    'thongbao' => $thongbao,
    'ho_ten' => $r_ql['name'],
    'ok' => $ok
);
echo json_encode($info);
