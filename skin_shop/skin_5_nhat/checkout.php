<?php
session_start();
$class_index = $tlca_do->load_skin($s, 'class_shop');
$class_supership = $tlca_do->load('class_supership');
$check = $tlca_do->load('class_check');
$giaodien = json_decode($index_setting['giaodien'], true);
$limit = 10;

if (isset($_COOKIE['user_id'])) {
    $box_header = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_header_login');
    $class_member = $tlca_do->load('class_member');
    $tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
    $user_id = $tach_token['user_id'];
    $user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
} else {
    $box_header = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_header');
    $thongbao = "Bạn chưa đăng nhập tài khoản.";
    $replace = [
        'title' => 'Chưa đăng nhập tài khoản',
        'thongbao' => $thongbao,
        'link' => '/dang-nhap.html'
    ];
    echo $skin->skin_replace('skin_shop/' . $s . '/tpl/chuyenhuong', $replace);
    exit();
}

$tach_menu = json_decode($class_index->list_menu($conn, $s, $r_shop['user_id']), true);
$tach_category = json_decode($class_index->list_category($conn, $r_shop['user_id']), true);
$hientai = time();
$thongtin_khuyenmai = mysqli_query($conn, "SELECT * FROM coupon WHERE shop='$shop' AND start<='$hientai' AND expired>='$hientai' ORDER BY id ASC");
while ($r_km = mysqli_fetch_assoc($thongtin_khuyenmai)) {
    $ma = $r_km['ma'];
    $list_km[$ma]['giam'] = $r_km['giam'];
    $list_km[$ma]['loai'] = $r_km['loai'];
    $list_km[$ma]['kieu'] = $r_km['kieu'];
    $list_km[$ma]['min_price'] = $r_km['min_price'];
    $list_km[$ma]['max_price'] = $r_km['max_price'];
    $list_km[$ma]['max_uses_per_user'] = $r_km['max_uses_per_user'];
    $list_km[$ma]['max_global_uses'] = $r_km['max_global_uses'];
    $list_km[$ma]['current_uses'] = $r_km['current_uses'];
    $list_km[$ma]['sanpham'] = $r_km['sanpham'];
}

