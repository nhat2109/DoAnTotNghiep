<?php
$web = $_SERVER['HTTP_HOST'];
$web = str_replace('www.', '', $web);
$web_root = array('doantotnghiep.vn', 'socdo.vn', 'socmoi.vn', 'soc.vn', 'beta.socdo.vn');
if (in_array($web, $web_root) == false) {
    include('./shop/sanpham_category.php');
    exit();
}
include('./includes/tlca_world.php');
$check = $tlca_do->load('class_check');
$class_index = $tlca_do->load('class_index');

// Lấy username từ URL
$username = addslashes(strip_tags($_REQUEST['username']));
if (empty($username)) {
    $thongbao = "Sản phẩm của Sóc Đỏ";
    $replace = array(
        'title' => 'Sản phẩm của Sóc Đỏ',
        'thongbao' => $thongbao,
        'link' => '/'
    );
    echo $skin->skin_replace('skin/chuyenhuong', $replace);
    exit();
}

// Lấy thông tin shop từ user_info
//$thongtin_shop = mysqli_query($conn, "SELECT * FROM user_info WHERE username='$username'");
$thongtin_shop = mysqli_query($conn, "SELECT * FROM user_info WHERE username='$username' AND ctv='1' ");
if (mysqli_num_rows($thongtin_shop) == 0) {
    $thongbao = "Sản phẩm của kho Sóc Đỏ.";
    $replace = array(
        'title' => 'Sản phẩm của kho Sóc Đỏ',
        'thongbao' => $thongbao,
        'link' => '/'
    );
    echo $skin->skin_replace('skin/chuyenhuong', $replace);
    exit();
}
$r_shop = mysqli_fetch_assoc($thongtin_shop);
$shop_id = $r_shop['user_id'];
$shop_name = $r_shop['name'] ?: $r_shop['username']; // Tiêu đề trang: ưu tiên name, nếu không có thì dùng username

// Lấy thêm thông tin shop
$shop_product_count = 0; // Số lượng sản phẩm
$shop_followers = $r_shop['followers'] ?? 0; // Số người theo dõi
$shop_chat_response_rate = $r_shop['chat_response_rate'] ?? 0; // Tỷ lệ phản hồi chat
$shop_join_time = $r_shop['created'] ?? time(); // Thời gian tham gia (timestamp)

// Tính thời gian tham gia
$current_time = time();
$join_duration = $current_time - $shop_join_time;
$join_years = floor($join_duration / (365 * 24 * 60 * 60)); // Số năm
$join_months = floor($join_duration / (30 * 24 * 60 * 60)); // Số tháng
if ($join_years > 0) {
    $shop_join_duration = "$join_years năm trước";
} elseif ($join_months > 0) {
    $shop_join_duration = "$join_months tháng trước";
} else {
    $shop_join_duration = "Mới tham gia";
}

// Xử lý phân trang
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
$limit = 40;

// Lấy setting
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
    $index_setting[$r_s['name']] = $r_s['value'];
}

// Xử lý header và menu
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

// Xử lý sản phẩm đã xem
if (isset($_SESSION['daxem'])) {
    $list_id = implode(",", $_SESSION['daxem']);
    $list_daxem = $class_index->list_sanpham_daxem($conn, $list_id, $limit);
    $tt['list_daxem'] = $list_daxem;
    $box_daxem = $skin->skin_replace('skin/box_daxem', $tt);
} else {
    $box_daxem = '';
}

