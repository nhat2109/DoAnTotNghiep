<?php
session_start();
include '../includes/tlca_world.php';
$class_index = $tlca_do->load('class_ncc');
$class_viettel = $tlca_do->load('class_viettel');
$class_member = $tlca_do->load('class_member');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page = addslashes($url_query['page']);
$sort = addslashes($url_query['sort']);
$skin = $tlca_do->load('class_skin_cpanel');
$check = $tlca_do->load('class_check');
$total_cart = isset($_SESSION['drop_cart']) ? count($_SESSION['drop_cart']) : 0;
$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
$user_id = $tach_token['user_id'];
$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
$hientai = time();
if ($user_info['ctv'] != 1 and $user_info['ctv'] != 4 and $user_info['ctv'] != 2) {
	$thongbao = "Tài khoản của bạn không phải ...";
	$replace = array(
		'title' => 'Tài khoản của bạn không phải ...',
		'description' => $index_setting['description'],
		'thongbao' => $thongbao,
		'link_chuyen' => '/',
	);
	echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
	exit();
} else if ($user_info['ctv'] == 4) {
	$thongbao = "Tài khoản của bạn đang bị tạm khóa...";
	$replace = array(
		'title' => 'Tài khoản của bạn đang bị tạm khóa...',
		'description' => $index_setting['description'],
		'thongbao' => $thongbao,
		'link_chuyen' => '/',
	);
	echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
	exit();
}

if ($result_follow && mysqli_num_rows($result_follow) > 0) {
	$row_follow = mysqli_fetch_assoc($result_follow);
	$list_id = trim($row_follow['sanpham']);
	if ($list_id !== '') {
		$arr_follow = array_filter(explode(',', $list_id));
		$total_follow = count($arr_follow);
	} else {
		$total_follow = 0;
	}
} else {
	$total_follow = 0;
}
if (intval($page) < 1) {
	$page = 1;
} else {
	$page = intval($page);
}
if (isset($_REQUEST['action'])) {
	$action = addslashes($_REQUEST['action']);
} else {
	$action = 'dashboard';
}

if (!isset($_COOKIE['user_id'])) {
	$thongbao = "Bạn chưa đăng nhập.<br>Đang chuyển hướng tới trang đăng nhập...";
	$replace = array(
		'title' => 'Bạn chưa đăng nhập...',
		'description' => $index_setting['description'],
		'thongbao' => $thongbao,
		'link_chuyen' => '/ncc/login'
	);
	echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
	exit();
}

// Lấy thông tin user

if ($user_info['ctv'] == 4) {
	$thongbao = "Tài khoản của bạn đang bị tạm khóa...";
	$replace = array(
		'title' => 'Tài khoản của bạn đang bị tạm khóa...',
		'description' => $index_setting['description'],
		'thongbao' => $thongbao,
		'link_chuyen' => '/ncc/login.html'
	);
	echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
	exit();
}
$display_kh_hi = 'display:none;';
$display_close_hi = 'display:none;';
$display_kh_ct = 'display:block;';
$box_taikhoan_kh = '';
// $setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
// while ($r_s = mysqli_fetch_assoc($setting)) {
// 	$index_setting[$r_s['name']] = $r_s['value'];
// }


if ($user_info['domain'] != '') {
	if (strpos('http://', $user_info['domain']) !== false) {
		$domain = $user_info['domain'];
	} else if (strpos('https://', $user_info['domain']) !== false) {
		$domain = $user_info['domain'];
	} else {
		$domain = 'http://' . $user_info['domain'];
	}
} else {
	$domain = $index_setting['link_domain'];
}
$tach_list_slide_donhang = json_decode($class_index->list_donhang_moi($conn, '', 1, 10), true);
$thaythe = array(
	'expire_time' => $expire_time,
	'display_kh' => $display_kh,
	'created_date' => $ngay_tao_taikhoan,
	'remaining_days' => number_format($remaining_days),
	'remaining_hours' => number_format($remaining_hours),
	'remaining_minutes' => number_format($remaining_minutes),
	'remaining_seconds' => number_format($remaining_seconds),
	'header' => $skin->skin_normal('skin_ncc/header'),
	'box_menu' => $skin->skin_normal('skin_ncc/box_menu'),
	'menu_thongbao' => $menu_thongbao,
	'footer' => $skin->skin_normal('skin_ncc/footer'),
	'box_script_footer' => $skin->skin_normal('skin_ncc/box_script_footer'),
	'box_taikhoan_kh' => $box_taikhoan_kh,
	'description' => $index_setting['description'],
	'thanhvien_chat' => $user_id,
	'site_name' => $index_setting['site_name'],
	'gianhang' => $domain,
	'phantrang' => '',
	'fullname' => $user_info['name'],
	'email' => $user_info['email'],
	'username' => $user_info['username'],
	'created' => $user_info['created'],
	'nganhang' => $index_setting['nganhang'],
	'user_money' => number_format($user_info['user_money']),
	'user_money2' => number_format($user_info['user_money2']),
	// 'list_danhmuc_video' => $class_index->list_danhmuc_video($conn),
	'list_donhang_slide' => $tach_list_slide_donhang['list_slide'],
	'name' => $name,
	'menu_nhom' => $menu_nhom,
	'avatar' => $user_info['avatar'],
	'box_danhhieu' => $box_danhhieu,
	'time_conlai' => $time_conlai,
	'pop_hotro' => $pop_hotro,
	'display_kh_ct' => $display_kh_ct,
	'display_close' => $display_close,
	'display_kh' => $display_kh_hi,
	'current_time' => time(),
	'display_close' => $display_close_hi,
	'marquee' => $marquee,
	'total_cart' => $total_cart,
	'total_follow' => $total_follow,
	// 'domain_giaoviec' => $domain_giao_viec,
);

$file_action = 'action/' . $action . '.php';
if (file_exists($file_action)) {
	include($file_action);
} else {
	$thongbao = "Dữ liệu không tồn tại...";
	$replace = array(
		'title' => 'Thiết lập giao diện...',
		'description' => $index_setting['description'],
		'thongbao' => $thongbao,
		'link_chuyen' => '/ncc/',
	);
	echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
	exit();
}
$box_menu = $skin->skin_replace('skin_ncc/box_menu', $thaythe);

$thaythe['box_menu'] = $box_menu;

echo $skin->skin_replace('skin_ncc/index', $thaythe);
