<?php
session_start();
$class_index = $tlca_do->load_skin($s, 'class_shop');
$giaodien = json_decode($index_setting['giaodien'], true);
$limit = 48;
if (isset($_COOKIE['user_id'])) {
	$box_header = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_header_login');
	$header_menu_mobile = $skin->skin_normal('skin_shop/' . $s . '/tpl/header_menu_mobile_login');
	$class_member = $tlca_do->load('class_member');
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
} else {
	$box_header = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_header');
	$header_menu_mobile = $skin->skin_normal('skin_shop/' . $s . '/header_menu_mobile');
}
$hientai = time();
$has_flash = 0;

$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE date_start<='$hientai' AND date_end>='$hientai' AND shop='$shop' AND loai='flash_sale' ORDER BY id DESC");
$f = 0;
while ($r_d = mysqli_fetch_assoc($thongtin_deal)) {
	if ($r_d['loai'] == 'flash_sale') {
		$has_flash = 1;
		$list_flashsale_id .= $r_d['main_product'] . ',';
		$tach_m = explode(',', $r_d['main_product']);
		$tach_s = json_decode($r_d['sub_product'], true);
		foreach ($tach_m as $key => $value) {
			$list_check_product[$value][$f]['expired'] = $r_d['date_end'];
			$list_check_product[$value][$f]['gia'] = $tach_s[$value]['gia'];
		}
		$f++;
	} else if ($r_d['loai'] == 'muakem') {
		$list_muakem_id .= $r_d['main_product'] . ',';
	} else if ($r_d['loai'] == 'tang') {
		$list_tang_id .= $r_d['main_product'] . ',';
	}
}
foreach ($list_check_product as $key => $value) {
	$x = 0;
	foreach ($value as $k => $v) {
		if ($x == 0) {
			$list_c[$key] = $v;
		}
		$x++;
	}
	$x = 0;
}
$blank = addslashes(strip_tags($_REQUEST['blank']));
$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total,(SELECT kho FROM sanpham WHERE sanpham.id=sanpham_shop.sp_id ORDER BY id DESC LIMIT 1) AS kho FROM sanpham_shop WHERE link='$blank' AND shop='$shop'");
$r_tt_mau = mysqli_fetch_assoc($thongtin);
if ($r_tt_mau['mau'] != '') {
	$mau = $r_tt_mau['mau'];
	$thongtin_mau = mysqli_query($conn, "SELECT * FROM mau_sanpham WHERE id IN($mau) ORDER BY thu_tu ASC");
	$m = 0;
	while ($r_m = mysqli_fetch_assoc($thongtin_mau)) {
		$m++;
		if ($m == 1) {
			$list_mau .= '<div class="n-sd swatch-element">
	                        <input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '" checked />
	                        <label for="mau-' . $r_m['id'] . '">
	                            ' . $r_m['tieu_de'] . '
	                            <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
	                            <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
	                        </label>
	                    </div>';
		} else {
			$list_mau .= '<div class="n-sd swatch-element">
	                        <input class="variant-0" id="mau-' . $r_m['id'] . '" type="radio" name="mau" value="' . $r_m['tieu_de'] . '"/>
	                        <label for="mau-' . $r_m['id'] . '">
	                            ' . $r_m['tieu_de'] . '
	                            <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $r_m['tieu_de'] . '" />
	                            <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $r_m['tieu_de'] . '" />
	                        </label>
	                    </div>';
		}
	}
	$option_mau = '<div class="swatch-div">
                    <div id="variant-swatch-0 "   class="swatch clearfix swatch clearfix swatch-color">
                        <div class="header">Màu sắc:</div>
                        <div class="select-swap">
                        ' . $list_mau . '
                        </div>
                    </div>
                </div>';
} else {
	$option_mau = '';
}

$list_muakem_id = substr($list_muakem_id, 0, -1);
$list_flashsale_id = substr($list_flashsale_id, 0, -1);
$list_tang_id = substr($list_tang_id, 0, -1);
$tach_menu = json_decode($class_index->list_menu($conn, $s, $r_shop['user_id']), true);
$tach_category = json_decode($class_index->list_category($conn, $r_shop['user_id']), true);