// Xử lý bộ lọc (giữ nguyên logic từ sanpham_category.php)
$brand = addslashes(strip_tags($url_query['brand']));
$color = addslashes(strip_tags($url_query['color']));
$price = addslashes(strip_tags($url_query['price']));
$size = addslashes(strip_tags($url_query['size']));
$sort = addslashes(strip_tags($url_query['sort']));
if (isset($url_query['sort'])) {
    if ($sort == 'price-ascending') {
        $order = 'gia_moi ASC';
    } else if ($sort == 'price-descending') {
        $order = 'gia_moi DESC';
    } else if ($sort == 'title-ascending') {
        $order = 'tieu_de ASC';
    } else if ($sort == 'title-descending') {
        $order = 'tieu_de DESC';
    } else if ($sort == 'created-ascending') {
        $order = 'date_post ASC';
    } else if ($sort == 'created-descending') {
        $order = 'date_post DESC';
    } else if ($sort == 'best-selling') {
        $order = 'ban DESC';
    } else {
        $order = 'date_post DESC';
    }
} else {
    $order = 'date_post DESC';
    $sort = 'created-descending';
}
if (isset($url_query['color'])) {
    $color_where = 'FIND_IN_SET(' . $color . ',mau)>0';
} else {
    $color_where = '';
}
if (isset($url_query['size'])) {
    if ($color_where != '') {
        $size_where = 'AND FIND_IN_SET(' . $size . ',size)>0';
    } else {
        $size_where = 'FIND_IN_SET(' . $size . ',size)>0';
    }
} else {
    $size_where = '';
}
if (isset($url_query['brand'])) {
    if ($color_where != '' or $size_where != '') {
        $brand_where = "AND thuong_hieu='$brand'";
    } else {
        $brand_where = "thuong_hieu='$brand'";
    }
} else {
    $brand_where = '';
}

if (isset($url_query['price'])) {
    $tach_price = explode('-', $price);
    if ($color_where != '' or $size_where != '' or $brand_where != '') {
        if ($tach_price[0] == 0) {
            $max_price = $tach_price[1];
            $price_where = "AND gia_moi<='" . $max_price . "'";
        } else if ($tach_price[1] == 999999999999) {
            $min_price = $tach_price[0];
            $price_where = "AND gia_moi>='" . $min_price . "'";
        } else {
            $min_price = $tach_price[0];
            $max_price = $tach_price[1];
            $price_where = "AND gia_moi>='" . $min_price . "' AND gia_moi<='" . $max_price . "'";
        }
    } else {
        if ($tach_price[0] == 0) {
            $max_price = $tach_price[1];
            $price_where = "gia_moi<='" . $max_price . "'";
        } else if ($tach_price[1] == 999999999999) {
            $min_price = $tach_price[0];
            $price_where = "gia_moi>='" . $min_price . "'";
        } else {
            $min_price = $tach_price[0];
            $max_price = $tach_price[1];
            $price_where = "gia_moi>='" . $min_price . "' AND gia_moi<='" . $max_price . "'";
        }
    }
} else {
    $price_where = '';
}

// Điều kiện lấy sản phẩm của shop
$where = "shop='$shop_id' AND status=1";
if ($color_where != '' or $size_where != '' or $brand_where != '' or $price_where != '') {
    $where .= " AND " . $color_where . " " . $size_where . " " . $brand_where . " " . $price_where;
}

// Đếm tổng số sản phẩm
$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham WHERE " . $where);
$r_tk = mysqli_fetch_assoc($thongke);
$shop_product_count = $r_tk['total']; // Số lượng sản phẩm
$total_page = ceil($r_tk['total'] / $limit);
$phantrang = $class_index->phantrang_sanpham($page, $total_page, '/shop/' . $username . '/san-pham.html');

// Lấy dữ liệu menu, banner, category
$tach_menu = json_decode($class_index->list_menu($conn), true);
$tach_banner = json_decode($class_index->list_banner($conn), true);
$tach_list_category = json_decode($class_index->list_category($conn), true);
$tach_list_size = json_decode($class_index->list_size($conn, 0, $size), true); // Không cần cat_id
$tach_list_brand = json_decode($class_index->list_brand($conn, 0, $brand), true); // Không cần cat_id
$tach_list_color = json_decode($class_index->list_color($conn, 0, $color), true); // Không cần cat_id
$tach_list_price = json_decode($class_index->list_khoang_gia($conn, $price), true);
$link_xem = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// Xử lý box top deal và tìm kiếm nhiều
if ($r_tk['total'] <= 5) {
    $list_top_deal_soc = '';
    $box_top_deal_soc = '';
    $box_timkiem_nhieu = '';
} else {
    $data_deal_soc = array(
        'list_top_deal_soc' => $class_index->list_top_deal_soc($conn, 0, 15) // Không cần cat_id
    );
    $box_top_deal_soc = $skin->skin_replace('skin/box_top_deal_soc', $data_deal_soc);
    $thongtin_timkiem = mysqli_query($conn, "SELECT * FROM timkiem_nhieu WHERE cat_id='0'");
    if (mysqli_num_rows($thongtin_timkiem) > 0) {
        $data_timkiem_nhieu = array(
            'list_timkiem_nhieu' => $class_index->list_timkiem_nhieu($conn, 0, 6)
        );
        $box_timkiem_nhieu = $skin->skin_replace('skin/box_timkiem_nhieu', $data_timkiem_nhieu);
    } else {
        $box_timkiem_nhieu = '';
    }
}

