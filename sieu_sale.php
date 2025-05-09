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
} else {
	$box_header = $skin->skin_normal('skin/box_header');
	$mobile_menu = $skin->skin_normal('skin/mobile_menu');
}
$hientai = time();
$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE shop='0' AND loai='flash_sale' ORDER BY id DESC");
while ($r_d = mysqli_fetch_assoc($thongtin_deal)) {
	if ($check->show_thu($r_d['date_start']) == '7' or $check->show_thu($r_d['date_start']) == 'cn') {
		$list_flashsale_id .= $r_d['main_product'] . ',';
		$list_check_product[] = json_decode($r_d['sub_product'], true);
	}
}
$list_c = array();
foreach ($list_check_product as $key => $value) {
	foreach ($value as $k => $v) {
		if (!isset($list_c[$k])) {
			$list_c[$k] = $v;
		}
	}
}
$list_flashsale_id = substr($list_flashsale_id, 0, -1);
$tach_menu = json_decode($class_index->list_menu($conn), true);
$tach_banner = json_decode($class_index->list_banner($conn), true);
$tach_list_category = json_decode($class_index->list_category($conn), true);
$link_xem = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$banner_page = $class_index->list_banner_page($conn, 'banner_dautruong');
$thongtin_tieude = mysqli_query($conn, "SELECT * FROM banner WHERE link='/sieu-sale.html' ORDER BY thu_tu ASC LIMIT 1");
$r_tieude = mysqli_fetch_assoc($thongtin_tieude);
$list_danhmuc_top = json_decode($class_index->list_category_danhmuc_top($conn), true);
$replace = array(
	'list_danhmuc_noibat_timkiem' => $class_index->list_category_noibat_timkiem($conn), // chức năng tìm kiếm nâng cao
	'header' => $skin->skin_normal('skin/header'),
	'list_danhmuc' => $list_danhmuc_top['list_parent'],
	'list_danhmuc_sub' => $list_danhmuc_top['list_sub'],
	'box_header' => $box_header,
	'footer' => $skin->skin_normal('skin/footer'),
	'script_footer' => $skin->skin_normal('skin/script_footer'),
	'mobile_menu' => $mobile_menu,
	'box_deal' => $skin->skin_normal('skin/box_deal'),
	'box_banchay' => $skin->skin_normal('skin/box_banchay'),
	'box_noibat' => $skin->skin_normal('skin/box_noibat'),
	'footer' => $skin->skin_normal('skin/footer'),
	'footer' => $skin->skin_normal('skin/footer'),
	'title' => 'Đấu trường săn sale - ' . $index_setting['title'],
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
	'menu_chinhsach' => $tach_menu['chinhsach'],
	'menu_huongdan' => $tach_menu['huongdan'],
	'menu_left' => $tach_menu['left'],
	'banner_top' => $tach_banner['top'],
	'banner_bottom_slide' => $tach_banner['bottom_slide'],
	'banner_sanpham_banchay' => $tach_banner['sanpham_banchay'],
	'banner_sanpham_noibat' => $tach_banner['sanpham_noibat'],
	'banner_page' => $banner_page,
	'tieu_de' => $r_tieude['tieu_de'],
	'list_sieu_sale' => $class_index->list_sieu_sale($conn, $list_flashsale_id, $list_c, $page, $limit),
	'dropship' => $user_info['dropship'],
);
echo $skin->skin_replace('skin/sieu_sale', $replace);
