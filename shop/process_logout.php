<?php
setcookie("user_id",$_COOKIE['user_id'],time() - 3600,'/');
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$thongbao="Đăng xuất thành công.";
$replace=array(
	'title'=>'Đăng xuất thành công',
	'thongbao'=>$thongbao,
	'link'=>'/'
);
echo $skin->skin_replace('skin_shop/skin_1/tpl/chuyenhuong',$replace);
?>