<?php
$class_index=$tlca_do->load_skin($s,'class_shop');
$giaodien=json_decode($index_setting['giaodien'],true);
$limit=48;
if(isset($_COOKIE['user_id'])){
	$thongbao="Bạn hiện đã đăng nhập.";
	$replace=array(
		'title'=>'Bạn đã đăng nhập tài khoản',
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin_shop/'.$s.'/tpl/chuyenhuong',$replace);
	exit();
}else{
	$box_header=$skin->skin_normal('skin_shop/'.$s.'/tpl/box_header');
	$header_menu_mobile=$skin->skin_normal('skin_shop/'.$s.'/tpl/header_menu_mobile');
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
	'qc_header'=>$qc_header,
	'script_footer'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/script_footer'),
	'header_menu_mobile'=>$header_menu_mobile,
	'title'=>'Lấy lại mật khẩu tài khoản',
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'email' => $index_setting['email'], 
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
	'menu_mobile'=>$tach_menu['menu_mobile'],
	'category_mobile'=>$class_index->list_category_sanpham_mobile($conn,$r_shop['user_id']),
	'list_category_nav'=>$tach_category['list'],
	'list_category_left'=>$tach_category['list_left'],
	'photo'=>$index_setting['photo'],
	'phantrang'=>$phantrang,
	'fanpage'=>$index_setting['fanpage'],
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar'],
	'lienhe'=>$index_setting['lienhe'],
	'shop'=>$r_shop['user_id'],
	);
echo $skin->skin_replace('skin_shop/'.$s.'/tpl/quen_matkhau',$replace);
?>