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
$thongtin=mysqli_query($conn,"SELECT * FROM kichhoat_baohanh WHERE status='0' ORDER BY id DESC");
while($r_tt=mysqli_fetch_assoc($thongtin)){
	$thongtin_coupon=mysqli_query($conn,"SELECT * FROM coupon WHERE ma='{$r_tt['coupon']}' AND shop='0'");
	$total=mysqli_num_rows($thongtin_coupon);
	if($total==0){
		mysqli_query($conn,"INSERT INTO coupon(shop,ma,giam,loai,kieu,sanpham,start,expired,status)VALUES('0','{$r_tt['coupon']}','{$index_setting['coupon_baohanh_giam']}','{$index_setting['coupon_baohanh_loai']}','baohanh','','{$r_tt['date_post']}','{$r_tt['expired']}','0')");
		echo 'Đã thêm coupon '.$r_tt['coupon'].'<br>';
	}else{
		echo 'Đã có coupon '.$r_tt['coupon'].'<br>';
	}
	
}
?>