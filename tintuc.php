<?php
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('doantotnghiep.vn','socdo.vn','socmoi.vn','soc.vn','beta.socdo.vn');
if(in_array($web, $web_root)==false){
	include('./shop/tintuc.php');
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
$limit=10;
if(isset($_COOKIE['user_id'])){
	$box_header=$skin->skin_normal('skin/box_header_login');
	$mobile_menu=$skin->skin_normal('skin/mobile_menu_login');
	$class_member=$tlca_do->load('class_member');
	$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
	$user_id=$tach_token['user_id'];
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
}else{
	$box_header=$skin->skin_normal('skin/box_header');
	$mobile_menu=$skin->skin_normal('skin/mobile_menu');
}
$blank=addslashes(strip_tags($_REQUEST['blank']));
$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM category WHERE cat_blank='$blank' ORDER BY cat_id DESC LIMIT 1");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
	$thongbao="Dữ liệu không tồn tại.";
	$replace=array(
		'title'=>'Dữ liệu không tồn tại',
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();
}
$cat_id=$r_tt['cat_id'];
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM post WHERE FIND_IN_SET($cat_id,cat)>0");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$phantrang=$class_index->phantrang($page,$total_page,'/bai-viet/'.$blank.'.html');
$tach_list=json_decode($class_index->list_baiviet_category($conn,$cat_id,$page,$limit),true);
if($tach_list['total']==0){
	if($page==1){
		$list_baiviet='<center>Không có dữ liệu</center>';
	}else{
		$list_baiviet='<center>Không còn dữ liệu</center>';

	}
}else{
	$list_baiviet=$tach_list['list'];	
}
$tach_menu=json_decode($class_index->list_menu($conn),true);
$tach_banner=json_decode($class_index->list_banner($conn),true);
$tach_list_category=json_decode($class_index->list_category($conn),true);
$link_xem=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$list_danhmuc_top=json_decode($class_index->list_category_danhmuc_top($conn),true);
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'box_header'=>$box_header,
	'footer'=>$skin->skin_normal('skin/footer'),
	'script_footer'=>$skin->skin_normal('skin/script_footer'),
	'mobile_menu'=>$mobile_menu,
	'title'=>$r_tt['cat_title'],
	'description'=>$r_tt['cat_description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
	'logo'=>$index_setting['logo'],
	'text_footer'=>$index_setting['text_footer'],
	'text_contact_footer'=>$index_setting['text_contact_footer'],
	'text_about'=>$index_setting['text_about'],
	'link_xem'=>$link_xem,
	'link_facebook'=>$index_setting['link_facebook'],
	'link_youtube'=>$index_setting['link_youtube'],
	'link_twitter'=>$index_setting['link_twitter'],
	'link_instagram'=>$index_setting['link_instagram'],
	'text_hotline'=>$index_setting['text_hotline'],
	'hotline'=>$index_setting['hotline'],
	'hotline_number'=>preg_replace('/[^0-9]/', '', $index_setting['hotline']),
	'menu_chinhsach'=>$tach_menu['chinhsach'],
	'menu_huongdan'=>$tach_menu['huongdan'],
	'menu_left'=>$tach_menu['left'],
	'list_category'=>$tach_list_category['list'],
	'list_category_top'=>$tach_list_category['list_top'],
	'list_category_mobile'=>$tach_list_category['list_mobile'],
	'fanpage'=>$index_setting['fanpage'],
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar'],
	'gioithieu'=>$index_setting['gioithieu'],
	'list_tintuc'=>$list_baiviet,
	'list_tintuc_right'=>$class_index->list_baiviet_right($conn,5),
	'tieu_de'=>$r_tt['cat_tieude'],
	'menu_chinhsach'=>$tach_menu['chinhsach'],
	'menu_huongdan'=>$tach_menu['huongdan'],
	'menu_left'=>$tach_menu['left'],
	'banner_top'=>$tach_banner['top'],
	'phantrang'=>$phantrang,
'list_danhmuc' => $list_danhmuc_top['list_parent'],
	'list_danhmuc_sub' => $list_danhmuc_top['list_sub'],	'list_danhmuc_noibat_timkiem'=>$class_index->list_category_noibat_timkiem($conn), // chức năng tìm kiếm nâng cao,
	'dropship'=>$user_info['dropship'],
	);
echo $skin->skin_replace('skin/tintuc',$replace);
?>	