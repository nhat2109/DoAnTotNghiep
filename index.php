<?php
$web = $_SERVER['HTTP_HOST'];
$web = str_replace('www.', '', $web);
$web_root = array('doantotnghiep.vn', 'socdo.vn', 'socmoi.vn', 'soc.vn', 'beta.socdo.vn');
if (in_array($web, $web_root) == false) {
	include('./shop/index.php');
	exit();
}
include('./includes/tlca_world.php');
$check = $tlca_do->load('class_check');
$class_index = $tlca_do->load('class_index');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page = addslashes($url_query['page']);
$page = intval($page);
if ($page > 1) {
	$page = $page;
	$title_page = ' - Page ' . $page;
} else {
	$page = 1;
	$title_page = '';
}
$sort = addslashes($url_query['sort']);
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
$limit = 48;
if (isset($_COOKIE['user_id'])) {
	$box_header = $skin->skin_normal('skin/box_header_login');
	$mobile_menu = $skin->skin_normal('skin/mobile_menu_login');
	$class_member = $tlca_do->load('class_member');
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	if ($user_info['total'] == 0) {
		$thongbao = "Thông tin không hợp lệ.";
		$replace = array(
			'title' => 'Thông tin không hợp lệ.',
			'thongbao' => $thongbao,
			'link' => '/dang-xuat.html'
		);
		echo $skin->skin_replace('skin/chuyenhuong', $replace);
		exit();
	}
} else {
	$box_header = $skin->skin_normal('skin/box_header');
	$mobile_menu = $skin->skin_normal('skin/mobile_menu');
}
$hientai = time();
$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE date_start<='$hientai' AND date_end>='$hientai' AND shop='0' ORDER BY id DESC");
while ($r_d = mysqli_fetch_assoc($thongtin_deal)) {
	if ($r_d['loai'] == 'flash_sale') {
		$list_flashsale_id .= $r_d['main_product'] . ',';
		$list_check_product[] = json_decode($r_d['sub_product'], true);
	} else if ($r_d['loai'] == 'muakem') {
		$list_muakem_id .= $r_d['main_product'] . ',';
	} else if ($r_d['loai'] == 'tang') {
		$list_tang_id .= $r_d['main_product'] . ',';
	}
}
//print_r($list_check_product);
foreach ($list_check_product as $key => $value) {
	foreach ($value as $k => $v) {
		if ($key == 0) {
			$list_c[$k] = $v;
		}
	}
}
///huyphuc15/04/2025
$tt_thuong_hieu = mysqli_query($conn, "SELECT COUNT(*) AS tong FROM thuong_hieu WHERE status=1");
$r_tt_thuonghieu = mysqli_fetch_assoc($tt_thuong_hieu); ///
$list_danhmuc_top = json_decode($class_index->list_category_danhmuc_top($conn), true);
$list_muakem_id = substr($list_muakem_id, 0, -1);
$list_flashsale_id = substr($list_flashsale_id, 0, -1);
$list_tang_id = substr($list_tang_id, 0, -1);
$tach_tintuc = json_decode($class_index->list_tintuc_index($conn, 6), true);
$tach_menu = json_decode($class_index->list_menu($conn), true);
$tach_banner = json_decode($class_index->list_banner($conn), true);
// Xóa đoạn giới hạn để lấy tất cả banner
$banner_index = $class_index->list_banner_index($conn);
$replace['banner_index'] = $banner_index; // Không cần array_slice
$tach_list_category = json_decode($class_index->list_category($conn), true);
$link_xem = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$replace = array(
	'banner_doitac' => $tach_banner['banner_doitac'],
	'banner_doitac_hai' => $tach_banner['banner_doitac_hai'],
	'header' => $skin->skin_normal('skin/header'),
	'box_header' => $box_header,
	'footer' => $skin->skin_normal('skin/footer'),
	'script_footer' => $skin->skin_normal('skin/script_footer'),
	'mobile_menu' => $mobile_menu,
	'box_deal' => $skin->skin_normal('skin/box_deal'),
	'box_banchay' => $skin->skin_normal('skin/box_banchay'),
	'box_noibat' => $skin->skin_normal('skin/box_noibat'),
	'box_goiy'=>$skin->skin_normal('skin/box_goiy'),//15-4
	'footer' => $skin->skin_normal('skin/footer'),
	'footer' => $skin->skin_normal('skin/footer'),
	'title' => $index_setting['title'],
	'description' => $index_setting['description'],
	'site_name' => $index_setting['site_name'],
	'limit' => $limit,
	'logo' => $index_setting['logo'],
	'text_footer' => $index_setting['text_footer'],
	'text_about' => $index_setting['text_about'],
	'link_xem' => $link_xem,
	'link_contact' => $index_setting['link_contact'],
	'photo' => $index_setting['photo'],
	'link_facebook' => $index_setting['link_facebook'],
	'link_youtube' => $index_setting['link_youtube'],
	'link_twitter' => $index_setting['link_twitter'],
	'link_instagram' => $index_setting['link_instagram'],
	'text_hotline' => $index_setting['text_hotline'],
	'hotline' => $index_setting['hotline'],
	'hotline_number' => preg_replace('/[^0-9]/', '', $index_setting['hotline']),
	'phantrang' => $phantrang,
	'fanpage' => $index_setting['fanpage'],
	'name' => $user_info['name'],
	'avatar' => $user_info['avatar'],
	'list_category' => $tach_list_category['list'],
	'list_category_top' => $tach_list_category['list_top'],
	'list_category_mobile' => $tach_list_category['list_mobile'],
	'list_slide' => $class_index->list_slide($conn),
	'list_danhmuc_noibat' => $class_index->list_category_noibat($conn),
	'list_danhmuc_trend' => $class_index->list_xuhuong($conn),
	'list_cac_thuong_hieu'=> $class_index->list_thuong_hieu($conn,1,(int)$r_tt_thuonghieu['tong']),///huyphuc15/04/2025
	'list_box' => $class_index->list_box_index($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c),
	'list_sanpham_deal' => $class_index->list_sanpham_deal_index($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, 1, 10),
	'list_sanpham_banchay' => $class_index->list_sanpham_banchay($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, 1, 8),
	'list_sanpham_noibat' => $class_index->list_sanpham_noibat($conn, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, 1, 8),
	'tintuc_big' => $tach_tintuc['big'],
	'tintuc_small' => $tach_tintuc['small'],
	'menu_chinhsach' => $tach_menu['chinhsach'],
	'menu_huongdan' => $tach_menu['huongdan'],
	'menu_left' => $tach_menu['left'],
	'banner_top' => $tach_banner['top'],
	'banner_index' => $banner_index,
	'banner_big' => $tach_banner['banner_big'],
	'banner_bottom_slide' => $tach_banner['bottom_slide'],
	'banner_sanpham_banchay' => $tach_banner['sanpham_banchay'],
	'banner_sanpham_noibat' => $tach_banner['sanpham_noibat'],
	'bg_box_noibat' => $index_setting['bg_box_noibat'],
	'bg_flash_sale' => $index_setting['bg_flash_sale'],
	'bg_box_trend' => $index_setting['bg_box_trend'],
	'icon_box_noibat' => $index_setting['icon_box_noibat'],
	'bg_color_flash_sale' => $index_setting['bg_color_flash_sale'],
	'list_danhmuc' => $list_danhmuc_top['list_parent'],
	'list_danhmuc_sub' => $list_danhmuc_top['list_sub'],
	'dropship' => $user_info['dropship'],
	'list_danhmuc_noibat_timkiem' => $class_index->list_category_noibat_timkiem($conn), // chức năng tìm kiếm nâng cao
	'list_goi_y_home'=>$class_index->list_home_goiy($conn),
);

echo $skin->skin_replace('skin/index', $replace);