if ($r_cat['cat_main'] == 0) {
	$list_category_sub = $tach_category['list_main'];
} else {
	$thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_cat['cat_id']}' AND shop='{$r_shop['user_id']}'");
	$total_sub = mysqli_num_rows($thongtin_sub);
	if ($total_sub > 0) {
		while ($r_sub = mysqli_fetch_assoc($thongtin_sub)) {
			$list_category_sub .= '<li class=""><a href="/san-pham/' . $r_sub['cat_blank'] . '.html" class="nav-link" title="' . $r_sub['cat_tieude'] . '">' . $r_sub['cat_tieude'] . '</a></li>';
		}
	} else {
		$thongtin_sub_main = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_cat['cat_main']}' AND shop='{$r_shop['user_id']}'");
		while ($r_sub_main = mysqli_fetch_assoc($thongtin_sub_main)) {
			if ($r_cat['cat_id'] == $r_sub_main['cat_id']) {
				$list_category_sub .= '<li class="active"><a href="/san-pham/' . $r_sub_main['cat_blank'] . '.html" class="nav-link" title="' . $r_sub_main['cat_tieude'] . '">' . $r_sub_main['cat_tieude'] . '</a></li>';
			} else {
				$list_category_sub .= '<li class=""><a href="/san-pham/' . $r_sub_main['cat_blank'] . '.html" class="nav-link" title="' . $r_sub_main['cat_tieude'] . '">' . $r_sub_main['cat_tieude'] . '</a></li>';
			}
		}
	}
}
$thongtin_coupon = mysqli_query($conn, "SELECT * FROM coupon WHERE shop='$shop' AND start<='$hientai' AND expired>='$hientai' ORDER BY id DESC");
// print_r($thongtin_coupon);
// exit();
$total_coupon = mysqli_num_rows($thongtin_coupon);
if ($total_coupon == 0) {
	$box_coupon = '';
} else {
	$box_coupon = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_coupons');
	while ($r_cp = mysqli_fetch_assoc($thongtin_coupon)) {
		if ($r_cp['loai'] == 'phantram') {
			$r_cp['giam'] = $r_cp['giam'] . '%';
		} else {
			$r_cp['giam'] = number_format($r_cp['giam']) . 'đ';
		}
		$r_cp['expired'] = date('H:i d/m/Y', $r_cp['expired']);
		$list_coupon .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_coupon', $r_cp);
	}
}

if ($has_flash == 1) {
	$box_flash_sale = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_flash_sale_index');
	$list_flashsale = $class_index->list_flashsale($conn, $s, $shop, $list_flashsale_id, $list_c);
} else {
	$box_flash_sale = '';
	$list_flashsale = '';
}

if (empty($list_flashsale_id)) {
    $thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE shop='$shop' ORDER BY id DESC");
} else {
    $thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_flashsale_id) AND shop='$shop' ORDER BY id DESC");
}

while ($r_tt = mysqli_fetch_assoc($thongtin)) {
	$id_sp = $r_tt['id'];
	$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
	/*            if($r_tt['gia_cu']>$r_tt['gia_moi']){
                $giam=ceil((($r_tt['gia_cu'] - $r_tt['gia_moi'])/$r_tt['gia_cu'])*100);
                $r_tt['label_sale']='<span class="label-product label-sale">'.$giam.'%</span>';
            }else{
                $r_tt['label_sale']='';
            }*/
	// Xử lý giảm giá
	if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
		$giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);



		$r_tt['label_sale'] = '<span class="label-product label-sale">' . $giam . '%</span>';
	} else {
		$r_tt['label_sale'] = '';
	}
}

