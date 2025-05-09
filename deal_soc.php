<?php
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('doantotnghiep.vn','socdo.vn','socmoi.vn','soc.vn','beta.socdo.vn');
if(in_array($web, $web_root)==false){
	include('./shop/index.php');
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
$limit=48;
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
$hientai=time();
$list_tang='';
$list_muakem='';
$thongtin_deal=mysqli_query($conn,"SELECT * FROM deal WHERE date_end>='$hientai' AND date_start<='$hientai' AND shop='0' AND (loai='muakem' OR loai='tang') ORDER BY id DESC");
while($r_d=mysqli_fetch_assoc($thongtin_deal)){
	$list_flashsale_id.=$r_d['main_product'].',';
	if($r_d['loai']=='muakem'){
		$list_muakem.=$r_d['main_product'].',';
	}else if($r_d['loai']=='tang'){
		$list_tang.=$r_d['main_product'].',';
	}
}
if($list_tang!=''){
	$list_tang=substr($list_tang, 0,-1);
}
if($list_muakem!=''){
	$list_muakem=substr($list_muakem, 0,-1);
}
if($list_flashsale_id!=''){
	$list_flashsale_id=substr($list_flashsale_id, 0,-1);
	$tach_list_flashsale_id = explode(',', $list_flashsale_id);
	$list_id=array_unique($tach_list_flashsale_id);
	$list_id=implode(',', $list_id);
	$thongke=mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>0 AND id IN ($list_id) ORDER BY (gia_cu - gia_moi) DESC");;
	$total_tk=mysqli_num_rows($thongke);
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($total_tk/$limit);
	$phantrang=$class_index->phantrang_sanpham($page,$total_page,'/deal-soc.html');
	$list_deal_soc=$class_index->list_deal_soc($conn,$list_flashsale_id,$list_tang,$list_muakem,$page,$limit);
}else{
	$list_id='';
	$phantrang='';
	$list_deal_soc='';
}
$list_danhmuc_top=json_decode($class_index->list_category_danhmuc_top($conn),true);
$tach_menu=json_decode($class_index->list_menu($conn),true);
$tach_banner=json_decode($class_index->list_banner($conn),true);
$tach_list_category=json_decode($class_index->list_category($conn),true);
$link_xem=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$banner_page=$class_index->list_banner_page($conn,'banner_deal_soc');
$thongtin_tieude=mysqli_query($conn,"SELECT * FROM banner WHERE link='/deal-soc.html' ORDER BY thu_tu ASC LIMIT 1");
$r_tieude=mysqli_fetch_assoc($thongtin_tieude);
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'box_header'=>$box_header,
	'list_danhmuc'=>$list_danhmuc_top['list_top'],
	'footer'=>$skin->skin_normal('skin/footer'),
	'script_footer'=>$skin->skin_normal('skin/script_footer'),
	'mobile_menu'=>$mobile_menu,
	'box_deal'=>$skin->skin_normal('skin/box_deal'),
	'box_banchay'=>$skin->skin_normal('skin/box_banchay'),
	'box_noibat'=>$skin->skin_normal('skin/box_noibat'),
	'footer'=>$skin->skin_normal('skin/footer'),
	'footer'=>$skin->skin_normal('skin/footer'),
	'title'=>'Mua kèm deal sốc - '.$index_setting['title'],
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
	'logo'=>$index_setting['logo'],
	'text_footer'=>$index_setting['text_footer'],
	'text_about'=>$index_setting['text_about'],
	'link_xem'=>$link_xem,
	'link_contact'=>$index_setting['link_contact'],
	'photo'=>$index_setting['photo'],
	'link_facebook'=>$index_setting['link_facebook'],
	'link_youtube'=>$index_setting['link_youtube'],
	'link_twitter'=>$index_setting['link_twitter'],
	'link_instagram'=>$index_setting['link_instagram'],
	'text_hotline'=>$index_setting['text_hotline'],
	'hotline'=>$index_setting['hotline'],
	'hotline_number'=>preg_replace('/[^0-9]/', '', $index_setting['hotline']),
	'phantrang'=>$phantrang,
	'fanpage'=>$index_setting['fanpage'],
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar'],
	'list_category'=>$tach_list_category['list'],
	'list_category_top'=>$tach_list_category['list_top'],
	'list_category_mobile'=>$tach_list_category['list_mobile'],
	'menu_chinhsach'=>$tach_menu['chinhsach'],
	'menu_huongdan'=>$tach_menu['huongdan'],
	'menu_left'=>$tach_menu['left'],
	'banner_top'=>$tach_banner['top'],
	'banner_bottom_slide'=>$tach_banner['bottom_slide'],
	'banner_sanpham_banchay'=>$tach_banner['sanpham_banchay'],
	'banner_sanpham_noibat'=>$tach_banner['sanpham_noibat'],
	'banner_page'=>$banner_page,
	'tieu_de'=>$r_tieude['tieu_de'],
	'list_deal_soc'=>$list_deal_soc,
	'list_danhmuc_noibat_timkiem'=>$class_index->list_category_noibat_timkiem($conn), // chức năng tìm kiếm nâng cao
'dropship'=>$user_info['dropship'],
	);
echo $skin->skin_replace('skin/deal_soc',$replace);
?>