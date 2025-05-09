<?php
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('doantotnghiep.vn','socdo.vn','socmoi.vn','soc.vn','beta.socdo.vn');
if(in_array($web, $web_root)==false){
	include('./shop/baiviet.php');
	exit();
}
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$limit=48;
if(isset($_COOKIE['user_id'])){
	$box_header=$skin->skin_normal('skin/box_header_login');
	$mobile_menu=$skin->skin_normal('skin/mobile_menu_login');
	$class_member=$tlca_do->load('class_member');
	$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
	$user_id=$tach_token['user_id'];
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
	$box_header=$skin->skin_normal('skin/box_header_login');
}else{
	$box_header=$skin->skin_normal('skin/box_header');
	$mobile_menu=$skin->skin_normal('skin/mobile_menu');
}
$link=addslashes(strip_tags($_REQUEST['blank']));
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM post WHERE link='$link'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
	$thongbao="Bài viết không tồn tại.";
	$replace=array(
		'title'=>'Bài viết không tồn tại',
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();
}
$moi=$r_tt['view'] + 1;
$list_danhmuc_top=json_decode($class_index->list_category_danhmuc_top($conn),true);
mysqli_query($conn,"UPDATE post SET view='$moi' WHERE id='{$r_tt['id']}'");
$tach_menu=json_decode($class_index->list_menu($conn),true);
$tach_banner=json_decode($class_index->list_banner($conn),true);
$tach_list_category=json_decode($class_index->list_category($conn),true);
$link_xem=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$replace=array(
	'list_danhmuc_noibat_timkiem'=>$class_index->list_category_noibat_timkiem($conn), // chức năng tìm kiếm nâng cao
	'header'=>$skin->skin_normal('skin/header'),
	'box_header'=>$box_header,
	'footer'=>$skin->skin_normal('skin/footer'),
	'script_footer'=>$skin->skin_normal('skin/script_footer'),
	'mobile_menu'=>$mobile_menu,
	'list_danhmuc'=>$list_danhmuc_top['list_top'],
	'title'=>$r_tt['title'],
	'description'=>$r_tt['description'],
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
	'lienhe'=>$index_setting['lienhe'],
	'photo'=>$index_setting['photo'],
	'phantrang'=>$phantrang,
	'fanpage'=>$index_setting['fanpage'],
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar'],
	'tieu_de'=>$r_tt['tieu_de'],
	'noidung'=>$r_tt['noidung'],
	'banner_top'=>$tach_banner['top'],
	'list_lienquan'=>$class_index->list_lienquan($conn,$r_tt['id'],$r_tt['cat'],$limit),
	'dropship'=>$user_info['dropship'],
	);
echo $skin->skin_replace('skin/baiviet',$replace);
?>