if ($step == 1 || !$step) {
    // Debug session cart
    if (empty($_SESSION['cart'])) {
        $thongbao = "Bạn chưa chọn sản phẩm nào.";
        $replace = [
            'title' => 'Chưa chọn sản phẩm',
            'thongbao' => $thongbao,
            'link' => '/'
        ];
        echo $skin->skin_replace('skin_shop/' . $s . '/tpl/chuyenhuong', $replace);
        exit();
    }

    $valid_ids = [];
    $list_check_product = [];
    $list_sub_product = [];
    $list_s = [];
    $list_c = [];

    foreach ($_SESSION['cart'] as $key => $value) {
        if (isset($value['sp_id']) && !empty($value['sp_id']) && is_numeric($value['sp_id'])) {
            $valid_ids[] = $value['sp_id'];
            if ($value['flash_sale'] == 1) {
                $thongtin_check = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET(" . $value['sp_id'] . ",main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
                $r_ck = mysqli_fetch_assoc($thongtin_check);
                $list_check_product[] = json_decode($r_ck['sub_product'], true);
            }
        }
    }

    $valid_ids = array_unique($valid_ids);
    if (empty($valid_ids)) {
        $thongbao = "Không có sản phẩm hợp lệ trong giỏ hàng.";
        $replace = [
            'title' => 'Giỏ hàng trống',
            'thongbao' => $thongbao,
            'link' => '/'
        ];
        echo $skin->skin_replace('skin_shop/' . $s . '/tpl/chuyenhuong', $replace);
        exit();
    }

    $list_id = implode(',', $valid_ids);

    if (isset($_SESSION['coupon'])) {
        $thongtin_counpon = mysqli_query($conn, "SELECT *,count(*) AS total FROM coupon WHERE ma='{$_SESSION['coupon']}' AND shop='$shop'");
        $r_coupon = mysqli_fetch_assoc($thongtin_counpon);
        if ($r_coupon['kieu'] == 'sanpham') {
            $tach_list_id = explode(',', $list_id);
            $tach_sanpham_id = explode(',', $r_coupon['sanpham']);
            $id_apdung = array_intersect($tach_sanpham_id, $tach_list_id);
            $total_id = count($id_apdung);
        }
    }

    if (isset($_SESSION['muakem'])) {
        $list_main_id = '';
        foreach ($_SESSION['main_product'] as $value) {
            if (is_numeric($value)) {
                $list_main_id .= $value . ',';
                $thongtin_muakem = mysqli_query($conn, "SELECT * FROM deal WHERE FIND_IN_SET($value,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='$shop' ORDER BY id DESC LIMIT 1");
                $r_mk = mysqli_fetch_assoc($thongtin_muakem);
                $list_sub_product[] = json_decode($r_mk['sub_product'], true);
            }
        }
        foreach ($list_sub_product as $value) {
            foreach ($value as $k => $v) {
                $list_s[$k] = $v;
            }
        }
        $list_main_id = rtrim($list_main_id, ',');
        $tach_list_main_id = explode(',', $list_main_id);
        $tach_list_id_mk = explode(',', rtrim($r_mk['sub_id'] ?? '', ','));
    }

    foreach ($list_check_product as $value) {
        foreach ($value as $k => $v) {
            $list_c[$k] = $v;
        }
    }

    $stmt = $conn->prepare("SELECT * FROM sanpham_shop WHERE id IN (" . rtrim(str_repeat('?,', count($valid_ids)), ',') . ") AND shop=? ORDER BY FIELD(id," . rtrim(str_repeat('?,', count($valid_ids)), ',') . ")");
    $params = array_merge($valid_ids, [$shop], $valid_ids);
    $stmt->bind_param(str_repeat('i', count($valid_ids)) . 's' . str_repeat('i', count($valid_ids)), ...$params);
    $stmt->execute();
    $thongtin_cart = $stmt->get_result();

    if ($thongtin_cart->num_rows == 0) {
        $thongbao = "Sản phẩm trong giỏ hàng không tồn tại.";
        $replace = [
            'title' => 'Lỗi dữ liệu',
            'thongbao' => $thongbao,
            'link' => '/gio-hang.html'
        ];
        echo $skin->skin_replace('skin_shop/' . $s . '/tpl/chuyenhuong', $replace);
        exit();
    }

    $tamtinh = 0;
    $list_product = '';
    $can_nang = 0;
    $trongluong = 0;
    //nccncc
    function getCtvProvinceDistrict($conn, $user_id)
    {
        $stmt = mysqli_prepare($conn, "
                SELECT 
                    transport.province, 
                    transport.district, 
                    tinh_moi.tieu_de AS tinh_ten, 
                    huyen_moi.tieu_de AS huyen_ten
                FROM transport
                INNER JOIN tinh_moi ON transport.province = tinh_moi.id
                INNER JOIN huyen_moi ON transport.district = huyen_moi.id
                WHERE transport.user_id = ? AND (transport.is_default = 1 OR transport.is_pickup = 1)
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
    function checkRole($conn, $user_id)
    {
        $stmt = mysqli_prepare($conn, "SELECT dropship, ctv FROM user_info WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $dropship = $row['dropship'];
            $ctv = $row['ctv'];

            if ($dropship == 1) {
                mysqli_stmt_close($stmt);
                $data = [
                    'tinh' => 'Thành phố Hà Nội',
                    'huyen' => 'Nam Từ Liêm'
                ];
                return $data;
            }

            if ($ctv == 1) {
                $data = getCtvProvinceDistrict($conn, $user_id);
                return $data;
            }

            // Trường hợp không phải dropship hoặc ctv
            mysqli_stmt_close($stmt);
            $data = [
                'tinh' => 'Thành phố Hà Nội', // ID tỉnh, ví dụ: Cần Thơ
                'huyen' => 'Nam Từ Liêm' // ID huyện, ví dụ: Huyện Cờ Đỏ
            ];
            return $data;
        }
    }
    function getReceiverProvinceDistrict($conn, $user_id)
    {
        $stmt = mysqli_prepare($conn, "
                SELECT 
                    user_info.tinh, 
                    user_info.huyen,
                    tinh_moi.tieu_de AS tinh_ten, 
                    huyen_moi.tieu_de AS huyen_ten
                    FROM user_info
                    INNER JOIN tinh_moi ON user_info.tinh = tinh_moi.id
                    INNER JOIN huyen_moi ON user_info.huyen = huyen_moi.id
                    WHERE user_info.user_id = ?
                ");

        if (!$stmt) {
            return "Lỗi chuẩn bị truy vấn";
        }

        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            return [
                'tinh' => $row['tinh_ten'],
                'huyen' => $row['huyen_ten']
            ];
        } else {
            return "Không tìm thấy tỉnh/huyện cho user";
        }
    }
    $list_giam_titles = [];
    $data_receiver = getReceiverProvinceDistrict($conn, $user_id);
    while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
        $id_sp = $r_cart['id'];
        $data = checkRole($conn, $r_cart['shop']);
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['sp_id'] == $id_sp) {
                $can_nang += floatval(str_replace(',', '.', $r_cart['can_nang'])) * $value['quantity'];
                $r_cart['quantity'] = $value['quantity'];
                $r_cart['variant'] = 'Màu: ' . ($value['ten_color'] ?? '') . ' - Size: ' . ($value['ten_size'] ?? '');

                $stmts_variant = mysqli_query($conn, "SELECT * FROM phanloai_sanpham_shop WHERE sp_id='$id_sp' AND ten_size='$value[ten_size]' AND ten_color='$value[ten_color]'");
                $r_variant = mysqli_fetch_assoc($stmts_variant);
                $trongluong += floatval(str_replace(',', '.', $r_variant['can_nang_tinhship'])) * $value['quantity'];
                if ($value['tang'] == 1) {
                    $r_cart['ten_sanpham'] = '<span class="color_red">[Quà tặng]</span> ' . $r_cart['tieu_de'];
                    $tamtinh += 0;
                    $r_cart['thanhtien'] = 0;
                    $r_cart['gia_moi'] = 0;
                } else {
                    $r_cart['ten_sanpham'] = $r_cart['tieu_de'];
                    $gia_moi = floatval($value['gia_moi']);
                    $tamtinh += $gia_moi * $value['quantity'];
                    $r_cart['thanhtien'] = number_format($gia_moi * $value['quantity']);
                    $r_cart['gia_moi'] = number_format($gia_moi);

                    foreach ($list_km as $kkk => $vvv) {
                        if ($vvv['kieu'] == 'all') {
                            if ($vvv['loai'] == 'phantram') {
                                $ggg = ($gia_moi * $value['quantity'] / 100) * $vvv['giam'];
                                $list_giam[$kkk] = ($list_giam[$kkk] ?? 0) + ceil($ggg);
                                // $list_giam_titles[$kkk] = "Toàn bộ sản phẩm";
                            } else {
                                $list_giam[$kkk] = ($list_giam[$kkk] ?? 0) + $vvv['giam'];
                                // $list_giam_titles[$kkk] = "Toàn bộ sản phẩm";
                            }
                        } else {
                            $tach_apdung = explode(',', $vvv['sanpham']);
                            if (in_array($id_sp, $tach_apdung)) {
                                if ($vvv['loai'] == 'phantram') {
                                    $ggg = ($gia_moi * $value['quantity'] / 100) * $vvv['giam'];
                                    $list_giam[$kkk] = ($list_giam[$kkk] ?? 0) + ceil($ggg);
                                    if (!isset($list_giam_titles[$kkk])) {
                                        $list_giam_titles[$kkk] = [];
                                    }
                                    if (!in_array($r_cart['tieu_de'], $list_giam_titles[$kkk])) {
                                        // $list_giam_titles[$kkk][] = $r_cart['tieu_de'];
                                    }

                                } else {
                                    $list_giam[$kkk] = ($list_giam[$kkk] ?? 0) + $vvv['giam'];
                                    if (!isset($list_giam_titles[$kkk])) {
                                        $list_giam_titles[$kkk] = [];
                                    }
                                    if (!in_array($r_cart['tieu_de'], $list_giam_titles[$kkk])) {
                                        // $list_giam_titles[$kkk][] = $r_cart['tieu_de'];
                                    }

                                }
                            }
                        }
                    }
                }
                $list_product .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_product_checkout', $r_cart);
            }
        }
    }

    $data_receiver_tinh = $data_receiver['tinh'] ?? '';
    $data_receiver_huyen = $data_receiver['huyen'] ?? '';
    $data_ship = $class_supership->get_tax($data['tinh'], $data['huyen'], $data_receiver_tinh, $data_receiver_huyen, $trongluong * 1000, $tamtinh, $accessToken);
    $phi_ship = $data_ship['results'][0]['fee'];


    if (isset($_SESSION['coupon'])) {
        if ($r_coupon['total'] == 0) {
            $giam = 0;
            $coupon = '';
        } else {
            if ($r_coupon['expired'] > time()) {
                $ma_giam = $_SESSION['coupon'];
                $giam = floatval($list_giam[$ma_giam] ?? 0);
                $coupon = $_SESSION['coupon'];
            } else {
                $giam = 0;
                $coupon = '';
            }
        }
    } else {
        $giam = 0;
        $coupon = '';
    }
    $tongtien = $tamtinh + $phi_ship - $giam;
    // $phi_ship = $class_supership->get_phi_ship($trongluong);
    // if (isset($_SESSION['thanhtoan'])) {
    //     $thanhtoan = $_SESSION['thanhtoan'];
    // } else {
    //     $thanhtoan = 'cod';
    // }
}
function getUserVoucherUses($user_id, $voucher_code)
{
    global $conn;
    $user_id = intval($user_id);
    $voucher_code = mysqli_real_escape_string($conn, $voucher_code);

    $query = "SELECT COUNT(*) AS uses FROM voucher_usage vu 
              JOIN coupon c ON vu.voucher_id = c.id 
              WHERE vu.user_id = $user_id AND c.ma = '$voucher_code'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return (int) ($row['uses'] ?? 0);
    }
    return 0;
}


