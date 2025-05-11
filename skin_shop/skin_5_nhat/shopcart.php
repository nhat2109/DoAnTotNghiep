<?php
$class_index = $tlca_do->load_skin($s, 'class_shop');
$giaodien = json_decode($index_setting['giaodien'], true);

if (count((array)$_SESSION['cart']) == 0) {
    $thongbao = "Giỏ hàng trống.";
    $replace = array(
        'title' => 'Giỏ hàng trống',
        'thongbao' => $thongbao,
        'link' => '/'
    );
    echo $skin->skin_replace('skin_shop/' . $s . '/tpl/chuyenhuong', $replace);
    exit();
}
if(isset($_COOKIE['user_id'])){
	$box_header=$skin->skin_normal('skin_shop/'.$s.'/tpl/box_header_login');
	$header_menu_mobile=$skin->skin_normal('skin_shop/'.$s.'/tpl/header_menu_mobile_login');
	$class_member=$tlca_do->load('class_member');
	$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
	$user_id=$tach_token['user_id'];
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
}else{
	$box_header=$skin->skin_normal('skin_shop/'.$s.'/tpl/box_header');
	$header_menu_mobile=$skin->skin_normal('skin_shop/'.$s.'/tpl/header_menu_mobile');
}
$hientai = time();
$tongtien = 0;
$list_shopcart = '';
$list_shopcart_mobile = '';

