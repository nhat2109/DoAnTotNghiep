<?php
include('./includes/tlca_world.php');
include_once("./class.phpmailer.php");
$check=$tlca_do->load('class_check');
$action=addslashes($_REQUEST['action']);
$class_member=$tlca_do->load('class_member');
// $thongtin_gv=mysqli_query($conn,"SELECT * FROM domain_giaoviec WHERE domain='$web' ORDER BY user_id DESC LIMIT 1");
// $total_gv=mysqli_num_rows($thongtin_gv);
// if($total_gv>0){
// 	if($total_gv==0){
// 	}else{
// 		$r_gv=mysqli_fetch_assoc($thongtin_gv);
// 		$shop=$r_gv['user_id'];
// 		include('skin_shop/giaoviec/process.php');
// 	}
// }else{
	
// }
$thongtin_shop=mysqli_query($conn,"SELECT * FROM user_info WHERE domain='$web' ORDER BY user_id DESC LIMIT 1");
	$total_shop=mysqli_num_rows($thongtin_shop);
	$r_shop=mysqli_fetch_assoc($thongtin_shop);
	$shop=$r_shop['user_id'];
	$setting=mysqli_query($conn,"SELECT * FROM shop_setting WHERE shop='{$r_shop['user_id']}' ORDER BY name ASC");
	while ($r_s=mysqli_fetch_assoc($setting)) {
		$index_setting[$r_s['name']]=$r_s['value'];
	}
	$s=$index_setting['skin_folder'];
	include('skin_shop/'.$s.'/process.php');
?>