// $list = $countdown_data['list'],
$google_analytics = str_replace('<script>// <![CDATA[', '<script>', $index_setting['google_analytics']);
$google_analytics = str_replace('// ]]>', '', $google_analytics);
$script_chat = str_replace('<script>// <![CDATA[', '<script>', $index_setting['script_footer']);
$script_chat = str_replace('// ]]>', '', $script_chat);
$tach_tintuc = json_decode($class_index->list_tintuc($conn, $s, $shop, 1, 5), true);
// echo '<pre>';
// print_r($index_setting['banner_2']);
// echo '</pre>';
// exit();
$sql = "SELECT name, value FROM index_setting WHERE name IN ('banner_mot', 'banner_2','banner_mot_text', 'banner_2_text', 'modal_header', 'noidung_header', 'flashsale_banner', 'nhung_map', 'email')";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[$row['name']] = $row['value'];
}
// Lưu giá trị vào session
$_SESSION['modal_header'] = $data['modal_header'];
$_SESSION['flashsale_banner'] = $data['flashsale_banner'];
$_SESSION['nhung_map'] = $data['nhung_map'];
$_SESSION['email_lienhe'] = $data['email'];
$_SESSION['noidung_header'] = $data['noidung_header']; // Ghi đè giá trị của noidung_header

// xử lý domain ra ngoài
// Lấy user_id từ session hoặc cookie


// $user_id = 2; // Đặt user_id là 2

// if ($user_id) {
//     $sql = "SELECT domain FROM user_info WHERE user_id = '$user_id'";
//     $result = mysqli_query($conn, $sql);

//     if (!$result) {
//         die("Lỗi truy vấn: " . mysqli_error($conn));
//     }

//     $domain = '';
//     if ($row = mysqli_fetch_assoc($result)) {
//         $domain = $row['domain'];
//         $_SESSION['domain'] = $domain;
//     }