if (isset($_SESSION['muakem'])) {
    foreach ($_SESSION['main_product'] as $key => $value) {
        $list_main_id .= $value . ',';
        $thongtin_muakem = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($value,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='$shop' ORDER BY id DESC LIMIT 1");
        $r_mk = mysqli_fetch_assoc($thongtin_muakem);
        $list_id_mk .= $r_mk['sub_id'] . ',';
        $list_sub_product[] = json_decode($r_mk['sub_product'], true);
    }
    foreach ($list_sub_product as $key => $value) {
        foreach ($value as $k => $v) {
            $list_s[$k] = $v;
        }
    }
    $list_main_id = substr($list_main_id, 0, -1);
    $tach_list_main_id = explode(',', $list_main_id);
    $list_id_mk = substr($list_id_mk, 0, -1);
    $tach_list_id_mk = explode(',', $list_id_mk);

    $list_id = '';
    $list_check_product = [];
    foreach ($_SESSION['cart'] as $key => $value) {
        if (isset($value['sp_id']) && !empty($value['sp_id'])) {
            $list_id .= $value['sp_id'] . ',';
        }
        if (isset($value['flash_sale']) && $value['flash_sale'] == 1 && isset($value['sp_id'])) {
            $thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET(" . $value['sp_id'] . ",main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
            $r_ck = mysqli_fetch_assoc($thongtin_check);
            $list_check_product[] = json_decode($r_ck['sub_product'], true);
        }
    }

    $list_c = [];
    foreach ($list_check_product as $key => $value) {
        foreach ($value as $k => $v) {
            $list_c[$k] = $v;
        }
    }

    if (empty($list_id)) {
        $thongbao = "Không có sản phẩm hợp lệ trong giỏ hàng.";
        $replace = array(
            'title' => 'Giỏ hàng trống',
            'thongbao' => $thongbao,
            'link' => '/'
        );
        echo $skin->skin_replace('skin_shop/' . $s . '/tpl/chuyenhuong', $replace);
        exit();
    }

    $list_id = substr($list_id, 0, -1);
    $thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id)");

    while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
        $id_sp = $r_cart['id'];
        foreach ($_SESSION['cart'] as $key => $value) {
            if (isset($value['sp_id']) && $value['sp_id'] == $id_sp) {
                $r_cart['quantity'] = $value['quantity'];
                $r_cart['color'] = $value['color'] ?? '';
                $r_cart['size'] = $value['size'] ?? '';
                $_SESSION['cart'][$key]['ten_color'] = $value['ten_color'] ?? ''; // Lưu tên màu
                $_SESSION['cart'][$key]['ten_size'] = $value['ten_size'] ?? '';   // Lưu tên kích thước

                if (isset($value['tang']) && $value['tang'] == 1) {
                    $r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
                    $tongtien += 0;
                    $r_cart['thanhtien'] = 0;
                    $r_cart['gia_moi'] = 0;
                    $r_cart['variant_info'] = '';
                    $_SESSION['cart'][$key]['gia_moi'] = 0; // Lưu giá mới
                    $_SESSION['cart'][$key]['thanhtien'] = 0;
                    $list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
                    $list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
                } elseif (in_array($id_sp, $tach_list_id_mk)) {
                    $r_cart['ten_sanpham'] = '<span class="color_red">[Deal sốc]</span> ' . $r_cart['tieu_de'];
                    if ($list_s[$id_sp]['gia'] != '') {
                        $gia_deal = preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']);
                        $tongtien += $gia_deal * $value['quantity'];
                        $r_cart['thanhtien'] = number_format($gia_deal * $value['quantity']);
                        $r_cart['gia_moi'] = number_format($gia_deal);
                        $_SESSION['cart'][$key]['gia_moi'] = $gia_deal; // Lưu giá mới
                        $_SESSION['cart'][$key]['thanhtien'] = $gia_deal * $value['quantity'];
                    } else {
                        $gia_moi = $r_cart['gia_moi'] - ($r_cart['gia_moi'] / 100) * $list_s[$id_sp]['sale'];
                        $tongtien += $gia_moi * $value['quantity'];
                        $r_cart['thanhtien'] = number_format($gia_moi * $value['quantity']);
                        $r_cart['gia_moi'] = number_format($gia_moi);
                        $_SESSION['cart'][$key]['gia_moi'] = $gia_moi; // Lưu giá mới
                        $_SESSION['cart'][$key]['thanhtien'] = $gia_moi * $value['quantity'];
                    }
                    $r_cart['variant_info'] = 'Màu: ' . ($value['ten_color'] ?? '') . ' - Size: ' . ($value['ten_size'] ?? '');
                    $list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
                    $list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
                } elseif (isset($list_c[$id_sp])) {
                    $r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
                    $gia_flash = preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']);
                    $tongtien += $gia_flash * $value['quantity'];
                    $r_cart['thanhtien'] = number_format($gia_flash * $value['quantity']);
                    $r_cart['gia_moi'] = number_format($gia_flash);
                    $_SESSION['cart'][$key]['gia_moi'] = $gia_flash; // Lưu giá mới
                    $_SESSION['cart'][$key]['thanhtien'] = $gia_flash * $value['quantity'];
                    $r_cart['variant_info'] = 'Màu: ' . ($value['ten_color'] ?? '') . ' - Size: ' . ($value['ten_size'] ?? '');
                    $list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
                    $list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
                } else {
                    $r_cart['ten_sanpham'] = $r_cart['tieu_de'];
                    $gia_variant = $value['gia_moi'] ?? $r_cart['gia_moi'];
                    $tongtien += $gia_variant * $value['quantity'];
                    $r_cart['thanhtien'] = number_format($gia_variant * $value['quantity']);
                    $r_cart['gia_moi'] = number_format($gia_variant);
                    $_SESSION['cart'][$key]['gia_moi'] = $gia_variant; // Lưu giá mới
                    $_SESSION['cart'][$key]['thanhtien'] = $gia_variant * $value['quantity'];
                    $r_cart['variant_info'] = 'Màu: ' . ($value['ten_color'] ?? '') . ' - Size: ' . ($value['ten_size'] ?? '');
                    $list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
                    $list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
                }
            }
        }
    }
} else {
    $list_id = '';
    $list_check_product = [];
    foreach ($_SESSION['cart'] as $key => $value) {
        if (isset($value['sp_id']) && !empty($value['sp_id'])) {
            $list_id .= $value['sp_id'] . ',';
        }
        if (isset($value['flash_sale']) && $value['flash_sale'] == 1 && isset($value['sp_id'])) {
            $thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET(" . $value['sp_id'] . ",main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
            $r_ck = mysqli_fetch_assoc($thongtin_check);
            $list_check_product[] = json_decode($r_ck['sub_product'], true);
        }
    }
    $list_c = [];
    foreach ($list_check_product as $key => $value) {
        foreach ($value as $k => $v) {
            $list_c[$k] = $v;
        }
    }
    if (is_array($list_c[$sp_id][0])) {
		foreach ($list_c[$sp_id] as $variant) {
			if ((int)$variant['variant_id'] === (int)$variant_id) {
				$price_deal = $variant['gia'];
			}
		}
	}
    if (empty($list_id)) {
        $thongbao = "Không có sản phẩm hợp lệ trong giỏ hàng.";
        $replace = array(
            'title' => 'Giỏ hàng trống',
            'thongbao' => $thongbao,
            'link' => '/'
        );
        echo $skin->skin_replace('skin_shop/' . $s . '/tpl/chuyenhuong', $replace);
        exit();
    }

    $list_id = substr($list_id, 0, -1);
    $thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id)");
    while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
        $id_sp = $r_cart['id'];
        foreach ($_SESSION['cart'] as $key => $value) {

            if (isset($value['sp_id']) && $value['sp_id'] == $id_sp) {
                $r_cart['quantity'] = $value['quantity'];
                $r_cart['color'] = $value['color'] ?? '';
                $r_cart['size'] = $value['size'] ?? '';
                $_SESSION['cart'][$key]['ten_color'] = $value['ten_color'] ?? ''; // Lưu tên màu
                $_SESSION['cart'][$key]['ten_size'] = $value['ten_size'] ?? '';   // Lưu tên kích thước

                if (isset($value['tang']) && $value['tang'] == 1) {
                    $r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
                    $tongtien += 0;
                    $r_cart['thanhtien'] = 0;
                    $r_cart['gia_moi'] = 0;
                    $r_cart['variant_info'] = '';
                    $_SESSION['cart'][$key]['gia_moi'] = 0; // Lưu giá mới
                    $_SESSION['cart'][$key]['thanhtien'] = 0;
                    $list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_tang', $r_cart);
                    $list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile_tang', $r_cart);
                } elseif (isset($list_c[$id_sp])) {
                    $r_cart['ten_sanpham'] = '<span class="color_red">[Flash Sale]</span> ' . $r_cart['tieu_de'];
                    if ($list_c[$value['sp_id']][0]) {
                            foreach ($list_c[$value['sp_id']] as $variant) {
                                if ((int)$variant['variant_id'] === (int)$value['variant_id']) {
                                    $gia_flash = $variant['gia'];
                                }
                            }
                        }
                    $tongtien += $gia_flash* $value['quantity'];
                    $r_cart['thanhtien'] = number_format($gia_flash * $value['quantity']);
                    $r_cart['gia_moi'] = number_format($gia_flash);
                    $_SESSION['cart'][$key]['gia_moi'] = $gia_flash; // Lưu giá mới
                    $_SESSION['cart'][$key]['thanhtien'] = $gia_flash * $value['quantity'];
                    $r_cart['variant_info'] = 'Màu: ' . ($value['ten_color'] ?? '') . ' - Size: ' . ($value['ten_size'] ?? '');
                    $list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
                    $list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
                } else {
                    $r_cart['ten_sanpham'] = $r_cart['tieu_de'];
                    $gia_variant = $value['gia_moi'] ?? $r_cart['gia_moi'];
                    $tongtien += $gia_variant * $value['quantity'];
                    $r_cart['thanhtien'] = number_format($gia_variant * $value['quantity']);
                    $r_cart['gia_moi'] = number_format($gia_variant);
                    $_SESSION['cart'][$key]['gia_moi'] = $gia_variant; // Lưu giá mới
                    $_SESSION['cart'][$key]['thanhtien'] = $gia_variant * $value['quantity'];
                    $r_cart['variant_info'] = 'Màu: ' . ($value['ten_color'] ?? '') . ' - Size: ' . ($value['ten_size'] ?? '');
                    $list_shopcart .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart', $r_cart);
                    $list_shopcart_mobile .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_shopcart_mobile', $r_cart);
                }
            }
        }
    }
}

