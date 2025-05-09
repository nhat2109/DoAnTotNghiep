<?php
$class_index = $tlca_do->load_skin($s, 'class_shop');
$giaodien = json_decode($index_setting['giaodien'], true);
$limit = 10;

if (isset($_COOKIE['user_id'])) {
    $box_header = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_header_login');
    $header_menu_mobile = $skin->skin_normal('skin_shop/' . $s . '/tpl/header_menu_mobile_login');
    $class_member = $tlca_do->load('class_member');
    $tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
    $user_id = $tach_token['user_id'];
    $user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
} else {
    $box_header = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_header');
    $header_menu_mobile = $skin->skin_normal('skin_shop/' . $s . '/tpl/header_menu_mobile');
}

$blank = addslashes(strip_tags($_REQUEST['blank']));
$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM sanpham_shop WHERE link='$blank' AND shop='$shop'");
$r_tt = mysqli_fetch_assoc($thongtin);
///////////////////////////////////////////////////////

// truy vấn xem sp có thuộc deal hay không
$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET('{$r_tt['id']}', main_product) AND shop ='$shop'");
$r_tt_deal = mysqli_fetch_assoc($thongtin_deal);
$sub_product_arr = json_decode($r_tt_deal['sub_product'], true);

$stmt = $conn->prepare("SELECT * FROM phanloai_sanpham_shop WHERE sp_id=?");
$stmt->bind_param("i", $r_tt['id']);
$stmt->execute();
$thongtin_phanloai = $stmt->get_result();
$max_gia_cu = 0;
$min_gia_moi = PHP_INT_MAX;
while ($r_phanloai = $thongtin_phanloai->fetch_assoc()) {
    $variant_id = $r_phanloai['id'];
    if (isset($sub_product_arr[$r_tt['id']])) {
        $max_gia_cu = 0;
        $min_gia_moi = PHP_INT_MAX; 

        foreach ($sub_product_arr[$r_tt['id']] as $variant) {
            if (isset($variant['gia_cu']) && (int) $variant['gia_cu'] > $max_gia_cu) {
                $max_gia_cu = (int) $variant['gia_cu'];
            }
            if (isset($variant['gia']) && (int) preg_replace('/[^0-9]/', '', $variant['gia']) < $min_gia_moi) {
                $min_gia_moi = (int) preg_replace('/[^0-9]/', '', $variant['gia']);
            }
        }
        $r_tt['max_gia_cu'] = $max_gia_cu;
        $r_tt['min_gia_moi'] = $min_gia_moi;
    } else {
        $gia_cu = isset($r_phanloai['gia_cu']) ? (int) $r_phanloai['gia_cu'] : 0;
        $gia_moi = isset($r_phanloai['gia_moi']) ? (int) $r_phanloai['gia_moi'] : 0;

        if ($gia_cu > $max_gia_cu) {
            $max_gia_cu = $gia_cu;
        }

        if ($gia_moi > 0 && $gia_moi < $min_gia_moi) {
            $min_gia_moi = $gia_moi;
        }
        $r_tt['max_gia_cu'] = $max_gia_cu;
        $r_tt['min_gia_moi'] = $min_gia_moi;
    }
}
/////////////////////////////////////////////////////////////

if ($r_tt['total'] == 0) {
    $thongbao = "Dữ liệu không tồn tại.";
    $replace = array(
        'title' => 'Dữ liệu không tồn tại',
        'thongbao' => $thongbao,
        'link' => '/',
    );
    echo $skin->skin_replace('skin_shop/' . $s . '/tpl/chuyenhuong', $replace);
    exit();
}

// Lấy tất cả phân loại của sản phẩm từ bảng phanloai_sanpham_shop
$sp_id = $r_tt['id'];
$thongtin_phanloai = mysqli_query($conn, "SELECT * FROM phanloai_sanpham_shop WHERE sp_id='$sp_id'");

// Khởi tạo mảng lưu trữ biến thể
$variants = [];
$colors = [];
$sizes = [];