//     // Thêm giá trị domain vào biến $replace
//     $replace['domain'] = $domain;
// }
// printf($domain);
// exit();
// $list_photo = $_SESSION['list_photo'];
// $list_photo_1 = $_SESSION['list_photo_1'];
$replace = array(
	'list_photo' => $list_anh,
	'list_photo_1' => $list_anh_1,
	'domain' => $replace['domain'] ?? '', // Thêm giá trị domain vào biến $replace
	'list_chungnhan' => $class_index->list_chung_nhan($conn, $s, $shop,$r_shop['user_id'], $brand),
	'box_brand' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_brand'),
	'box_banner' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_banner'),


	'box_coupons' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_coupons'),
	'box_coupon' => $box_coupon,
	'list_coupon' => $list_coupon,
	'header' => $skin->skin_normal('skin_shop/' . $s . '/tpl/header'),
	'box_header' => $box_header,
	'box_slide' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_slide'),
	'box_category' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_category'),
	'box_flashsales' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_flashsales'),
	'box_lookbook' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_lookbook'),
	'box_imagetext' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_imagetext'),
	'box_blog' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_blog'),
	'box_policies' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_policies'),
	'box_flash_sale' => $box_flash_sale,
	'footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/footer'),
	'script_footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/script_footer'),
	'header_menu_mobile' => $header_menu_mobile,
	'title' => $index_setting['title'],
	'label_sale' => $r_tt['label_sale'],
	'description' => $index_setting['description'],
	'site_name' => $index_setting['site_name'],
	'limit' => $limit,
	'logo' => $index_setting['logo'],
	'text_footer' => $index_setting['text_footer'],
	'google_analytics' => $google_analytics,
	'script_chat' => $script_chat,
	'text_contact_footer' => $index_setting['text_contact_footer'],
	'text_about' => $index_setting['text_about'],
	'link_xem' => $index_setting['link_domain'],
	'hotline' => $index_setting['hotline'],
	'hotline_number' => preg_replace('/[^0-9]/', '', $index_setting['hotline']),
	'text_hotline' => $index_setting['text_hotline'],
	'link_facebook' => $index_setting['link_facebook'],
	'link_google' => $index_setting['link_google'],
	'link_youtube' => $index_setting['link_youtube'],
	'link_twitter' => $index_setting['link_twitter'],
	'link_instagram' => $index_setting['link_instagram'],
	'bg_backgroud' => $giaodien['background'],
	'bg_header' => $giaodien['header'],
	'bg_topbar' => $giaodien['topbar'],
	'bg_hotline' => $giaodien['hotline'],
	'bg_menu' => $giaodien['menu'],
	'option_mau' => $option_mau,
	'bg_title_menu' => $giaodien['title_menu'],
	'bg_title_box' => $giaodien['title_box'],
	'bg_button_top' => $giaodien['button_top'],
	'bg_subcribe' => $giaodien['subcribe'],
	'bg_top_menu_mobile' => $giaodien['top_menu_mobile'],
	'bg_label_sale' => $giaodien['label_sale'],
	'bg_ma_giamgia' => $giaodien['ma_giamgia'],
	'bg_top_footer' => $giaodien['top_footer'],
	'bg_bottom_footer' => $giaodien['bottom_footer'],
	'color_text_top_footer' => $giaodien['text_top_footer'],
	'color_text_bottom_footer' => $giaodien['text_bottom_footer'],
	'bg_timkiem' => $giaodien['timkiem'],
	'bg_nhantin' => $giaodien['nhantin'],
	'color_text_title_top_footer' => $giaodien['text_title_top_footer'],
	'menu_chinhsach' => $tach_menu['chinhsach'],
	'menu_huongdan' => $tach_menu['huongdan'],
	'menu_top' => $tach_menu['top'],
	'menu_mobile' => $tach_menu['menu_mobile'],
	'category_mobile' => $class_index->list_category_sanpham_mobile($conn, $r_shop['user_id']),
	'list_category_nav' => $tach_category['list'],
	'list_category_left' => $tach_category['list_left'],
	'list_category_sub' => $list_category_sub,
	'list_tintuc' => $class_index->list_tintuc($conn, $s, $shop, 1, 5),
	'list_slide' => $class_index->list_slide($conn, $s, $r_shop['user_id']),
	'list_box_index' => $class_index->list_box_index($conn, $s, $shop, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c),
	'list_box_index_1' => $class_index->list_box_index_1($conn, $s, $shop, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c),
	'list_box_index_2' => $class_index->list_box_index_2($conn, $s, $shop, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c),
	'list_giamgia' => $class_index->list_sanpham_giamgia($conn, $s, $r_shop['user_id'], $r_tt['id'], $r_tt['cat'], $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $limit),
	'list_flash_sale' => $list_flashsale,

	'photo' => $index_setting['photo'],
	'phantrang' => $phantrang,
	'fanpage' => $index_setting['fanpage'],
	'name' => $user_info['name'],
	'avatar' => $user_info['avatar'],
	'tongtien' => number_format($tongtien),
	'shop' => $r_shop['user_id'],
	'list_thuonghieu' => $class_index->list_brand($conn, $s, $r_shop['user_id'], $brand),
	'banner_mot' => $data['banner_mot'], // Ghi đè giá trị của banner_mot
	'noidung_header' => $data['noidung_header'], // Ghi đè giá trị của noidung_header
    'banner_2' => $data['banner_2'], // Ghi đè giá trị của banner_2
	'banner_mot_text' => $data['banner_mot_text'], // Ghi đè giá trị của banner_mot
    'banner_2_text' => $data['banner_2_text'], // Ghi đè giá trị của banner_2
	'modal_header' => $_SESSION['modal_header'], // Ghi đè giá trị của modal_header
	
);

$sql = "SELECT link, minh_hoa, title FROM sanpham_shop WHERE shop = '$shop' ORDER BY RAND() LIMIT 5";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

$salePopArr = [];
while ($row = mysqli_fetch_assoc($result)) {
    $salePopArr[] = [
        'img_url' => $row['minh_hoa'],
        'pd_title' => $row['title'],
        'pd_url' => $row['link']
    ];
}

$current_dir = dirname(__FILE__);
$file = $current_dir . '/salePopArr.json';
file_put_contents($file, json_encode($salePopArr));

echo $skin->skin_replace('skin_shop/' . $s . '/tpl/index', $replace);
?>