if ($tamtinh <= 0) {
    $list_ma_giam = '';
} else {
    $user_id = 0;
    if (isset($_COOKIE['user_id'])) {
        $tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
        $user_id = $tach_token['user_id'] ?? 0;
    }

    $list_ma_giam = '';
    foreach ($list_giam as $key => $value) {
        $voucher = $list_km[$key] ?? [];
        $min_price = (int) ($voucher['min_price'] ?? 0);
        $max_price = (int) ($voucher['max_price'] ?? 0);
        $allow_combination = (int) ($voucher['allow_combination'] ?? 0);
        $max_uses_per_user = (int) ($voucher['max_uses_per_user'] ?? 0);
        $max_global_uses = (int) ($voucher['max_global_uses'] ?? 0);


        $key_escaped = mysqli_real_escape_string($conn, $key);
        $shop_escaped = mysqli_real_escape_string($conn, $shop);
        $current_uses_query = mysqli_query($conn, "SELECT current_uses FROM coupon WHERE ma = '$key_escaped' AND shop = '$shop_escaped'");
        $current_uses_row = mysqli_fetch_assoc($current_uses_query);
        $current_uses = (int) ($current_uses_row['current_uses'] ?? 0);

        $kieu = $voucher['kieu'] ?? 'all';
        if (!in_array($kieu, ['all', 'sanpham'])) {
            $kieu = 'all';
        }

        $applicable_total = ($kieu == 'all') ? $tamtinh : 0;
        if ($kieu == 'sanpham') {
            $tach_apdung = !empty($voucher['sanpham']) ? explode(',', $voucher['sanpham']) : [];
            if (!empty($tach_apdung)) {
                foreach ($_SESSION['cart'] as $cart_item) {
                    $id_sp = $cart_item['sp_id'];
                    if (in_array($id_sp, $tach_apdung)) {
                        $applicable_total += floatval($cart_item['gia_moi']) * $cart_item['quantity'];
                    }
                }
            }
        }
        $price_condition = ($min_price == 0 || $applicable_total >= $min_price) && ($max_price == 0 || $applicable_total <= $max_price);
        $per_user_condition = ($max_uses_per_user == 0 || getUserVoucherUses($user_id, $key) < $max_uses_per_user);
        $global_condition = ($max_global_uses == 0 || $current_uses < $max_global_uses);
        if ($price_condition && $per_user_condition && $global_condition) {
            $r_g = [
                'ma' => $key,
                'giam' => number_format(floatval($value)),
                'variant' => (isset($list_giam_titles[$key]) && is_array($list_giam_titles[$key])) ? implode(', ', $list_giam_titles[$key]) : '',
                'loai' => $voucher['loai'] ?? 'tru',
                'kieu' => $kieu,
                'min_price' => $min_price,
                'max_price' => $max_price,
                'sanpham' => $voucher['sanpham'] ?? ''
            ];
            $list_ma_giam .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_giam', $r_g);
        } else {
            file_put_contents('debug.log', "Voucher $key không hiển thị - user_id: $user_id, uses: " . getUserVoucherUses($user_id, $key) . ", max_uses_per_user: $max_uses_per_user, current_uses: $current_uses, max_global_uses: $max_global_uses\n", FILE_APPEND);
        }
    }
}