while ($r_phanloai = mysqli_fetch_assoc($thongtin_phanloai)) {
    $variant_id = $r_phanloai['id'];
    if (isset($sub_product_arr[$r_tt['id']])) {
        foreach ($sub_product_arr[$r_tt['id']] as $variant) {
            if ($variant['variant_id'] == $variant_id) {
                $variants[] = [
                    'variant_id' => $r_phanloai['id'],
                    'color' => $r_phanloai['color'],
                    'ten_color' => $r_phanloai['ten_color'],
                    'ma_mau' => $r_phanloai['ma_mau'],
                    'size' => $r_phanloai['size'],
                    'ten_size' => $r_phanloai['ten_size'],
                    'kho' => $r_phanloai['kho_sanpham_shop'],
                    'gia_moi' => isset($variant['gia']) ? preg_replace('/[^0-9]/', '', $variant['gia']) : 0,
                    'gia_cu' => isset($variant['gia_cu']) ? (int) $variant['gia_cu'] : 0
                ];
            
                if (!isset($colors[$r_phanloai['color']])) {
                    $colors[$r_phanloai['color']] = [
                        'ten_color' => $r_phanloai['ten_color'],
                        'ma_mau' => $r_phanloai['ma_mau'],
                    ];
                }
            
                if (!isset($sizes[$r_phanloai['size']])) {
                    $sizes[$r_phanloai['size']] = [
                        'ten_size' => $r_phanloai['ten_size'],
                    ];
                }
            }
        }
    } else {
        $variants[] = [
            'variant_id' => $r_phanloai['id'],
            'color' => $r_phanloai['color'],
            'ten_color' => $r_phanloai['ten_color'],
            'ma_mau' => $r_phanloai['ma_mau'],
            'size' => $r_phanloai['size'],
            'ten_size' => $r_phanloai['ten_size'],
            'kho' => $r_phanloai['kho_sanpham_shop'],
            'gia_moi' => $r_phanloai['gia_moi'],
            'gia_cu' => $r_phanloai['gia_cu'], // Thêm gia_cu
        ];
    
        if (!isset($colors[$r_phanloai['color']])) {
            $colors[$r_phanloai['color']] = [
                'ten_color' => $r_phanloai['ten_color'],
                'ma_mau' => $r_phanloai['ma_mau'],
            ];
        }
    
        if (!isset($sizes[$r_phanloai['size']])) {
            $sizes[$r_phanloai['size']] = [
                'ten_size' => $r_phanloai['ten_size'],
            ];
        }
    }
}

// Xử lý danh sách màu
$list_mau = '';
$m = 0;
foreach ($colors as $color_id => $color_info) {
    $m++;
    $checked = $m == 1 ? 'checked' : '';
    $list_mau .= '<div class="n-sd swatch-element">
                    <input class="variant-color" id="mau-' . $color_id . '" type="radio" name="mau" value="' . $color_id . '" ' . $checked . ' data-ten-color="' . $color_info['ten_color'] . '" data-gia="' . $variants[0]['gia_moi'] . '" />
                    <label for="mau-' . $color_id . '" style="background-color: ' . $color_info['ma_mau'] . '"></label>
                  </div>';
}
$option_mau = !empty($colors) ? '<div class="select-swatch"><div class="swatch clearfix"><div class="header">Màu</div><div class="select-swap">' . $list_mau . '</div></div></div>' : '';

// Xử lý danh sách kích cỡ ban đầu
$list_size = '';
$ss = 0;
$first_color = array_key_first($colors);
foreach ($variants as $variant) {
    if ($variant['color'] == $first_color) {
        $ss++;
        $checked = $ss == 1 ? 'checked' : '';
        $list_size .= '<div class="size-swatch">
                        <input class="variant-size" id="size-' . $variant['size'] . '" type="radio" name="size" value="' . $variant['size'] . '" ' . $checked . ' data-kho="' . $variant['kho'] . '" data-gia="' . $variant['gia_moi'] . '" />
                        <label for="size-' . $variant['size'] . '">' . $variant['ten_size'] . '</label>
                        <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="' . $variant['ten_size'] . '" />
                        <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="' . $variant['ten_size'] . '" />
                      </div>';
    }
}
$option_size = !empty($sizes) ? '<div class="size-options"><label>Size:</label><div class="size-swatches">' . $list_size . '</div></div>' : '';

// Xử lý các thông tin khác
if ($r_tt['kho'] > 50) {
    $r_tt['text_flash_sale'] = '<div class="flashsale__label">còn lại <b class="flashsale__sold-qty">' . $r_tt['kho'] . '</b> sản phẩm</div>';
} else {
    $r_tt['text_flash_sale'] = '<div class="flashsale__label">🔥 Sắp hết hàng</div>';
}
$phantram = 100 - ($r_tt['kho'] / 100) * 100;
$view_new = $r_tt['view'] + 1;
mysqli_query($conn, "UPDATE sanpham_shop SET view='$view_new' WHERE id='{$r_tt['id']}' AND shop='$shop'");

