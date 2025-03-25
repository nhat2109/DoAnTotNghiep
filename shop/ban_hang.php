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
$thongtin_shop=mysqli_query($conn,"SELECT * FROM user_info WHERE domain='$web' ORDER BY user_id DESC LIMIT 1");
$r_shop=mysqli_fetch_assoc($thongtin_shop);
$setting=mysqli_query($conn,"SELECT * FROM shop_setting WHERE shop='{$r_shop['user_id']}' ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$total_setting=mysqli_num_rows($setting);
if($total_setting<1){
	$ref=$_SERVER["HTTP_REFERER"];
	if(strpos($ref, '/dropship')!==false){
		$link_re='https://socdo.vn/dropship/list-giaodien';
	}else{
		$link_re='https://socdo.vn';
	}
	$thongbao="Gian hàng chưa thiết lập giao diện.";
	$replace=array(
		'title'=>'Gian hàng chưa thiết lập giao diện',
		'thongbao'=>$thongbao,
		'link'=>$link_re
	);
	echo $skin->skin_replace('skin_shop/skin_1/tpl/chuyenhuong',$replace);
	exit();	
}
$s=$index_setting['skin_folder'];
include('skin_shop/'.$s.'/ban_hang.php');
?>