if (strlen($list_ma_giam) < 10) {
    $box_ma_giam = '';
} else {
    $box_ma_giam = $skin->skin_normal('skin_shop/' . $s . '/tpl/box_ma_giam');
}
// vnpay

$google_analytics = str_replace('<script>// <![CDATA[', '<script>', $index_setting['google_analytics']);
$google_analytics = str_replace('// ]]>', '', $google_analytics);
$script_chat = str_replace('<script>// <![CDATA[', '<script>', $index_setting['script_footer']);
$script_chat = str_replace('// ]]>', '', $script_chat);

$replace = [
    'header' => $skin->skin_normal('skin_shop/' . $s . '/tpl/header'),
    'box_header' => $box_header,
    'box_ma_giam' => $box_ma_giam,
    'footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/footer'),
    'script_footer' => $skin->skin_normal('skin_shop/' . $s . '/tpl/script_footer'),
    'title' => 'Thanh toán đơn hàng',
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
    'list_category_nav' => $tach_category['list'],
    'list_category_left' => $tach_category['list_left'],
    'lienhe' => $index_setting['lienhe'],
    'photo' => $index_setting['photo'],
    'phantrang' => $phantrang,
    'fanpage' => $index_setting['fanpage'],

    'name' => $user_info['name'] ?? '',
    'email' => $user_info['email'] ?? '',
    'mobile' => $user_info['mobile'] ?? '',
    'dia_chi' => $user_info['dia_chi'] ?? '',
    'avatar' => $user_info['avatar'] ?? '',
    'tinh' => $user_info['tinh'] ?? '',
    'huyen' => $user_info['huyen'] ?? '',
    'xa' => $user_info['xa'] ?? '',
    'option_tinh' => $class_index->list_option_tinh($conn, $id),
    'list_product' => $list_product,
    'tongtien' => number_format(floatval($tongtien)),
    'tamtinh' => number_format(floatval($tamtinh)),
    'giam_hienthi' => number_format(floatval($giam)),
    'phi_ship' => number_format(floatval($phi_ship)) . 'đ',
    'coupon' => $coupon,
    'list_giam' => $list_ma_giam,
    'shop' => $r_shop['user_id'],
    'thanhtoan' => $thanhtoan,
    //////////// fee_ship
    'sender_province' => $data['tinh'],
    'sender_district' => $data['huyen'],
    'weight' => $trongluong * 1000,
    'amount' => $tamtinh,
    'giam' => $giam,
];