$limit = 10;



$tach_menu = json_decode($class_index->list_menu($conn, $s, $r_shop['user_id']), true);
$tach_category = json_decode($class_index->list_category($conn, $r_shop['user_id']), true);
$link_xem = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$google_analytics = str_replace('<script>// <![CDATA[', '<script>', $index_setting['google_analytics']);
$google_analytics = str_replace('// ]]>', '', $google_analytics);
$script_chat = str_replace('<script>// <![CDATA[', '<script>', $index_setting['script_footer']);
$script_chat = str_replace('// ]]>', '', $script_chat);

$replace = array(
    'header' => $skin->skin_normal('skin_shop/' . $s . '/tpl/header'),
    'box_header' => $box_header,
    'footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/footer'),
    'script_footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/script_footer'),
    'header_menu_mobile' => $header_menu_mobile,
    'title' => 'Giỏ hàng',
    'description' => $index_setting['description'],
    'site_name' => $index_setting['site_name'],
    'limit' => $limit,
    'logo' => $index_setting['logo'],
    'text_footer' => $index_setting['text_footer'],
    'google_analytics' => $google_analytics,
    'script_chat' => $script_chat,
    'text_contact_footer' => $index_setting['text_contact_footer'],
    'text_about' => $index_setting['text_about'],
    'link_xem' => $link_xem,
    'email' => $index_setting['email'], 
    'hotline' => $index_setting['hotline'],
    'text_hotline' => $index_setting['text_hotline'],
    'hotline_number' => preg_replace('/[^0-9]/', '', $index_setting['hotline']),
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
    'lienhe' => $index_setting['lienhe'],
    'photo' => $index_setting['photo'],
    'phantrang' => $phantrang,
    'fanpage' => $index_setting['fanpage'],
    'name' => $user_info['name'] ?? '',
    'avatar' => $user_info['avatar'] ?? '',
    'gioithieu' => $index_setting['gioithieu'],
    'list_shopcart' => $list_shopcart,
    'list_shopcart_mobile' => $list_shopcart_mobile,
    'tongtien' => number_format($tongtien),
    'tamtinh' => number_format($tongtien),
    'shop' => $r_shop['user_id'],
);

echo $skin->skin_replace('skin_shop/' . $s . '/tpl/shopcart', $replace);