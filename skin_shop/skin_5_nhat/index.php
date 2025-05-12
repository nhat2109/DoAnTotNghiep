
<?php
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
    $header_menu_mobile=$skin->skin_normal('skin_shop/'.$s.'/tpl/header_menu_mobile');
}

// minhthem2404
$hientai = time();
$has_flash = 0;
$event_expiry = '';
$list_flashsale_id = '';
$list_check_product = [];
$list_c = [];
$flash_sale_expired = '';
$flash_sub_product = [];
$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE date_start<='$hientai' AND date_end>='$hientai' AND shop='$shop' ORDER BY id DESC");
$f = 0;
while ($r_d = mysqli_fetch_assoc($thongtin_deal)) {
    if ($r_d['loai'] == 'flash_sale') {
        $has_flash = 1;
        $list_flashsale_id .= $r_d['main_product'] . ',';
        $tach_m = explode(',', $r_d['main_product']);
        $tach_s = json_decode($r_d['sub_product'], true);

        
        foreach ($tach_m as $key => $value) {
            $max_gia_cu = null;
            $min_gia = null;
        
            if (isset($tach_s[$value]) && is_array($tach_s[$value])) {
                foreach ($tach_s[$value] as $variant) {
                    if (isset($variant['gia_cu'])) {
                        $gia_cu = (int) str_replace(',', '', $variant['gia_cu']);
                        if (is_null($max_gia_cu) || $gia_cu > $max_gia_cu) {
                            $max_gia_cu = $gia_cu;
                        }
                    }
                    if (isset($variant['gia'])) {
                        $gia = (int) str_replace(',', '', $variant['gia']);
                        if (is_null($min_gia) || $gia < $min_gia) {
                            $min_gia = $gia;
                        }
                    }
                }
            }

            if (!isset($list_check_product[$value])) {
                $list_check_product[$value][] = [
                    'gia_cu_max' => $max_gia_cu,
                    'gia' => $min_gia,
                    'expired' => $r_d['date_end'] 
                ];
            }
        }
        
        
        
    
        if (empty($event_expiry) || $r_d['date_end'] < $event_expiry) {
            $event_expiry = $r_d['date_end'];
        }
        $f++;
        $flash_sub_product[]=$r_d['sub_product'];

    } else if ($r_d['loai'] == 'muakem') {
        $list_muakem_id .= $r_d['main_product'] . ',';
    } else if ($r_d['loai'] == 'tang') {
        $list_tang_id .= $r_d['main_product'] . ',';
    }
}

// Sửa logic tạo $list_c: Chọn deal có thời gian hết hạn muộn nhất
foreach ($list_check_product as $product_id => $deals) {
    $latest_deal = null;

    foreach ($deals as $deal) {
        if (
            isset($deal['expired']) && 
            $deal['expired'] > $hientai && 
            (
                is_null($latest_deal) || 
                $deal['expired'] > $latest_deal['expired']
            )
        ) {
            $latest_deal = $deal;
        }
    }

    if ($latest_deal !== null) {
        $list_c[$product_id] = $latest_deal;
    }
}
//  var_dump($list_c);
//         die;
$list_muakem_id = substr($list_muakem_id, 0, -1);
$list_flashsale_id = substr($list_flashsale_id, 0, -1);
$list_tang_id = substr($list_tang_id, 0, -1);
$tach_menu = json_decode($class_index->list_menu($conn, $s, $r_shop['user_id']), true);
$tach_category = json_decode($class_index->list_category($conn, $r_shop['user_id']), true);

