<?php
include('./includes/tlca_world.php');
include_once("./class.phpmailer.php");
$check=$tlca_do->load('class_check');
$action=addslashes($_REQUEST['action']);
$class_index=$tlca_do->load('class_index');
$class_member=$tlca_do->load('class_member');
$page=intval($_REQUEST['page']);
if($page<1){
	$page=1;
}
$limit=100;
$start=$page*$limit - $limit;
$thongtin=mysqli_query($conn,"SELECT * FROM sanpham_shop ORDER BY id ASC LIMIT $start,$limit");
while($r_tt=mysqli_fetch_assoc($thongtin)){
	$thongtin_check=mysqli_query($conn,"SELECT * FROM thuong_hieu WHERE goc='{$r_tt['thuong_hieu']}' AND shop='{$r_tt['shop']}'");
	$r_ck=mysqli_fetch_assoc($thongtin_check);
	echo $r_tt['shop'].'<br>';
	echo $r_tt['thuong_hieu'].'<br>';
	echo $r_ck['id'].'<br>';
	mysqli_query($conn,"UPDATE sanpham_shop SET thuong_hieu='{$r_ck['id']}' WHERE id='{$r_tt['id']}'");
	echo "UPDATE sanpham_shop SET thuong_hieu='{$r_ck['id']}' WHERE id='{$r_tt['id']}'<br>";
}
$page++;
	echo "<title> Thông báo hệ thống </title>";
    echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
    echo "<center><font color=red>Đang chuyển hướng!</font></center>";
    echo "<meta http-equiv='refresh' content='3;url=/update_thuonghieu_sanpham.php?page=".$page."'>";  
?>