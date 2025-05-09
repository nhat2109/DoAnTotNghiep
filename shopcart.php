<?php
session_start(); // Đảm bảo session được khởi động
$web = $_SERVER['HTTP_HOST'];
$web = str_replace('www.', '', $web);
$web_root = array('doantotnghiep.vn', 'socdo.vn', 'socmoi.vn', 'soc.vn', 'beta.socdo.vn');
if (in_array($web, $web_root) == false) {
    include('./shop/shopcart.php');
    exit();
}
include('./includes/tlca_world.php');
$check = $tlca_do->load('class_check');
$class_index = $tlca_do->load('class_index');
// nhatthem
$class_supership = $tlca_do->load('class_supership');
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
$list_danhmuc_top = json_decode($class_index->list_category_danhmuc_top($conn), true);
$tach_menu = json_decode($class_index->list_menu($conn), true);
$tach_banner = json_decode($class_index->list_banner($conn), true);
$tach_list_category = json_decode($class_index->list_category($conn), true);
$link_xem = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

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

$last_removed_sp_id = isset($_SESSION['last_removed']['sp_id']) ? $_SESSION['last_removed']['sp_id'] : null;
$last_removed_pl = isset($_SESSION['last_removed']['pl']) ? $_SESSION['last_removed']['pl'] : null;

if (empty($_SESSION['cart'])) {
    if (isset($_SESSION['daxem'])) {
        $list_id = implode(",", array_unique($_SESSION['daxem']));
        $list_daxem = $class_index->list_sanpham_daxem($conn, $list_id, $limit);
        $tt['list_daxem'] = $list_daxem;
        $box_daxem_empty = $skin->skin_replace('skin/box_li/box_daxem_cart_emty', $tt);
        $box_daxem_normal = $skin->skin_replace('skin/box_li/box_daxem', $tt);
    } else {
        $box_daxem_empty = '';
        $box_daxem_normal = '';
    }
    $thongbao = "Giỏ hàng trống.";
    echo $skin->skin_replace('skin/shopcart_emty', array(
        'header' => $skin->skin_normal('skin/header'),
        'box_header' => $box_header,
        'title' => 'Giỏ hàng',
        'thongbao' => $thongbao,
        'footer' => $skin->skin_normal('skin/footer'),
        'script_footer' => $skin->skin_normal('skin/script_footer'),
        'mobile_menu' => $mobile_menu,
        'box_deal' => $skin->skin_normal('skin/box_deal_shopcart_emty'),
        'description' => $index_setting['description'],
        'site_name' => $index_setting['site_name'],
        'limit' => $limit,
        'logo' => $index_setting['logo'],
        'list_danhmuc_noibat_timkiem' => $class_index->list_category_noibat_timkiem($conn),
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
        'lienhe' => $index_setting['lienhe'],
        'photo' => $index_setting['photo'],
        'phantrang' => '',
        'fanpage' => $index_setting['fanpage'],
        'gioithieu' => $index_setting['gioithieu'],
        'banner_top' => $tach_banner['top'],
        'list_danhmuc' => $list_danhmuc_top['list_parent'],
	    'list_danhmuc_sub' => $list_danhmuc_top['list_sub'],
        'box_daxem' => $box_daxem_empty,
        'list_sanpham_deal' => $class_index->list_sanpham_deal_cart_emty($conn, '', '', '', '', 1, 10),
    ));
    exit();
}

$hientai = time();
$list_sp_id = '';
$list_pl = '';
foreach ($_SESSION['cart'] as $key => $value) {
    list($sp_id, $pl) = explode('_', $key);
    $list_sp_id .= $sp_id . ',';
    $list_pl .= $pl . ',';
}
$list_sp_id = rtrim($list_sp_id, ',');
$list_pl = rtrim($list_pl, ',');

