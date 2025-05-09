<?php
$class_index=$tlca_do->load_skin($s,'class_shop');
$giaodien=json_decode($index_setting['giaodien'],true);
$limit=48;
if(!isset($_COOKIE['user_id'])){
	$thongbao="Bạn hiện chưa đăng nhập.";
	$replace=array(
		'title'=>'Bạn chưa đăng nhập tài khoản',
		'thongbao'=>$thongbao,
		'link'=>'/dang-nhap.html'
	);
	echo $skin->skin_replace('skin_shop/'.$s.'/tpl/chuyenhuong',$replace);
	exit();
}else{
	$box_header=$skin->skin_normal('skin_shop/'.$s.'/tpl/box_header_login');
	$header_menu_mobile=$skin->skin_normal('skin_shop/'.$s.'/tpl/header_menu_mobile_login');
	$class_member=$tlca_do->load('class_member');
	$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
	$user_id=$tach_token['user_id'];
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
	if($user_info['dropship']==1){
		$thongbao="Hệ thống đang chuyển hướng.";
		$replace=array(
			'title'=>'Đang chuyển hướng tới trang bán hàng',
			'thongbao'=>$thongbao,
			'link'=>'/dropship/'
		);
		echo $skin->skin_replace('skin_shop/'.$s.'/tpl/chuyenhuong',$replace);
		exit();		
	}
}
if($user_info['dropship']==2){
	$text_dropship=$skin->skin_normal('skin_shop/'.$s.'/tpl/dropship_wait');
}else{
	$text_dropship=$skin->skin_normal('skin_shop/'.$s.'/tpl/dropship_reg');
}
$tach_menu=json_decode($class_index->list_menu($conn,$s,$r_shop['user_id']),true);
$tach_category=json_decode($class_index->list_category($conn,$r_shop['user_id']),true);
$google_analytics=str_replace('<script>// <![CDATA[', '<script>', $index_setting['google_analytics']);
$google_analytics=str_replace('// ]]>', '', $google_analytics);
$script_chat=str_replace('<script>// <![CDATA[', '<script>', $index_setting['script_footer']);
$script_chat=str_replace('// ]]>', '', $script_chat);
$replace=array(
	'header'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/header'),
	'box_header'=>$box_header,
	'footer'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/footer'),
	'script_footer'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/script_footer'),
	'title'=>'Đăng ký tài khoản bán hàng',
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
	'logo'=>$index_setting['logo'],
	'text_footer'=>$index_setting['text_footer'],
	'google_analytics'=>$google_analytics,
	'script_chat'=>$script_chat,
	'text_contact_footer'=>$index_setting['text_contact_footer'],
	'text_about'=>$index_setting['text_about'],
	'link_xem'=>$index_setting['link_domain'],
	'hotline'=>$index_setting['hotline'],
	'hotline_number'=>preg_replace('/[^0-9]/', '',$index_setting['hotline']),
	'text_hotline'=>$index_setting['text_hotline'],
	'link_facebook'=>$index_setting['link_facebook'],
	'link_google'=>$index_setting['link_google'],
	'link_youtube'=>$index_setting['link_youtube'],
	'link_twitter'=>$index_setting['link_twitter'],
	'link_instagram'=>$index_setting['link_instagram'],
	'bg_backgroud'=>$giaodien['background'],
	'bg_header'=>$giaodien['header'],
	'bg_topbar'=>$giaodien['topbar'],
	'bg_hotline'=>$giaodien['hotline'],
	'bg_menu'=>$giaodien['menu'],
	'bg_title_menu'=>$giaodien['title_menu'],
	'bg_title_box'=>$giaodien['title_box'],
	'bg_button_top'=>$giaodien['button_top'],
	'bg_subcribe'=>$giaodien['subcribe'],
	'bg_top_menu_mobile'=>$giaodien['top_menu_mobile'],
	'bg_label_sale'=>$giaodien['label_sale'],
	'bg_ma_giamgia'=>$giaodien['ma_giamgia'],
	'bg_top_footer'=>$giaodien['top_footer'],
	'bg_bottom_footer'=>$giaodien['bottom_footer'],
	'color_text_top_footer'=>$giaodien['text_top_footer'],
	'color_text_bottom_footer'=>$giaodien['text_bottom_footer'],
	'bg_timkiem'=>$giaodien['timkiem'],
	'bg_nhantin'=>$giaodien['nhantin'],
	'color_text_title_top_footer'=>$giaodien['text_title_top_footer'],
	'menu_chinhsach'=>$tach_menu['chinhsach'],
	'menu_huongdan'=>$tach_menu['huongdan'],
	'menu_top'=>$tach_menu['top'],
	'list_category_nav'=>$tach_category['list'],
	'list_category_left'=>$tach_category['list_left'],
	'photo'=>$index_setting['photo'],
	'phantrang'=>$phantrang,
	'fanpage'=>$index_setting['fanpage'],
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar'],
	'email'=>$user_info['email'],
	'ngay_sinh'=>$user_info['ngaysinh'],
	'dien_thoai'=>$user_info['mobile'],
	'username'=>$user_info['username'],
	'date_reg'=>date('d/m/Y',$user_info['created']),
	'dia_chi'=>$user_info['dia_chi'],
	'ngay'=>date('d'),
	'thang'=>date('m'),
	'nam'=>date('Y'),
	'text_dropship'=>$text_dropship,
	'gioithieu_dropship'=>$index_setting['gioithieu_dropship'],
	'shop'=>$r_shop['user_id'],
	);
echo $skin->skin_replace('skin_shop/'.$s.'/tpl/ban_hang',$replace);
?>