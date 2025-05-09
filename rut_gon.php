<?php
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('doantotnghiep.vn','socdo.vn','soc.vn','socdo.xyz');
if(in_array($web, $web_root)==false){
	include('./shop/ban_hang.php');
	exit();
}
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$page=intval($page);
if($page>1){
	$page=$page;
	$title_page=' - Page '.$page;
}else{
	$page=1;
	$title_page='';
}
$sort=addslashes($url_query['sort']);
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$rut_gon=$_REQUEST['rut_gon'];
$thongtin=mysqli_query($conn,"SELECT * FROM rut_gon WHERE rut_gon='$rut_gon'");
$r_tt=mysqli_fetch_assoc($thongtin);
$total=mysqli_num_rows($thongtin);
if($total==0){
	$thongbao="Link không tồn tại.";
	$replace=array(
		'title'=>'',
		'thongbao'=>$thongbao,
		'link'=>'https://socdo.vn'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();
}else{
	$thongbao="Hệ thống đang chuyển hướng.";
	$replace=array(
		'title'=>'',
		'thongbao'=>$thongbao,
		'link'=>$r_tt['link']
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();
}

?>