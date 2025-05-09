<?php
include('../includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_dropship');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$skin=$tlca_do->load('class_skin_cpanel');
if(isset($_COOKIE['user_id'])){
	$thongbao="Bạn đã đăng nhập tài khoản.<br>Đang chuyển hướng tới trang chủ...";
	$replace=array(
		'title'=>'Bạn đã đăng nhập...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link_chuyen'=>'/dropship/'
	);
	echo $skin->skin_replace('skin_dropship/chuyenhuong',$replace);
	exit();
}
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$limit=30;
$replace=array(
	'header'=>$skin->skin_normal('skin_dropship/header'),
	'top_menu'=>$skin->skin_normal('skin_dropship/top_menu'),
	'footer'=>$skin->skin_normal('skin_dropship/footer'),
	'box_script_footer'=>$skin->skin_normal('skin_dropship/box_script_footer'),
	'title'=>'Đăng nhập tài khoản',
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'h1'=>$index_setting['h1']
);
echo $skin->skin_replace('skin_dropship/login',$replace);
?>