$product_pl = [];
if ($list_pl) {
    $thongtin_pl = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE id IN ($list_pl)");
    while ($r_pl = mysqli_fetch_assoc($thongtin_pl)) {
        $sp_id_pl = $r_pl['sp_id'] . '_' . $r_pl['id'];
        $product_pl[$sp_id_pl] = $r_pl;
    }
}

$giam = 0;
if (isset($_SESSION['coupon'])) {
    $thongtin_counpon = mysqli_query($conn, "SELECT *, COUNT(*) AS total FROM coupon WHERE ma='{$_SESSION['coupon']}' AND shop='0'");
    $r_coupon = mysqli_fetch_assoc($thongtin_counpon);
    if ($r_coupon['total'] > 0 && $r_coupon['kieu'] == 'sanpham') {
        $tach_list_sp_id = explode(',', $list_sp_id);
        $tach_sanpham_id = explode(',', $r_coupon['sanpham']);
        $id_apdung = array_intersect($tach_sanpham_id, $tach_list_sp_id);
    }
}

$tamtinh = 0;
$list_shopcart = '';
// nhatthem
$list_product = '';
$can_nang = 0;
$trongluong = 0;
function getCtvProvinceDistrict($conn, $user_id) {
    $stmt = mysqli_prepare($conn, "
    SELECT 
        transport.province, 
        transport.district, 
        tinh_moi.tieu_de AS tinh_ten, 
        huyen_moi.tieu_de AS huyen_ten
        FROM transport
        INNER JOIN tinh_moi ON transport.province = tinh_moi.id
        INNER JOIN huyen_moi ON transport.district = huyen_moi.id
        WHERE transport.user_id = ? AND transport.is_default = 1
    ");

    if (!$stmt) {
        return "Lỗi chuẩn bị truy vấn";
    }

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $data = [
            'tinh' => $row['tinh_ten'],
            'huyen' => $row['huyen_ten']
        ];
        mysqli_stmt_close($stmt);
        return $data;
    }
}
$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_sp_id) ORDER BY FIELD(id, $list_sp_id)");
while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
    $id_sp = $r_cart['id'];
    foreach ($_SESSION['cart'] as $key => $value) {
        list($cart_sp_id, $cart_pl) = explode('_', $key);
        if ($cart_sp_id == $id_sp) {
               
            // nhatthem
             // Giả sử $r_cart['shop_id'] và $r_cart['shop_name'] có sẵn
            $shop_id = $r_cart['shop'];
            $query = "SELECT * FROM user_info WHERE user_id = '$shop_id'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                $shop_name = $row['name'];
            }else
            {
                $shop_name = "Sàn TMĐT";
            }
            if($shop_id != 0){
                $data = getCtvProvinceDistrict($conn, $shop_id);
            }else 
            {
                $data = [
                    'tinh' => 'Thành phố Hà Nội', // ID tỉnh, ví dụ: Cần Thơ
                    'huyen' => 'Nam Từ Liêm' // ID huyện, ví dụ: Huyện Cờ Đỏ
                ];
            }
            // var_dump($data);
           
        
            /////////////////////
            $pl_key = $id_sp . '_' . $cart_pl;
            $r_cart['ten_sanpham'] = $r_cart['tieu_de'];
            $r_cart['gia_moi'] = number_format($value['gia_moi'], 0, ',', '.') ; 
            $r_cart['gia_cu'] = number_format($value['gia_cu'], 0, ',', '.');   
            $r_cart['quantity'] = $value['quantity'];
            // $stmts_variant = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='$id_sp' AND ten_size='$product_pl[$pl_key]['ten_color']' AND ten_color='$product_pl[$pl_key]['ten_size']'");
            // var_dump("SELECT * FROM phanloai_sanpham WHERE sp_id='$id_sp' AND ten_size='$product_pl[$pl_key]['ten_color']' AND ten_color='$product_pl[$pl_key]['ten_size']'");
            // $r_variant = mysqli_fetch_assoc($stmts_variant);
            
            // $trongluong += floatval(str_replace(',', '.', $r_variant['can_nang_tinhship'])) * $value['quantity'];
            // var_dump($r_variant['id']);

            $r_cart['thanhtien'] = number_format($value['gia_moi'] * $value['quantity'], 0, ',', '.') . ' đ';
            $tamtinh += $value['gia_moi'] * $value['quantity'];

            $r_cart['sp_id'] = $cart_sp_id;
            $r_cart['pl'] = $cart_pl;

            if (isset($product_pl[$pl_key])) {
                $r_cart['ten_color'] = $product_pl[$pl_key]['ten_color'] 
                    ? '<div class="color_content"><div class="text">' . $product_pl[$pl_key]['ten_color'] . '</div></div>' 
                    : '';
                $r_cart['ten_size'] = $product_pl[$pl_key]['ten_size'] 
                    ? '<div class="color_content"><div class="text">' . $product_pl[$pl_key]['ten_size'] . '</div></div>' 
                    : '';

                // In ra giá trị kiểm tra
                // Lấy biến tạm
                $ten_color = $product_pl[$pl_key]['ten_color'];
                $ten_size = $product_pl[$pl_key]['ten_size'];

                // Truy vấn SQL đúng cú pháp
                $sql = "SELECT * FROM phanloai_sanpham 
                        WHERE sp_id = '$id_sp' 
                        AND ten_size = '$ten_size'
                        AND ten_color = '$ten_color'";

                $stmts_variant = mysqli_query($conn, $sql);

                $r_variant = mysqli_fetch_assoc($stmts_variant);
                $trongluong += floatval(str_replace(',', '.', $r_variant['can_nang_tinhship'])) * $value['quantity'];
                // var_dump($trongluong);
            } else {
                $r_cart['ten_color'] = '';
                $r_cart['ten_size'] = '';
            }


            if (isset($_SESSION['coupon']) && $r_coupon['total'] > 0) {
                if ($r_coupon['kieu'] == 'all' || $r_coupon['kieu'] == 'baohanh') {
                    $giam += ($r_coupon['loai'] == 'phantram') ? ceil(($value['gia_moi'] * $value['quantity'] / 100) * $r_coupon['giam']) : $r_coupon['giam'];
                } elseif (in_array($id_sp, $id_apdung)) {
                    $giam += ($r_coupon['loai'] == 'phantram') ? ceil(($value['gia_moi'] * $value['quantity'] / 100) * $r_coupon['giam']) : $r_coupon['giam'];
                }
            }
            // nhatthem
            // $list_shopcart .= $skin->skin_replace('skin/box_li/li_shopcart', $r_cart);
             // Gom vào mảng theo shop
            $shops[$shop_id]['tinh'] = $data['tinh'];
            $shops[$shop_id]['huyen'] = $data['huyen'];
            $shops[$shop_id]['trongluong'] = $trongluong;
            // var_dump($shops[$shop_id]['tinh']);
            // var_dump($shops[$shop_id]['huyen']);
            
            $shops[$shop_id]['shop_name'] = $shop_name;

            $shops[$shop_id]['products'][] = $skin->skin_replace('skin/box_li/li_shopcart', $r_cart);
            $shops[$shop_id]['subtotal'] += $value['gia_moi'] * $value['quantity'];
        }
        
    }
    
}
// die;
// nhatthem
foreach ($shops as $shop) {
    $shop_html = [
        'shop_name' => $shop['shop_name'],
        'shop_tinh' => $shop['tinh'],
        'shop_huyen' => $shop['huyen'],
        'shop_subtotal' => number_format($shop['subtotal'], 0, ',', '.'),
        'trongluong'=> $shop['trongluong']*1000,
        'list_products' => implode('', $shop['products']),
        // Thêm các trường khác nếu cần
    ];
    $list_shopcart .= $skin->skin_replace('skin/box_li/li_shopcart_shop', $shop_html);
}

