<?php
include('./includes/tlca_world.php');
include_once("./class.phpmailer.php");
$check=$tlca_do->load('class_check');
$action=addslashes($_REQUEST['action']);
$class_index=$tlca_do->load('class_index');
$class_member=$tlca_do->load('class_member');
$thongtin_nhom=mysqli_query($conn,"SELECT * FROM nhom ORDER BY id ASC");
while($r_tt=mysqli_fetch_assoc($thongtin_nhom)){
	$tach_thanhvien=explode(',', $r_tt['thanhvien']);
	foreach ($tach_thanhvien as $key => $value) {
		mysqli_query($conn,"UPDATE user_info SET nhom='{$r_tt['id']}' WHERE user_id='$value'");
	}
}
?>