<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_shop');
$thongbao="Dữ liệu không tồn tại.";
$replace=array(
	'title'=>'Dữ liệu không tồn tại',
	'thongbao'=>$thongbao,
	'link'=>'/'
);
echo $skin->skin_replace('skin_shop/chuyenhuong',$replace);
?>