$list_anh = '';
if (strlen($r_tt['anh']) > 3) {
    $tach_anh = explode(",", $r_tt['anh']);
    foreach ($tach_anh as $key => $value) {
        $pt['src'] = $value;
        $pt['tieu_de'] = $r_tt['tieu_de'];
        $list_anh .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_photo', $pt);
    }
}

$tach_menu = json_decode($class_index->list_menu($conn, $s, $r_shop['user_id']), true);
$tach_category = json_decode($class_index->list_category($conn, $r_shop['user_id']), true);
$link_xem = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (!isset($_SESSION['daxem'][$sp_id])) {
    $_SESSION['daxem'][$sp_id] = $sp_id;
}
$list_id = implode(",", $_SESSION['daxem']);

if ($r_tt['kho'] > 0 || $r_tt['kho_hang'] > 0) {
    $r_tt['tinh_trang'] = 'Còn hàng';
    $disabled = '';
    $text_button = 'Mua Ngay';
} else {
    $r_tt['tinh_trang'] = 'Hết hàng';
    $disabled = ' disabled';
    $text_button = 'Hết Hàng';
}

if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
    $giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
    $r_tt['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
} else {
    $r_tt['label_sale'] = '';
}

$list_thongso = '';
if (strlen($r_tt['thongtin']) > 3) {
    $tach_thongso = explode('|', $r_tt['thongtin']);
    foreach ($tach_thongso as $key => $value) {
        $tach_value = explode('&&', $value);
        $list_thongso .= '<tr><td width="120">' . $tach_value[0] . '</td><td>' . $tach_value[1] . '</td></tr>';
    }
} else {
    $list_thongso = '<tr><td colspan="2">Đang cập nhật</td></tr>';
}

$thuong_hieu = '';
if ($r_tt['thuong_hieu'] != '') {
    $thongtin_thuonghieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE id='{$r_tt['thuong_hieu']}'");
    $r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
    $thuong_hieu = '<div class="inve_brand"><span class="stock-brand-title"><strong>Thương hiệu:</strong></span><span class="a-brand" itemprop="brand" itemscope itemtype="https://schema.org/brand">' . $r_th['tieu_de'] . '</span></div>';
}

$hientai = time();
$where_flash = "date_start<='$hientai' AND date_end>='$hientai' AND FIND_IN_SET($sp_id,main_product) AND shop='$shop' AND loai='flash_sale'";
$thongtin_flash = mysqli_query($conn, "SELECT * FROM deal WHERE $where_flash ORDER BY id DESC LIMIT 1");
$total_flash = mysqli_num_rows($thongtin_flash);