$thongtin_coupon = mysqli_query($conn, "SELECT * FROM coupon WHERE shop='$shop' AND start<='$hientai' AND expired>='$hientai' ORDER BY id DESC");
$total_coupon = mysqli_num_rows($thongtin_coupon);
if ($total_coupon == 0) {
    $box_coupon = '';
} else {
    $box_coupon = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_coupon');
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

//7-4
if ($index_setting['home_feature'] != '') {
    $list_feature = json_decode($index_setting['home_feature'], true);
    $r_tt = array();
    if ($list_feature && isset($list_feature['features'])) {
        foreach ($list_feature['features'] as $key => $feature) {
            $r_tt['icons_' . ($key + 1)] = $feature['icon'];
            $r_tt['titles_' . ($key + 1)] = $feature['title'];
            $r_tt['descs_' . ($key + 1)] = $feature['desc'];
        }
        $r_tt['description'] = $list_feature['description'];
    }
    $service_high_lights = $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_service_high_lights', $r_tt);
} else {
    $service_high_lights = '';
}

// Lấy 2 banner đầu (vị trí: first, 1, 2)
$banner_first = '<div class="banner_slider swiper">'; // Changed from slide_home to banner_slider
$banner_first .= '<div class="swiper-wrapper">';
$exclude_ids = [];
$i = 0;
$query_first = "SELECT * FROM banner WHERE shop_id = '{$r_shop['user_id']}' ORDER BY thu_tu ASC LIMIT 2";
// var_dump("SELECT * FROM banner WHERE shop_id = '{$r_shop['user_id']}' ORDER BY thu_tu ASC LIMIT 2");
// die;
$result_first = mysqli_query($conn, $query_first);
while ($row = mysqli_fetch_assoc($result_first)) {
    $row['blank'] = $check->blank($row['post_tieude']);
    $row['i'] = ++$i;
    $banner_first .= $skin->skin_replace("skin_shop/skin_5_nhat/tpl/banner_conntent", $row);
    $exclude_ids[] = (int)$row['id'];
}
$banner_first .= '</div>';
$banner_first .= '<div class="swiper-pagination"></div>';
// $banner_first .= '<div class="swiper-button-prev"></div>';
// $banner_first .= '<div class="swiper-button-next"></div>';
$banner_first .= '</div>';


// end banerfirst
$banner_two = '<div class="banner_slider swiper">'; // Changed from slide_home to banner_slider
$banner_two .= '<div class="swiper-wrapper">';
$ids = implode(',', $exclude_ids);
$query_second = "SELECT * FROM banner WHERE shop_id = '{$r_shop['user_id']}' AND id NOT IN ($ids) ORDER BY thu_tu ASC LIMIT 2";
$result_second = mysqli_query($conn, $query_second);
while ($row = mysqli_fetch_assoc($result_second)) {
    $row['blank'] = $check->blank($row['post_tieude']);
    $row['i'] = ++$i;
    $banner_two .= $skin->skin_replace("skin_shop/skin_5_nhat/tpl/banner_conntent", $row);
}
$banner_two .= '</div>';
$banner_two .= '<div class="swiper-pagination"></div>';
// $banner_two .= '<div class="swiper-button-prev"></div>';
// $banner_two .= '<div class="swiper-button-next"></div>';
$banner_two .= '</div>';;



$google_analytics = str_replace('<script>// <![CDATA[', '<script>', $index_setting['google_analytics']);
$google_analytics = str_replace('// ]]>', '', $google_analytics);
$script_chat = str_replace('<script>// <![CDATA[', '<script>', $index_setting['script_footer']);
$script_chat = str_replace('// ]]>', '', $script_chat);
$tach_tintuc = json_decode($class_index->list_tintuc($conn, $s, $shop, 1, 4), true);
$replace = array(
    'header' => $skin->skin_normal('skin_shop/skin_5_nhat/tpl/header'),
    'box_header' => $box_header,
    'box_coupon' => $box_coupon,
    'box_flash_sale' => $box_flash_sale,
    'footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/footer'),
    'script_footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/script_footer'),
    'box_banner' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_banner'),
    'banner_firts' => $banner_first,
    'banner_two' => $banner_two,
    'header_menu_mobile' => $header_menu_mobile,
    'title' => $index_setting['title'],
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
    'email' => $index_setting['email'], 
    'link_instagram' => $index_setting['link_instagram'],
    'bg_backgroud' => $giaodien['background'],
    'bg_header' => $giaodien['header'],
    'bg_topbar' => $giaodien['topbar'],
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
    'list_tintuc' => $class_index->list_tintuc($conn, $s, $shop, 1, 4),
    'list_slide' => $class_index->list_slide($conn, $s, $r_shop['user_id']),
    'list_box_index' => $class_index->list_box_index($conn, $s, $shop, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c),
    'list_coupon' => $list_coupon,
    'list_flash_sale' => $list_flashsale,
    'flash_sale_expired' => is_numeric($event_expiry) ? date('c', (int)$event_expiry) : null,
    'photo' => $index_setting['photo'],
    'phantrang' => $phantrang,
    'fanpage' => $index_setting['fanpage'],
    'name' => $user_info['name'],
    'avatar' => $user_info['avatar'],
    'shop' => $r_shop['user_id'],
    'list_tintuc_left' => $tach_tintuc['left'],
	'list_tintuc_right' => $tach_tintuc['right'],
    'service_high_lights' => $service_high_lights,
   
    'list_user_feedbacks' => $class_index->list_user_feedbacks($conn, $s, $r_shop['user_id']),
    'bg_hotline'=>$giaodien['hotline'],
);

echo $skin->skin_replace('skin_shop/' . $s . '/tpl/index', $replace);
?>  