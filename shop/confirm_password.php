<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$email=addslashes($url_query['email']);
$token=addslashes($url_query['token']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM forgot_password WHERE email='$email' AND code_active='$token'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
	$thongbao="Link không tồn tại hoặc đã được sử dụng...";
	$replace=array(
		'title'=>'Đang chuyển hướng',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin_shop/skin_1/tpl/chuyenhuong',$replace);
}else{
	$pass=md5($r_tt['password']);
	mysqli_query($conn,"UPDATE user_info SET password='$pass' WHERE email='$email'");
	mysqli_query($conn,"DELETE FROM forgot_password WHERE email='$email'");
	$thongbao="Thành công! Mật khẩu mới đã được xác nhận...";
	$replace=array(
		'title'=>'Đang chuyển hướng',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/dang-nhap.html'
	);
	echo $skin->skin_replace('skin_shop/skin_1/tpl/chuyenhuong',$replace);
}
?>