$list_danhmuc_top = json_decode($class_index->list_category_danhmuc_top($conn), true);
$shop_mobile = preg_replace('/[^0-9]/', '', $r_shop['mobile'] ?? ''); // Chỉ giữ lại số
$replace['shop_mobile'] = $shop_mobile;
// Dữ liệu để render template
// Dữ liệu để render template
$replace = array(
    'header' => $skin->skin_normal('skin/header'),
    'box_header' => $box_header,
    'list_danhmuc' => $list_danhmuc_top['list_parent'],
    'list_danhmuc_sub' => $list_danhmuc_top['list_sub'],
    'box_top_deal_soc' => $box_top_deal_soc,
    'box_timkiem_nhieu' => $box_timkiem_nhieu,
    'footer' => $skin->skin_normal('skin/footer'),
    'script_footer' => $skin->skin_normal('skin/script_footer'),
    'mobile_menu' => $mobile_menu,
    'title' => 'Sản phẩm của ' . $shop_name,
    'description' => 'Danh sách sản phẩm của shop ' . $shop_name . ' trên Sóc Đỏ',
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
    'list_category' => $tach_list_category['list'],
    'list_category_top' => $tach_list_category['list_top'],
    'list_category_mobile' => $tach_list_category['list_mobile'],
    'list_sanpham' => $class_index->list_sanpham_timkiem($conn, $where, $list_muakem_id, $list_tang_id, $list_flashsale_id, $list_c, $order, $page, $limit),
    'box_daxem' => $box_daxem,
    'lienhe' => $index_setting['lienhe'],
    'photo' => $index_setting['photo'],
    'phantrang' => $phantrang,
    'fanpage' => $index_setting['fanpage'],
    'name' => $user_info['name'],
    'avatar' => $user_info['avatar'],
    'gioithieu' => $index_setting['gioithieu'],
    'tieu_de' => 'Sản phẩm của ' . $shop_name,
    'option_size' => $tach_list_size['list'],
    'option_brand' => $tach_list_brand['list'],
    'option_color' => $tach_list_color['list'],
    'option_price' => $tach_list_price['list'],
    'list_size_mobile' => $tach_list_size['list_mobile'],
    'list_brand_mobile' => $tach_list_brand['list_mobile'],
    'list_color_mobile' => $tach_list_color['list_mobile'],
    'list_price_mobile' => $tach_list_price['list_mobile'],
    'banner_top' => $tach_banner['top'],
    'sort' => $sort,
    'cat_id' => 0, // Không cần cat_id
    'list_danhmuc_noibat_timkiem' => $class_index->list_category_noibat_timkiem($conn),
    'dropship' => $user_info['dropship'],
    // Thêm thông tin shop để truyền vào template
    'shop_name' => $shop_name,
    'shop_product_count' => $shop_product_count,
    'shop_followers' => $shop_followers,
    'shop_chat_response_rate' => $shop_chat_response_rate,
    'shop_join_duration' => $shop_join_duration,
    'shop_avatar' => $r_shop['avatar'] ?? '/default-avatar.jpg', // Avatar của shop
    'shop_mobile' => $shop_mobile, // Số điện thoại của shop (đã chuẩn hóa)
);
echo $skin->skin_replace('skin/sanpham_shop', $replace);
?>