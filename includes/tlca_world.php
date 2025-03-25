<?php
session_start();
// Config
error_reporting(1);
include('config.php');
// class gold ly
include('class_manage.php');
// Class manage Variable
$tlca_do = new class_manage;
// Template Variable
$skin = $tlca_do->skin;
$class_member = $tlca_do->load('class_member');
$class_member->check_login();
$ip_address=$_SERVER['REMOTE_ADDR'];
$thongtin_visit=mysqli_query($conn,"SELECT * FROM visit WHERE ip_address='$ip_address' ORDER BY id DESC LIMIT 1");
$total_visit=mysqli_num_rows($thongtin_visit);
$hientai=time();
if($total_visit==0){
	mysqli_query($conn,"INSERT INTO visit(ip_address,date_post)VALUES('$ip_address','$hientai')");
	$thongtin_isetting=mysqli_query($conn,"SELECT * FROM index_setting WHERE name='total_visit'");
	$r_st=mysqli_fetch_assoc($thongtin_isetting);
	$visit_moi=intval($r_st['value']) + 1;
	mysqli_query($conn,"UPDATE index_setting SET value='$visit_moi' WHERE name='total_visit'");
}else{
	$r_visit=mysqli_fetch_assoc($thongtin_visit);
	$gioi_han=time() - $r_visit['date_post'];
	if($gioi_han>24*3600){
		mysqli_query($conn,"INSERT INTO visit(ip_address,date_post)VALUES('$ip_address','$hientai')");
		$thongtin_isetting=mysqli_query($conn,"SELECT * FROM index_setting WHERE name='total_visit'");
		$r_st=mysqli_fetch_assoc($thongtin_isetting);
		$visit_moi=intval($r_st['value']) + 1;
		mysqli_query($conn,"UPDATE index_setting SET value='$visit_moi' WHERE name='total_visit'");
	}
}
?>