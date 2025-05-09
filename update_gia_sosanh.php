<?php
include './includes/tlca_world.php';
include_once "./class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes(strip_tags($_REQUEST['action']));
$class_index = $tlca_do->load('class_index');
$class_member = $tlca_do->load('class_member');
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
$thongtin = mysqli_query($conn, "SELECT * FROM sanpham ORDER BY id DESC");
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
	$gia_drop = intval(preg_replace('/[^0-9]/', '', $r_tt['gia_drop']));
	if ($r_tt['kho'] == 0) {
		mysqli_query($conn, "UPDATE sanpham SET gia_moi='$gia_drop' WHERE id='{$r_tt['id']}'");
		echo 'Đã cập nhật giá "' . $r_tt['tieu_de'] . '" từ ' . number_format($r_tt['gia_moi']) . ' thành ' . number_format($gia_drop) . '<br>';
	}
}
?>