$tongtien = $tamtinh - $giam;

$thongtin_caidat_tichdiem = mysqli_query($conn, "SELECT * FROM caidat_tichdiem WHERE shop='0'");
$total_caidat = mysqli_num_rows($thongtin_caidat_tichdiem);
$hat_de = ($total_caidat > 0) ? round(($tongtien / 100) * mysqli_fetch_assoc($thongtin_caidat_tichdiem)['diem']) : 0;

$thongtin_diachi = mysqli_query($conn, "SELECT * FROM dia_chi WHERE user_id='$user_id' AND active='1'");
$total_diachi = mysqli_num_rows($thongtin_diachi);
if ($total_diachi > 0) {
    $r_dc = mysqli_fetch_assoc($thongtin_diachi);
    $ho_ten = $r_dc['ho_ten'];
    $dia_chi = $r_dc['dia_chi'];
    $dien_thoai = $r_dc['dien_thoai'];
    $email = $r_dc['email'];
    $tinh = $r_dc['tinh'] ?? 0;
    $huyen = $r_dc['huyen'] ?? 0;
    $xa = $r_dc['xa'] ?? 0;
    $option_tinh = $class_index->list_option_tinh($conn, $tinh);
    $option_huyen = $class_index->list_option_huyen($conn, $tinh, $huyen);
    $option_xa = $class_index->list_option_xa($conn, $huyen, $xa);
} else {
    $ho_ten = $dien_thoai = $dia_chi = $email = '';
    $tinh = 0;
    $huyen = 0;
    $xa = 0;
    $option_tinh = $class_index->list_option_tinh($conn, 0);
    $option_huyen = $class_index->list_option_huyen($conn, 0, 0);
    $option_xa = $class_index->list_option_xa($conn, 0, 0);
}

