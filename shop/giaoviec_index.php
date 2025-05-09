<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
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
$thongtin_shop=mysqli_query($conn,"SELECT *,count(*) AS total FROM domain_giaoviec WHERE domain='$web' ORDER BY user_id DESC LIMIT 1");
$r_shop=mysqli_fetch_assoc($thongtin_shop);
$shop=$r_shop['user_id'];
if($r_shop['total']==0){
	$thongbao="Tên miền không tồn tại.";
	$replace=array(
		'title'=>'Tên miền không tồn tại',
		'thongbao'=>$thongbao,
		'link_chuyen'=>'https://socdo.vn'
	);
	echo $skin->skin_replace('skin_shop/giaoviec/tpl/chuyenhuong',$replace);
	exit();
}
include('skin_shop/giaoviec/index.php');
?>