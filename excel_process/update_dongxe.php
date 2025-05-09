<?php
include './includes/tlca_world.php';
include_once "./class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$class_member = $tlca_do->load('class_member');
$thongtin=mysqli_query($conn,"SELECT * FROM bao_duong ORDER BY id ASC");
while($r_tt=mysqli_fetch_assoc($thongtin)){
	$ma_kieu_moi=preg_replace('/[^0-9A-Z]/', '', $r_tt['ma_kieu']);
	if(strpos($r_tt['ten_cv'],'lao động')==!false){
		mysqli_query($conn,"UPDATE bao_duong SET donvi_tinh='hs' WHERE id='{$r_tt['id']}'");
		echo $r_tt['ten_cv'].'<br>';
	}

}
?>