$hatde_conlai = (isset($_COOKIE['user_id'])) ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT diem FROM diem WHERE user_id='$user_id'"))['diem'] ?? 0 : 0;

$replace = array(
    'header' => $skin->skin_normal('skin/header'),
    'box_header' => $box_header,
    'footer' => $skin->skin_normal('skin/footer'),
    'script_footer' => $skin->skin_normal('skin/script_footer'),
    'mobile_menu' => $mobile_menu,
    'title' => 'Giỏ hàng',
    'description' => $index_setting['description'],
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
    'lienhe' => $index_setting['lienhe'],
    'photo' => $index_setting['photo'],
    'list_danhmuc_noibat_timkiem' => $class_index->list_category_noibat_timkiem($conn),
    'list_danhmuc' => $list_danhmuc_top['list_top'],
    'phantrang' => '',
    'fanpage' => $index_setting['fanpage'],
    'name' => $user_info['name'] ?? '',
    'avatar' => $user_info['avatar'] ?? '',
    'gioithieu' => $index_setting['gioithieu'],
    'list_shopcart' => $list_shopcart,
    'list_shopcart_mobile' => $list_shopcart,
    'total_cart' => count($_SESSION['cart']),
    'tongtien' => number_format($tongtien, 0, ',', '.'),
    'tamtinh' => number_format($tamtinh, 0, ',', '.'),
    'hat_de' => number_format($hat_de, 0, ',', '.'),
    'hatde_conlai' => number_format($hatde_conlai, 0, ',', '.'),
    'giam' => number_format($giam, 0, ',', '.'),
    'coupon' => $_SESSION['coupon'] ?? '',
    'banner_top' => $tach_banner['top'],
    'ho_ten' => $ho_ten,
    'dia_chi' => $dia_chi,
    'dien_thoai' => $dien_thoai,
    'email' => $email,
    'option_tinh' => $option_tinh,
    'option_huyen' => $option_huyen,
    'option_xa' => $option_xa,
    'last_removed_sp_id' => $last_removed_sp_id,
    'last_removed_pl' => $last_removed_pl,
    'tinh' => $user_info['tinh'] ?? '',
    'huyen' => $user_info['huyen'] ?? '',
);
echo $skin->skin_replace('skin/shopcart', $replace);