if ($total_flash == 0) {
    $box_flash_sale = '';
    $time_conlai = 0;
    $where_deal = "date_start<='$hientai' AND date_end>='$hientai' AND FIND_IN_SET($sp_id,main_product) AND shop='$shop' AND (loai='muakem' OR loai='tang')";
    $thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE $where_deal ORDER BY id DESC LIMIT 1");
    $total_deal = mysqli_num_rows($thongtin_deal);
    if ($total_deal == 0) {
        $box_deal_soc = '';
        $loai = '';
    } else {
        $box_flash_sale = '';
        $r_deal = mysqli_fetch_assoc($thongtin_deal);
        if ($r_deal['loai'] == 'muakem') {
            $loai = 'muakem';
            $box_deal_soc = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_deal_soc');
            $sub_product = $r_deal['sub_id'];
            $tach_sub_product = json_decode($r_deal['sub_product'], true);
            $thongtin_sub_product = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($sub_product) AND shop='$shop' ORDER BY FIELD(id,$sub_product) ASC LIMIT 2");
            while ($r_sub_product = mysqli_fetch_assoc($thongtin_sub_product)) {
                $sp = $r_sub_product['id'];
                if ($tach_sub_product[$sp]['gia'] != '') {
                    if ($r_sub_product['gia_cu'] > $tach_sub_product[$sp]['gia']) {
                        $giam = ceil((($r_sub_product['gia_cu'] - preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia'])) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
                    $r_sub_product['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia']));
                } else {
                    $gia_moi = $r_sub_product['gia_moi'] - ($r_sub_product['gia_moi'] / 100) * preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['sale']);
                    if ($r_sub_product['gia_cu'] > $gia_moi) {
                        $giam = ceil((($r_sub_product['gia_cu'] - $gia_moi) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
                    $r_sub_product['gia_moi'] = number_format($gia_moi);
                }
                $list_muakem .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_muakem', $r_sub_product);
            }
        } else if ($r_deal['loai'] == 'tang') {
            $loai = 'tang';
            $box_deal_soc = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_quatang');
            $sub_product = $r_deal['sub_id'];
            $tach_sub_product = json_decode($r_deal['sub_product'], true);
            $thongtin_sub_product = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($sub_product) AND shop='$shop' ORDER BY rand() DESC LIMIT 4");
            while ($r_sub_product = mysqli_fetch_assoc($thongtin_sub_product)) {
                $sp = $r_sub_product['id'];
                if ($tach_sub_product[$sp]['gia'] != '') {
                    if ($r_sub_product['gia_cu'] > $tach_sub_product[$sp]['gia']) {
                        $giam = ceil((($r_sub_product['gia_cu'] - preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia'])) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
                    $r_sub_product['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia']));
                } else {
                    $gia_moi = $r_sub_product['gia_moi'] - ($r_sub_product['gia_moi'] / 100) * $tach_sub_product[$sp]['sale'];
                    if ($r_sub_product['gia_cu'] > $gia_moi) {
                        $giam = ceil((($r_sub_product['gia_cu'] - $gia_moi) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
                    $r_sub_product['gia_moi'] = number_format($gia_moi);
                }
                $list_muakem .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_quatang', $r_sub_product);
            }
        }
    }
} else {
    $box_flash_sale = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_flash_sale');
    $loai = 'flash_sale';
    $r_flash = mysqli_fetch_assoc($thongtin_flash);
    $time_conlai = $r_flash['date_end'] - time();
    $tach_flash_sub_product = json_decode($r_flash['sub_product'], true);
    $r_tt['gia_moi'] = preg_replace('/[^0-9]/', '', $tach_flash_sub_product[$sp_id][0]['gia']);
    $where_deal = "date_start<='$hientai' AND date_end>='$hientai' AND FIND_IN_SET($sp_id,main_product) AND shop='$shop' AND (loai='muakem' OR loai='tang')";
    $thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE $where_deal ORDER BY id DESC LIMIT 1");
    $total_deal = mysqli_num_rows($thongtin_deal);
    if ($total_deal == 0) {
        $box_deal_soc = '';
    } else {
        $r_deal = mysqli_fetch_assoc($thongtin_deal);
        if ($r_deal['loai'] == 'muakem') {
            $box_deal_soc = $skin->skin_normal('skin_shop/box_deal_soc');
            $sub_product = $r_deal['sub_id'];
            $tach_sub_product = json_decode($r_deal['sub_product'], true);
            $thongtin_sub_product = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($sub_product) AND shop='$shop' ORDER BY FIELD(id,$sub_product) ASC LIMIT 2");
            while ($r_sub_product = mysqli_fetch_assoc($thongtin_sub_product)) {
                $sp = $r_sub_product['id'];
                if ($tach_sub_product[$sp]['gia'] != '') {
                    if ($r_sub_product['gia_cu'] > $tach_sub_product[$sp]['gia']) {
                        $giam = ceil((($r_sub_product['gia_cu'] - preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia'])) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
                    $r_sub_product['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia']));
                } else {
                    $gia_moi = $r_sub_product['gia_moi'] - ($r_sub_product['gia_moi'] / 100) * $tach_sub_product[$sp]['sale'];
                    if ($r_sub_product['gia_cu'] > $gia_moi) {
                        $giam = ceil((($r_sub_product['gia_cu'] - $gia_moi) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
                    $r_sub_product['gia_moi'] = number_format($gia_moi);
                }
                $list_muakem .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_muakem', $r_sub_product);
            }
        } else if ($r_deal['loai'] == 'tang') {
            $box_deal_soc = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_quatang');
            $sub_product = $r_deal['sub_id'];
            $tach_sub_product = json_decode($r_deal['sub_product'], true);
            $thongtin_sub_product = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($sub_product) ORDER BY rand() DESC LIMIT 4");
            while ($r_sub_product = mysqli_fetch_assoc($thongtin_sub_product)) {
                $sp = $r_sub_product['id'];
                if ($tach_sub_product[$sp]['gia'] != '') {
                    if ($r_sub_product['gia_cu'] > $tach_sub_product[$sp]['gia']) {
                        $giam = ceil((($r_sub_product['gia_cu'] - preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia'])) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
                    $r_sub_product['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia']));
                } else {
                    $gia_moi = $r_sub_product['gia_moi'] - ($r_sub_product['gia_moi'] / 100) * $tach_sub_product[$sp]['sale'];
                    if ($r_sub_product['gia_cu'] > $gia_moi) {
                        $giam = ceil((($r_sub_product['gia_cu'] - $gia_moi) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu']);
                    $r_sub_product['gia_moi'] = number_format($gia_moi);
                }
                $list_muakem .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_quatang', $r_sub_product);
            }
        }
    }
}

$thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE date_start<='$hientai' AND date_end>='$hientai' AND shop='$shop' ORDER BY id DESC");
$list_flashsale_id = '';
$list_muakem_id = '';
$list_tang_id = '';
// nhatthem
// sử lí sản phẩm deal liên quan đến flash sale
$list_c = [];
$list_check_product = [];
$flash_sub_product = [];
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

// // Sửa logic tạo $list_c: Chọn deal có thời gian hết hạn muộn nhất
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

$list_muakem_id = substr($list_muakem_id, 0, -1);
$list_flashsale_id = substr($list_flashsale_id, 0, -1);
$list_tang_id = substr($list_tang_id, 0, -1);

$google_analytics = str_replace('<script>// <![CDATA[', '<script>', $index_setting['google_analytics']);
$google_analytics = str_replace('// ]]>', '', $google_analytics);
$script_chat = str_replace('<script>// <![CDATA[', '<script>', $index_setting['script_footer']);
$script_chat = str_replace('// ]]>', '', $script_chat);

// Chuẩn bị script JavaScript cho biến thể
$script_variants = '<script>
    const variants = ' . json_encode($variants) . ';

    function updatePriceAndStock() {
        const selectedColor = document.querySelector(".variant-color:checked");
        const selectedSize = document.querySelector(".variant-size:checked");
        
        if (selectedColor && selectedSize) {
            const selectedVariant = variants.find(v => 
                v.color === selectedColor.value && 
                v.size === selectedSize.value   
            );
            
            if (selectedVariant) {
                // Cập nhật giá mới
                document.getElementById("price").innerText = new Intl.NumberFormat().format(selectedVariant.gia_moi);
                
                // Cập nhật giá cũ
                document.getElementById("old-price").innerText = new Intl.NumberFormat().format(selectedVariant.gia_cu);
                
                // Cập nhật trạng thái kho
                const stockStatus = selectedVariant.kho > 0 ? "Còn hàng" : "Hết hàng";
                document.getElementById("stock-status").innerText = stockStatus;
                
                // Cập nhật nút mua ngay
                const buyButton = document.getElementById("buy-button");
                buyButton.innerText = selectedVariant.kho > 0 ? "Mua Ngay" : "Hết Hàng";
                buyButton.disabled = selectedVariant.kho <= 0;

                // Cập nhật variant-id cho nút mua ngay
                buyButton.setAttribute("data-variant-id", selectedVariant.variant_id);
            }
        }
    }

    // Xử lý sự kiện khi chọn màu
    document.querySelectorAll(".variant-color").forEach(input => {
        input.addEventListener("change", function() {
            const selectedColor = this.value;
            const sizeSwap = document.querySelector(".size-swatches");
            let sizeHtml = "";
            let firstSize = true;
            
            // Lọc các biến thể theo màu đã chọn
            const colorVariants = variants.filter(v => v.color === selectedColor);
            
            // Tạo HTML cho các size tương ứng với màu đã chọn
            colorVariants.forEach(variant => {
                const checked = firstSize ? "checked" : "";
                sizeHtml += `
                    <div class="size-swatch">
                        <input class="variant-size" id="size-${variant.size}" type="radio" name="size" value="${variant.size}" ${checked} data-kho="${variant.kho}" data-gia="${variant.gia_moi}" data-variant-id="${variant.variant_id}" />
                        <label for="size-${variant.size}">${variant.ten_size}</label>
                        <img class="crossed-out" src="/skin_shop/' . $s . '/tpl/css/images/soldout.png?v=508" alt="${variant.ten_size}" />
                        <img class="img-check" src="/skin_shop/' . $s . '/tpl/css/images/select-pro.png?v=508" alt="${variant.ten_size}" />
                    </div>`;
                firstSize = false;
            });
            
            // Cập nhật HTML cho phần size
            sizeSwap.innerHTML = sizeHtml;

            // Thêm sự kiện cho các size mới
            document.querySelectorAll(".variant-size").forEach(input => {
                input.addEventListener("change", function() {
                    // Cập nhật giá trị data-variant-id khi chọn kích thước
                    const selectedVariantId = this.getAttribute("data-variant-id");
                    $(".form-group #buy-button").attr("data-variant-id", selectedVariantId);
                    updatePriceAndStock();  // Cập nhật giá và kho
                });
            });

            // Cập nhật giá và trạng thái kho
            updatePriceAndStock();
        });
    });

    // Xử lý sự kiện khi chọn size
    document.querySelectorAll(".variant-size").forEach(input => {
        input.addEventListener("change", updatePriceAndStock);
    });

    // Khởi tạo giá và trạng thái ban đầu
    // updatePriceAndStock();
</script>';


// Đặt giá cũ ban đầu dựa trên biến thể đầu tiên
$initial_gia_cu = !empty($variants) ? $variants[0]['gia_cu'] : $r_tt['gia_cu'];

$replace = array(
    'header' => $skin->skin_normal('skin_shop/' . $s . '/tpl/header_view'),
    'box_header' => $box_header,
    'box_deal_soc' => $box_deal_soc,
    'box_flash_sale' => $box_flash_sale,
    'footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/footer'),
    'script_footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/script_footer'),
    'header_menu_mobile' => $header_menu_mobile,
    'title' => $r_tt['title'],
    'description' => $index_setting['description'],
    'site_name' => $index_setting['site_name'],
    'limit' => $limit,
    'logo' => $index_setting['logo'],
    'text_footer' => $index_setting['text_footer'],
    'google_analytics' => $google_analytics,
    'script_chat' => $script_chat,
    'script_variants' => $script_variants,
    'text_contact_footer' => $index_setting['text_contact_footer'],
    'text_about' => $index_setting['text_about'],
    'link_xem' => $link_xem,
    'email' => $index_setting['email'], 
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
    'tieu_de' => $r_tt['tieu_de'],
    'gia_moi' => number_format( $r_tt['min_gia_moi']),
    'gia_cu' => number_format($r_tt['max_gia_cu']), // Sử dụng giá cũ của biến thể đầu tiên
    'noi_bat' => $r_tt['noi_bat'],
    'noi_dung' => $r_tt['noi_dung'],
    'minh_hoa' => $r_tt['minh_hoa'],
    'list_photo' => $list_anh,
    'tinh_trang' => $r_tt['tinh_trang'],
    'option_size' => $option_size,
    'option_mau' => $option_mau,
    'thuong_hieu' => $thuong_hieu,
    'list_thongso' => $list_thongso,
    'label_sale' => $r_tt['label_sale'],
    'text_flash_sale' => $r_tt['text_flash_sale'],
    'phantram' => $phantram,
    'time_conlai' => $time_conlai,
    'list_muakem' => $list_muakem ?? '',
    'loai' => $loai,
    'variant_id' => $variant_id,
    'list_lienquan' => $class_index->list_sanpham_lienquan($conn, $s, $r_shop['user_id'], $r_tt['id'], $r_tt['cat'], $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $limit),
    'list_daxem' => $class_index->list_sanpham_daxem($conn, $s, $r_shop['user_id'], $list_id, $r_tt['id'], $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $limit),
    'sp_id' => $r_tt['id'],
    'disabled' => $disabled,
    'text_button' => $text_button,
    'link_aff' => $r_tt['link_aff'],
    'shop' => $r_shop['user_id'],
    // 'list_menu_header'=>$class_index->list_menu_header($conn, $s, $r_shop['user_id']),
);


if ($r_tt['link_aff'] != '') {
    echo $skin->skin_replace('skin_shop/' . $s . '/tpl/view_aff', $replace);
} else {
    echo $skin->skin_replace('skin_shop/' . $s . '/tpl/view', $replace);
}
?>