if ($step == 3) {
    // Giữ nguyên logic step 3
   if (isset($_GET['vnp_TxnRef']) && isset($_GET['vnp_ResponseCode'])) {
        $order_id = intval($_GET['vnp_TxnRef']);
        $payment_status = ($_GET['vnp_ResponseCode'] == '00') ? 'completed' : 'failed';
        $amount = isset($_GET['vnp_Amount']) ? ($_GET['vnp_Amount'] / 100) : 0;
        $transaction_id = $_GET['vnp_TransactionNo'] ?? null;

        // Kiểm tra xem đã có bản ghi chưa
        $stmt = $conn->prepare("SELECT COUNT(*) FROM order_payments WHERE order_id = ? AND payment_method = 'vnpay'");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count == 0) {
            // Insert dữ liệu
            $stmt = $conn->prepare("INSERT INTO order_payments (order_id, payment_method, amount, transaction_id, payment_status, created_at, updated_at)
                                    VALUES (?, 'vnpay', ?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("idss", $order_id, $amount, $transaction_id, $payment_status); // Đúng số lượng biến
            if ($stmt->execute()) {
                // echo "Insert thành công.";
            } else {
                // echo "Lỗi insert: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // echo "Đã có bản ghi thanh toán cho đơn hàng này bằng vnpay.";
        }
    } else {
        echo "Thiếu tham số.";
    }
    // var_dump(($_GET));
    // die;
    if (isset($_SESSION['ma_don'])) {
        $thongtin_order = mysqli_query($conn, "SELECT * FROM donhang_shop WHERE ma_don='{$_SESSION['ma_don']}'");
        $r_order = mysqli_fetch_assoc($thongtin_order);
        $thongtin_payments = mysqli_query($conn, "SELECT * FROM order_payments WHERE order_id='{$_SESSION['ma_don']}'");
        $r_payments = mysqli_fetch_assoc($thongtin_payments);
        $replace['ho_ten'] = $r_order['ho_ten'];
        $replace['email'] = $r_order['email'];
        $replace['dien_thoai'] = $r_order['dien_thoai'];
        $replace['dia_chi'] = $r_order['dia_chi'];
        $replace['ma_don'] = $r_order['ma_don'];
        $thontin_huyen = mysqli_query($conn, "SELECT huyen_moi.*,tinh_moi.tieu_de AS ten_tinh FROM huyen_moi INNER JOIN tinh_moi ON tinh_moi.id=huyen_moi.tinh WHERE huyen_moi.id='{$r_order['huyen']}'");
        $r_h = mysqli_fetch_assoc($thontin_huyen);
        $replace['tinh'] = $r_h['ten_tinh'];
        $replace['huyen'] = $r_h['tieu_de'];
        
        if ($r_order['thanhtoan'] == 'vnpay') {
            $replace['phuongthuc'] = '<img src="/skin_shop/skin_5_nhat/tpl/css/images/Icon-VNPAY-QR.png" alt="VNPay" style="vertical-align: middle; width: 24px; height: 24px; margin-right: 8px;"> Thanh toán qua VNPAY';
            $replace['nganhang'] = 'Ngân hàng ' . ($_GET['vnp_BankCode']?? 'N/A');
        } else {
            $replace['phuongthuc'] = 'Thanh toán khi nhận hàng';
            $replace['nganhang'] = '';
        }
        if ($r_payments['payment_status'] == 'completed') {
            $replace['tinhtrang'] = 'Đã thanh toán';
        } elseif ($r_payments['payment_status'] == 'failed') {
            $replace['tinhtrang'] = 'Thanh toán thất bại';
        } 
        else {
            $replace['tinhtrang'] = 'Chưa thanh toán';
        }
        $tach_sanpham = json_decode($r_order['sanpham'], true);
        $list_product_step_3 = '';
        foreach ($tach_sanpham as $value) {
            $list_product_step_3 .= $skin->skin_replace('skin_shop/' . $s . '/tpl/box_li/li_product_checkout_step_3', $value);
        }
        if ($r_order['phi_ship'] > 0) {
            $replace['phi_ship'] = number_format(floatval($r_order['phi_ship'])) . 'đ';
        } else {
            $replace['phi_ship'] = 'Miễn phí';
        }
        $replace['list_product'] = $list_product_step_3;
        $replace['tamtinh'] = number_format(floatval($r_order['tamtinh']));
        $replace['tongtien'] = number_format(floatval($r_order['tongtien']));
        $replace['giam'] = number_format(floatval($r_order['giam']));
        echo $skin->skin_replace('skin_shop/' . $s . '/tpl/checkout_step_3', $replace);
    } else {
        $thongbao = "Giao dịch đã quá hạn để xem chi tiết.";
        $replace = [
            'title' => 'Giao dịch đã quá hạn để xem chi tiết.',
            'thongbao' => $thongbao,
            'link' => '/'
        ];
        echo $skin->skin_replace('skin_shop/' . $s . '/tpl/chuyenhuong', $replace);
        exit();
    }
} else {
    echo $skin->skin_replace('skin_shop/' . $s . '/tpl/checkout_step_1', $replace);
}
