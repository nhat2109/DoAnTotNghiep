<?php
$web = $_SERVER['HTTP_HOST'];
$web = str_replace('www.', '', $web);
$web_root = array('doantotnghiep.vn', 'socdo.vn', 'socmoi.vn', 'soc.vn', 'beta.socdo.vn');
if (in_array($web, $web_root) == false) {
    include('./shop/view.php');
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
$limit = 10;

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

// Lấy blank từ URL để xác định sản phẩm
$blank = addslashes(strip_tags($_REQUEST['blank']));
if (empty($blank)) {
    $thongbao = "Sản phẩm không tồn tại.";
    $replace = array(
        'title' => 'Sản phẩm không tồn tại',
        'thongbao' => $thongbao,
        'link' => '/'
    );
    echo $skin->skin_replace('skin/chuyenhuong', $replace);
    exit();
}

// Truy vấn sản phẩm dựa trên link, dùng LEFT JOIN để lấy dữ liệu sản phẩm ngay cả khi không có shop
$thongtin = mysqli_query($conn, "SELECT sp.*, COUNT(*) AS total 
                                 FROM sanpham sp 
                                 LEFT JOIN user_info ui ON sp.shop = ui.user_id 
                                 WHERE sp.link='$blank' 
                                 ORDER BY sp.id DESC 
                                 LIMIT 1");
$r_tt = mysqli_fetch_assoc($thongtin);

// Kiểm tra nếu không có sản phẩm thì thoát với thông báo lỗi
if ($r_tt['total'] == 0) {
    $thongbao = "Sản phẩm không tồn tại.";
    $replace = array(
        'title' => 'Sản phẩm không tồn tại',
        'thongbao' => $thongbao,
        'link' => '/'
    );
    echo $skin->skin_replace('skin/chuyenhuong', $replace);
    exit();
}

// Lấy shop_id từ sản phẩm (nếu có)
$shop_id = !empty($r_tt['shop']) ? $r_tt['shop'] : null;

// Xử lý ảnh sản phẩm
if (strlen($r_tt['anh']) > 3) {
    $tach_anh = explode(",", $r_tt['anh']);
    $im = 0;
    $km = 0;
    foreach ($tach_anh as $key => $value) {
        $im++;
        if ($im == 1) {
            $img_big = '<a href="' . $value . '" onclick="return:false;"><img src="' . $value . '" class="bk-product-image">';
        }
        $pt['src'] = $value;
        $pt['tieu_de'] = $r_tt['tieu_de'];
        $pt['i'] = $km;
        $pt['active'] = ($km == 0) ? 'active' : '';
        $list_big .= $skin->skin_replace('skin/box_li/li_big', $pt);
        $list_small .= $skin->skin_replace('skin/box_li/li_small', $pt);
        $km++;
    }
}

// Xử lý thông số sản phẩm
if (strlen($r_tt['thongtin']) > 3) {
    $tach_thongso = explode('|', $r_tt['thongtin']);
    foreach ($tach_thongso as $key => $value) {
        $tach_value = explode('&&', $value);
        $list_thongso .= '<div class="li_thongso"><div class="left">' . $tach_value[0] . '</div><div class="right">' . $tach_value[1] . '</div></div>';
    }
} else {
    $list_thongso = '<div class="li_thongso">Đang cập nhật</div>';
}

// Xử lý tình trạng kho
if ($r_tt['kho'] > 0) {
    $r_tt['tinh_trang'] = 'Còn hàng';
    $disabled = '';
    $text_button = 'Thêm vào giỏ hàng';
} else {
    $r_tt['tinh_trang'] = 'Hết hàng';
    $disabled = ' disabled';
    $text_button = 'Hết Hàng';
}

$r_tt['text_flash_sale'] = ($r_tt['kho'] > 50)
    ? '<div class="flashsale__label">còn lại <b class="flashsale__sold-qty">' . $r_tt['kho'] . '</b> sản phẩm</div>'
    : '<div class="flashsale__label">🔥 Sắp hết hàng</div>';

if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
    $giam = ceil((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
    $r_tt['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
} else {
    $r_tt['label_sale'] = '';
}

$phantram = 100 - ($r_tt['kho'] / 100) * 100;
if ($r_tt['thuong_hieu'] != '') {
    $thongtin_thuonghieu = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE id='{$r_tt['thuong_hieu']}'");
    $r_th = mysqli_fetch_assoc($thongtin_thuonghieu);
    $thuong_hieu = '<span class="first_status">Thương hiệu:<span class="status_name">' . $r_th['tieu_de'] . '</span><span class="line">  |  </span></span>';
} else {
    $thuong_hieu = '';
}

$sp_id = $r_tt['id'];
if (!isset($_SESSION['daxem'][$sp_id])) {
    $_SESSION['daxem'][$sp_id] = $sp_id;
}
$list_id = implode(",", $_SESSION['daxem']);
$view_new = $r_tt['view'] + 1;
mysqli_query($conn, "UPDATE sanpham SET view='$view_new' WHERE id='{$r_tt['id']}'");

// Xử lý hiển thị thông tin shop
$shopData = ['name' => '', 'avatar' => '', 'shop_username' => '', 'mobile' => '0943.051.818', 'info' => []];
$shopInfoHtml = '';
$has_valid_shop = false;
if (!empty($shop_id)) {
    $shop_check_query = mysqli_query($conn, "SELECT user_id FROM user_info WHERE user_id = '$shop_id'");
    if (mysqli_num_rows($shop_check_query) > 0) {
        $has_valid_shop = true;
        $shopData = getShopInfo($conn, $shop_id);
        foreach ($shopData['info'] as $item) {
            $shopInfoHtml .= '<div class="info-item"><span class="info-title">' . $item['title'] . '</span><span class="info-value">' . $item['value'] . '</span></div>';
        }
    }
}

// Kiểm tra nếu shop là Sóc Đỏ thì gán link về https://socdo.vn
$shop_link = ($shopData['name'] === 'Sóc Đỏ') ? 'https://socdo.vn' : "/shop/{$shopData['shop_username']}/san-pham.html";

// Cập nhật $replace với các giá trị (bao gồm thông tin shop)
$replace['shop_avatar'] = $has_valid_shop ? '<img src="' . $shopData['avatar'] . '" alt="Shop Logo" class="shop-logo">' : '';
$replace['shop_name'] = $has_valid_shop ? $shopData['name'] : '';
$replace['shop_username'] = $has_valid_shop ? $shopData['shop_username'] : '';
$replace['username'] = $has_valid_shop ? $shopData['shop_username'] : '';
$replace['shop_mobile'] = $has_valid_shop ? $shopData['mobile'] : '0943.051.818';
$replace['shop_info'] = $has_valid_shop ? $shopInfoHtml : '';
$replace['shop_link'] = $shop_link; // Link cho "Xem shop"

$tach_menu = json_decode($class_index->list_menu($conn), true);
$tach_banner = json_decode($class_index->list_banner($conn), true);
$tach_list_category = json_decode($class_index->list_category($conn), true);
$link_xem = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$hientai = time();
$where_flash = "date_start<='$hientai' AND date_end>='$hientai' AND FIND_IN_SET($sp_id,main_product) AND shop='0' AND loai='flash_sale'";
$thongtin_flash = mysqli_query($conn, "SELECT * FROM deal WHERE $where_flash ORDER BY id DESC LIMIT 1");
$total_flash = mysqli_num_rows($thongtin_flash);

if ($total_flash == 0) {
    $box_flash_sale = '';
    $gio = 0;
    $phut = 0;
    $giay = 0;
    $where_deal = "date_start<='$hientai' AND date_end>='$hientai' AND FIND_IN_SET($sp_id,main_product) AND shop='0' AND (loai='muakem' OR loai='tang')";
    $thongtin_deal = mysqli_query($conn, "SELECT * FROM deal WHERE $where_deal ORDER BY id DESC LIMIT 1");
    $total_deal = mysqli_num_rows($thongtin_deal);
    if ($total_deal == 0) {
        $box_deal_soc = '';
    } else {
        $r_deal = mysqli_fetch_assoc($thongtin_deal);
        if ($r_deal['loai'] == 'muakem') {
            $loai = 'muakem';
            $box_deal_soc = $skin->skin_normal('skin/box_deal_soc');
            $sub_product = $r_deal['sub_id'];
            $tach_sub_product = json_decode($r_deal['sub_product'], true);
            $thongtin_sub_product = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($sub_product) ORDER BY FIELD(id,$sub_product) ASC LIMIT 3");
            while ($r_sub_product = mysqli_fetch_assoc($thongtin_sub_product)) {
                $sp = $r_sub_product['id'];
                if ($tach_sub_product[$sp]['gia'] != '') {
                    $gia_moi_sub = preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia']);
                    if ($r_sub_product['gia_cu'] > $gia_moi_sub) {
                        $giam = ceil((($r_sub_product['gia_cu'] - $gia_moi_sub) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu'], 0, ',', '.') . ' đ';
                    $r_sub_product['gia_moi'] = number_format($gia_moi_sub, 0, ',', '.') . ' đ';
                } else {
                    $gia_moi = $r_sub_product['gia_moi'] - ($r_sub_product['gia_moi'] / 100) * preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['sale']);
                    if ($r_sub_product['gia_cu'] > $gia_moi) {
                        $giam = ceil((($r_sub_product['gia_cu'] - $gia_moi) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu'], 0, ',', '.') . ' đ';
                    $r_sub_product['gia_moi'] = number_format($gia_moi, 0, ',', '.') . ' đ';
                }
                $list_muakem .= $skin->skin_replace('skin/box_li/li_sanpham_muakem_dealsoc', $r_sub_product);
            }
        } else if ($r_deal['loai'] == 'tang') {
            $loai = 'tang';
            $box_deal_soc = $skin->skin_normal('skin/box_quatang');
            $sub_product = $r_deal['sub_id'];
            $tach_sub_product = json_decode($r_deal['sub_product'], true);
            $thongtin_sub_product = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($sub_product) ORDER BY rand() DESC LIMIT 5");
            while ($r_sub_product = mysqli_fetch_assoc($thongtin_sub_product)) {
                $sp = $r_sub_product['id'];
                if ($tach_sub_product[$sp]['gia'] != '') {
                    $gia_moi_sub = preg_replace('/[^0-9]/', '', $tach_sub_product[$sp]['gia']);
                    if ($r_sub_product['gia_cu'] > $gia_moi_sub) {
                        $giam = ceil((($r_sub_product['gia_cu'] - $gia_moi_sub) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu'], 0, ',', '.') . ' đ';
                    $r_sub_product['gia_moi'] = number_format($gia_moi_sub, 0, ',', '.') . ' đ';
                } else {
                    $gia_moi = $r_sub_product['gia_moi'] - ($r_sub_product['gia_moi'] / 100) * $tach_sub_product[$sp]['sale'];
                    if ($r_sub_product['gia_cu'] > $gia_moi) {
                        $giam = ceil((($r_sub_product['gia_cu'] - $gia_moi) / $r_sub_product['gia_cu']) * 100);
                        $r_sub_product['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
                    } else {
                        $r_sub_product['label_sale'] = '';
                    }
                    $r_sub_product['gia_cu'] = number_format($r_sub_product['gia_cu'], 0, ',', '.') . ' đ';
                    $r_sub_product['gia_moi'] = number_format($gia_moi, 0, ',', '.') . ' đ';
                }
                $list_muakem .= $skin->skin_replace('skin/box_li/li_sanpham_quatang', $r_sub_product);
            }
        }
    }
    $flash_sale_pl = '';
    $thongtin_pl = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='{$r_tt['id']}' ORDER BY id ASC LIMIT 1");
    $r_pl = mysqli_fetch_assoc($thongtin_pl);
    $tach_phanloai = json_decode($class_index->list_phanloai($conn, $r_tt['id'], $r_pl['color'], $flash_sale_pl), true);
} else {
    $box_flash_sale = $skin->skin_normal('skin/box_flash_sale');
    $loai = 'flash_sale';
    $r_flash = mysqli_fetch_assoc($thongtin_flash);
    $flash_sale_pl = $r_flash['sub_product'];
    $expired = $r_flash['date_end'] - time();
    $gio = floor($expired / 3600);
    if ($gio > 0) {
        $phut = floor($expired - $gio * 3600) / 60;
        $giay = $expired - $gio * 3600 - $phut * 60;
    } else {
        $phut = floor($expired / 60);
        $giay = $phut > 0 ? floor($expired - $phut * 60) : $expired;
    }
    $tach_flash_sub_product = json_decode($r_flash['sub_product'], true);
    foreach ($tach_flash_sub_product as $key => $value) {
        if ($value['sp_id'] == $sp_id) {
            $ok_x = 0;
            foreach ($value['list_pl'] as $k => $v) {
                if ($v['so_luong'] > 0) {
                    $ok_x = 1;
                    if (!isset($info[$sp_id])) {
                        $r_tt['gia_moi'] = preg_replace('/[^0-9]/', '', $v['gia']);
                        $info[$sp_id] = $v;
                        $pl_a = $v['pl'];
                    }
                }
            }
        }
    }
    if ($ok_x == 0) {
        $thongtin_pl = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='{$r_tt['id']}' ORDER BY id ASC LIMIT 1");
        $r_pl = mysqli_fetch_assoc($thongtin_pl);
        $tach_phanloai = json_decode($class_index->list_phanloai($conn, $r_tt['id'], $r_pl['size'], $flash_sale_pl), true);
    } else {
        $thongtin_pl = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='{$r_tt['id']}' AND id='$pl_a' ORDER BY id ASC LIMIT 1");
        $r_pl = mysqli_fetch_assoc($thongtin_pl);
        $tach_phanloai = json_decode($class_index->list_phanloai($conn, $r_tt['id'], $r_pl['color'], $flash_sale_pl), true);
    }
    // Định dạng lại giá mới sau khi cập nhật từ Flash Sale
    $r_tt['gia_moi'] = number_format($r_tt['gia_moi'], 0, ',', '.') . ' đ';
}

$noi_dung = $check->remove_blank_line($r_tt['noi_dung']);
if ($r_tt['gia_cu'] > 0) {
    $sale = round((($r_tt['gia_cu'] - $r_tt['gia_moi']) / $r_tt['gia_cu']) * 100);
} else {
    $sale = '0';
}

$display_color = ($tach_phanloai['list_color'] == '') ? "display:none" : "";
$display_size = ($tach_phanloai['list_size'] == '') ? "display:none" : "";

$thongtin_caidat_tichdiem = mysqli_query($conn, "SELECT * FROM caidat_tichdiem WHERE shop='0'");
$total_caidat = mysqli_num_rows($thongtin_caidat_tichdiem);
if ($total_caidat == 0) {
    $hat_de = 0;
} else {
    $r_tichdiem = mysqli_fetch_assoc($thongtin_caidat_tichdiem);
    $hat_de = round(($r_tt['gia_moi'] / 100) * $r_tichdiem['diem']);
}

// Lấy các bộ lọc từ query string
$color_where = isset($_GET['color']) ? "color='" . mysqli_real_escape_string($conn, $_GET['color']) . "'" : '';
$size_where = isset($_GET['size']) ? "size='" . mysqli_real_escape_string($conn, $_GET['size']) . "'" : '';
$brand_where = isset($_GET['brand']) ? "thuong_hieu='" . mysqli_real_escape_string($conn, $_GET['brand']) . "'" : '';
$price_where = isset($_GET['price']) ? "gia_moi BETWEEN " . mysqli_real_escape_string($conn, $_GET['price_min']) . " AND " . mysqli_real_escape_string($conn, $_GET['price_max']) : '';

// Điều kiện lấy sản phẩm của shop
$where = "shop='$shop_id' AND status=1";
$filters = array_filter([$color_where, $size_where, $brand_where, $price_where], function ($value) {
    return $value !== '';
});
if (!empty($filters)) {
    $where .= " AND " . implode(" AND ", $filters);
}

// Truy vấn danh sách sản phẩm liên quan
$limit_lienquan = 15;
$thongtin_lienquan = mysqli_query($conn, "SELECT * FROM sanpham WHERE $where AND id != '{$r_tt['id']}' ORDER BY id DESC LIMIT $limit_lienquan");
$list_lienquan = '';
while ($r_lienquan = mysqli_fetch_assoc($thongtin_lienquan)) {
    if ($r_lienquan['gia_cu'] > $r_lienquan['gia_moi']) {
        $giam = ceil((($r_lienquan['gia_cu'] - $r_lienquan['gia_moi']) / $r_lienquan['gia_cu']) * 100);
        $r_lienquan['label_sale'] = '<div class="label_product"><div class="label_wrapper">-' . $giam . '%</div></div>';
    } else {
        $r_lienquan['label_sale'] = '';
    }
    $r_lienquan['gia_cu'] = number_format($r_lienquan['gia_cu'], 0, ',', '.');
    $r_lienquan['gia_moi'] = number_format($r_lienquan['gia_moi'], 0, ',', '.');
    $list_lienquan .= $skin->skin_replace('skin/box_li/li_sanpham_lienquan', $r_lienquan);
}

function getShopInfo($conn, $shop_id)
{
    $shop_query = mysqli_query($conn, "SELECT avatar, name, created, username, mobile FROM user_info WHERE user_id = '$shop_id'");
    if (mysqli_num_rows($shop_query) == 0) {
        return [
            'avatar' => '/skin/css/images/load.png',
            'name' => 'Sóc Đỏ',
            'shop_username' => '/socdo.vn',
            'mobile' => '0943.051.818',
            'info' => [
                ['title' => 'Đánh Giá:', 'value' => '0'],
                ['title' => 'Tỉ Lệ Phản Hồi:', 'value' => '0%'],
                ['title' => 'Tham Gia:', 'value' => 'N/A'],
                ['title' => 'Sản Phẩm:', 'value' => '0'],
                ['title' => 'Thời Gian Phản Hồi:', 'value' => 'N/A'],
                ['title' => 'Người Theo Dõi:', 'value' => '0']
            ]
        ];
    }

    $shop = mysqli_fetch_assoc($shop_query);
    $response_rate = 90 + ($shop_id % 10);
    $shop_avatar = !empty($shop['avatar']) ? $shop['avatar'] : '/skin/css/images/shop-icon.png';
    $shop_name = !empty($shop['name']) ? $shop['name'] : 'Sóc Đỏ';
    $shop_username = !empty($shop['username']) ? $shop['username'] : 'Shop Username';
    $shop_mobile = !empty($shop['mobile']) ? $shop['mobile'] : '0943.051.818';

    $product_count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM sanpham WHERE shop = '$shop_id' AND status = 1");
    $product_count = mysqli_fetch_assoc($product_count_query);
    $total_products = $product_count['total'] ?? 0;

    if (!empty($shop['created'])) {
        $created_timestamp = $shop['created']; // Timestamp của ngày đăng ký
        $current_timestamp = time(); // Timestamp hiện tại

        // Tính số ngày từ lúc đăng ký
        $days_diff = floor(($current_timestamp - $created_timestamp) / (24 * 60 * 60));

        if ($days_diff < 1) {
            $tham_gia = 'Hôm nay';
        } elseif ($days_diff < 30) {
            $tham_gia = $days_diff . ' ngày trước';
        } elseif ($days_diff < 365) {
            $months = floor($days_diff / 30);
            $tham_gia = $months . ' tháng trước';
        } else {
            $years = floor($days_diff / 365);
            $tham_gia = $years . ' năm trước';
        }
    }

    return [
        'avatar' => $shop_avatar,
        'name' => $shop_name,
        'shop_username' => $shop_username,
        'mobile' => $shop_mobile,
        'info' => [
            ['title' => 'Đánh Giá:', 'value' => '0'],
            ['title' => 'Tỉ Lệ Phản Hồi:', 'value' => $response_rate . '%'],
            ['title' => 'Tham Gia:', 'value' => $tham_gia],
            ['title' => 'Sản Phẩm:', 'value' => $total_products],
            ['title' => 'Thời Gian Phản Hồi:', 'value' => 'N/A'],
            ['title' => 'Người Theo Dõi:', 'value' => '0']
        ]
    ];
}

$shopData = getShopInfo($conn, $shop_id);
$shopInfoHtml = '';
foreach ($shopData['info'] as $item) {
    $shopInfoHtml .= '<div class="info-item"><span class="info-title">' . $item['title'] . '</span><span class="info-value">' . $item['value'] . '</span></div>';
}

// Kiểm tra nếu shop là Sóc Đỏ thì gán link về https://socdo.vn
$shop_link = ($shopData['name'] === 'Sóc Đỏ') ? 'https://socdo.vn' : "/shop/{$shopData['shop_username']}/san-pham.html";

// Lấy danh sách màu sắc duy nhất
$color_query = "SELECT DISTINCT color, ten_color, ma_mau FROM phanloai_sanpham WHERE sp_id='{$r_tt['id']}'";
$color_result = mysqli_query($conn, $color_query);
$list_color = '';
$first = true;

while ($color_row = mysqli_fetch_assoc($color_result)) {
    $active = $first ? 'active' : '';
    $list_color .= '<div class="li_color ' . $active . '" sp_id="' . $r_tt['id'] . '" color="' . $color_row['color'] . '" tieu_de="' . $color_row['ten_color'] . '" style="background-color: ' . $color_row['ma_mau'] . ';">' . $color_row['ten_color'] . '</div>';
    if ($first) {
        $color_active = $color_row['ten_color'];
        $first = false;
    }
}
$list_danhmuc_top = json_decode($class_index->list_category_danhmuc_top($conn), true);



// Gán vào $replace với định dạng số tiền
$replace = array(
    'header' => $skin->skin_normal('skin/header'),
    'box_header' => $box_header,
    'box_deal_soc' => $box_deal_soc,
    'box_flash_sale' => $box_flash_sale,
    'box_danhgia' => $box_danhgia ?? '',
    'footer' => $skin->skin_normal('skin/footer'),
    'script_footer' => $skin->skin_normal('skin/script_footer'),
    'mobile_menu' => $mobile_menu,
    'title' => $r_tt['title'] ?? 'Sản phẩm không xác định',
    'description' => $r_tt['description'] ?? 'Mô tả sản phẩm không có',
    'site_name' => $index_setting['site_name'],
    'limit' => $limit,
    'logo' => $index_setting['logo'],
    'text_footer' => $index_setting['text_footer'],
    'text_contact_footer' => $index_setting['text_contact_footer'],
    'text_about' => $index_setting['text_about'],
    'link_xem' => $link_xem,
    'link_facebook' => $index_setting['link_facebook'],
    'link_youtube' => $index_setting['link_youtube'],
    'link_twitter' => $index_setting['link_twitter'],
    'link_instagram' => $index_setting['link_instagram'],
    'text_hotline' => $index_setting['text_hotline'],
    'hotline' => $index_setting['hotline'],
    'hotline_number' => preg_replace('/[^0-9]/', '', $index_setting['hotline']),
    'menu_chinhsach' => $tach_menu['chinhsach'],
    'menu_huongdan' => $tach_menu['huongdan'],
    'menu_left' => $tach_menu['left'],
    'list_danhmuc' => $list_danhmuc_top['list_parent'],
    'list_danhmuc_sub' => $list_danhmuc_top['list_sub'],
    // 'list_category' => $tach_list_category['list'],
    'list_category_top' => $tach_list_category['list_top'],
    'list_category_mobile' => $tach_list_category['list_mobile'],
    'lienhe' => $index_setting['lienhe'],
    'photo' => $index_setting['photo'],
    'phantrang' => '',
    'fanpage' => $index_setting['fanpage'],
    'name' => $user_info['name'] ?? '',
    'avatar' => $user_info['avatar'] ?? '',
    'gioithieu' => $index_setting['gioithieu'],
    'tieu_de' => $r_tt['tieu_de'],
    'noidung' => $noi_dung,
    'list_big' => $list_big,
    'list_small' => $list_small,
    'img_big' => $img_big,
    'list_thongso' => $list_thongso,
    'text_button' => $text_button,
    'disabled' => $disabled,
    'display_size' => $display_size,
    'display_color' => $display_color,
    'tinh_trang' => $r_tt['tinh_trang'],
    'thuong_hieu' => $thuong_hieu,
    'gia_moi' => number_format($r_tt['gia_moi'], 0, ',', '.'),
    'gia_cu' => number_format($r_tt['gia_cu'], 0, ',', '.'),
    'sale' => $sale,
    'hat_de' => number_format($hat_de, 0, ',', '.') . ' đ',
    'noi_bat' => $r_tt['noi_bat'] ?? '',
    'text_flash_sale' => $r_tt['text_flash_sale'],
    'phantram' => $phantram,
    'sp_id' => $r_tt['id'],
    'shop_avatar' => '<img src="' . $shopData['avatar'] . '" alt="Shop Logo" class="shop-logo">',
    'shop_name' => $shopData['name'],
    'shop_username' => $shopData['shop_username'],
    'username' => $shopData['username'],
    'shop_info' => $shopInfoHtml,
    'shop_link' => $shop_link,
    'list_lienquan' => $list_lienquan,
	'list_lienquan' => $class_index->list_sanpham_lienquan($conn, $r_tt['id'], $r_tt['cat'], 15),
    'link' => $r_tt['link'],
    'minh_hoa' => substr($index_setting['link_domain'], 0, -1) . $r_tt['minh_hoa'],
    'banner_top' => $tach_banner['top'],
    'label_sale' => $r_tt['label_sale'],
    'list_color' => $tach_phanloai['list_color'],
    'list_size' => $tach_phanloai['list_size'],
    'color_active' => $tach_phanloai['ten_color'],
    'size_active' => $tach_phanloai['ten_size'],
    'list_muakem' => $list_muakem,
    'info_rate' => $info_rate ?? '',
    'loai' => $loai,
    'gio' => $gio,
    'phut' => $phut,
    'giay' => $giay
);
$shop_name_new = !empty($shopData['name']) ? $shopData['name'] : 'Tên Shop Mặc Định';
$replace['shop_name'] = $shop_name_new;

echo $skin->skin_replace('skin/view', $replace);
