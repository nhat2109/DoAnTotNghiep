<?php
$web = $_SERVER['HTTP_HOST'];
$web = str_replace('www.', '', $web);
$web_root = array('doantotnghiep.vn', 'socdo.vn', 'socmoi.vn', 'soc.vn', 'beta.socdo.vn');
if (in_array($web, $web_root) == false) {
	include('./shop/order_detail.php');
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
	$box_header = $skin->skin_normal('skin/box_header_login');
} else {
	$box_header = $skin->skin_normal('skin/box_header');
	$mobile_menu = $skin->skin_normal('skin/mobile_menu');
}
$order = preg_replace('/[^0-9]/', '', $url_query['id']);
$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donhang WHERE ma_don='$order' AND user_id='$user_id'");
$r_tt = mysqli_fetch_assoc($thongtin);
if ($r_tt['total'] == 0) {
	$thongbao = "Đơn hàng không tồn tại.";
	$replace = array(
		'title' => 'Đơn hàng không tồn tại',
		'thongbao' => $thongbao,
		'link' => '/don-hang.html'
	);
	echo $skin->skin_replace('skin/chuyenhuong', $replace);
	exit();
}
if ($r_tt['status'] == 1) {
	$trang_thai = 'Đã tiếp nhận đơn';
	$class_status = 'wait';
} else if ($r_tt['status'] == 2) {
	$trang_thai = 'Đã giao đơn vị vận chuyển';
	$class_status = 'xac_nhan';
} else if ($r_tt['status'] == 3) {
	$trang_thai = 'Yêu cầu hủy đơn';
	$class_status = 'request_cacnel';
} else if ($r_tt['status'] == 4) {
	$trang_thai = 'Xác nhận hủy đơn';
	$class_status = 'cancel';
} else if ($r_tt['status'] == 5) {
	$trang_thai = 'Giao thành công';
	$class_status = 'success';
} else if ($r_tt['status'] == 6) {
	$trang_thai = 'Đã hoàn đơn';
	$class_status = 'cancel';
} else {
	$class_status = 'wait';
	$trang_thai = 'Chờ xử lý';
}
if ($r_tt['phi_ship'] > 0) {
	$phi_ship = number_format($r_tt['phi_ship']) . 'đ';
} else {
	$phi_ship = 'Miễn phí';
}
// Xử lý danh sách sản phẩm
$sanpham_data = mb_convert_encoding($r_tt['sanpham'], 'UTF-8', 'auto');
error_log("Sanpham JSON for order {$r_tt['ma_don']}: " . $sanpham_data);

// Hàm xử lý JSON thủ công để giữ lại tất cả sản phẩm
function parse_json_with_duplicate_keys($json_string) {
    $json_string = trim($json_string);
    if (empty($json_string) || $json_string[0] !== '{') {
        return [];
    }

    // Loại bỏ dấu { và } ở đầu và cuối
    $json_string = substr($json_string, 1, -1);
    $products = [];
    $current_product = '';
    $brace_count = 0;
    $in_quotes = false;

    for ($i = 0; $i < strlen($json_string); $i++) {
        $char = $json_string[$i];

        if ($char === '"' && $json_string[$i - 1] !== '\\') {
            $in_quotes = !$in_quotes;
        }

        if (!$in_quotes) {
            if ($char === '{') {
                $brace_count++;
            } elseif ($char === '}') {
                $brace_count--;
            }
        }

        $current_product .= $char;

        if ($brace_count === 0 && !$in_quotes && ($char === '}' || $i === strlen($json_string) - 1)) {
            // Đã tìm thấy một sản phẩm hoàn chỉnh
            $product_json = '{' . trim($current_product, ',') . '}';
            $product = json_decode($product_json, true);
            if ($product !== null) {
                $products[] = $product;
            }
            $current_product = '';
        }
    }

    // Loại bỏ key ngoài cùng (ví dụ: "2558") và chỉ giữ dữ liệu sản phẩm
    $result = [];
    foreach ($products as $product) {
        $result[] = reset($product); // Lấy giá trị đầu tiên của mảng (bỏ qua key "2558")
    }

    return $result;
}

// Sử dụng hàm để xử lý JSON
$tach_sanpham = parse_json_with_duplicate_keys($sanpham_data);
$list_sanpham = '';
if (empty($tach_sanpham)) {
    error_log("JSON Parse Error for order {$r_tt['ma_don']}: Không thể phân tích JSON");
    $list_sanpham = '<tr><td colspan="5" class="text-center">Lỗi dữ liệu sản phẩm: JSON không hợp lệ.</td></tr>';
} else {
    // Tạo danh sách ID sản phẩm và pl để truy vấn (cho dữ liệu cũ)
    $list_sp_id = [];
    $list_pl = [];
    foreach ($tach_sanpham as $value) {
        $sp_id = isset($value['sp_id']) ? intval($value['sp_id']) : 0;
        $pl = isset($value['pl']) ? intval($value['pl']) : 0;
        if ($sp_id > 0) {
            $list_sp_id[] = $sp_id;
        }
        if ($pl > 0) {
            $list_pl[] = $pl;
        }
    }
    $list_sp_id = array_unique($list_sp_id);
    $list_pl = array_unique($list_pl);

    // Truy vấn thông tin phân loại nếu cần (dựa trên pl) - chỉ cho dữ liệu cũ
    $product_pl = [];
    if (!empty($list_pl)) {
        $list_pl_str = implode(',', $list_pl);
        $thongtin_pl = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE id IN ($list_pl_str)");
        if ($thongtin_pl) {
            while ($r_pl = mysqli_fetch_assoc($thongtin_pl)) {
                $sp_pl = $r_pl['sp_id'] . '_' . $r_pl['id'];
                $product_pl[$sp_pl] = $r_pl;
            }
        }
    }

    foreach ($tach_sanpham as $value) {
        // Đảm bảo $value là một mảng phẳng
        if (!is_array($value)) {
            error_log("Dữ liệu sản phẩm không hợp lệ: " . json_encode($value));
            continue;
        }

        // Lấy sp_id và pl từ dữ liệu sản phẩm
        $sp_id = isset($value['sp_id']) ? intval($value['sp_id']) : 0;
        $pl = isset($value['pl']) ? intval($value['pl']) : 0;
        $sp_pl = $sp_id . '_' . $pl;

        // Xử lý color và size
        $display_color = '';
        $display_size = '';
        $color = isset($value['color']) ? trim($value['color']) : '';
        $size = isset($value['size']) ? trim($value['size']) : '';

        // Ưu tiên sử dụng color và size từ JSON nếu chúng không phải là số
        if (!empty($color) && !is_numeric($color)) {
            $display_color = 'Màu: ' . $color;
        }
        if (!empty($size) && !is_numeric($size)) {
            $display_size = 'Size: ' . strtoupper($size);
        }

        // Nếu color hoặc size là số (dữ liệu cũ), truy vấn bảng phanloai_sanpham
        if ((empty($display_color) || empty($display_size)) && $pl > 0 && isset($product_pl[$sp_pl])) {
            $display_color = !empty($product_pl[$sp_pl]['ten_color']) ? 'Màu: ' . $product_pl[$sp_pl]['ten_color'] : '';
            $display_size = !empty($product_pl[$sp_pl]['ten_size']) ? 'Size: ' . strtoupper($product_pl[$sp_pl]['ten_size']) : '';
        }

        // Kết hợp color và size thành chuỗi, chỉ thêm " - " nếu cả hai đều tồn tại
        $color_size_display = '';
        if (!empty($display_color) && !empty($display_size)) {
            $color_size_display = $display_color . ' - ' . $display_size;
        } elseif (!empty($display_color)) {
            $color_size_display = $display_color;
        } elseif (!empty($display_size)) {
            $color_size_display = $display_size;
        }

        // Gán giá trị vào $value để thay thế vào template
        $value['color'] = $color_size_display; // Gán chuỗi đã định dạng vào color để phù hợp với template
        $value['size'] = ''; // Không cần dùng size riêng nữa vì đã gộp vào color
        $value['giam'] = isset($value['giam']) ? number_format($value['giam']) : '0';
        $value['gia_moi'] = isset($value['gia_moi']) ? number_format((float)str_replace(',', '', $value['gia_moi'])) . ' đ' : '0 đ';
        $value['gia_cu'] = isset($value['gia_cu']) && $value['gia_cu'] != '' ? number_format((float)str_replace(',', '', $value['gia_cu'])) . ' đ' : '';
        $value['soluong'] = isset($value['soluong']) ? $value['soluong'] : '1';
        $value['minh_hoa'] = isset($value['minh_hoa']) ? $value['minh_hoa'] : '';
        $value['link'] = isset($value['link']) ? $value['link'] : '#';
        $value['tieu_de'] = isset($value['tieu_de']) ? $value['tieu_de'] : 'Sản phẩm không xác định';
        $value['thanhtien'] = isset($value['thanhtien']) ? number_format((float)str_replace(',', '', $value['thanhtien'])) . ' đ' : '0 đ';

        // Ghi log để kiểm tra $value
        error_log("Dữ liệu sản phẩm: " . json_encode($value));

        // Thay thế template
        $list_sanpham .= $skin->skin_replace('skin/box_li/li_sanpham_order', $value);
    }
}
if ($r_tt['id'] < 107) {
	$thongtin_huyen = mysqli_query($conn, "SELECT huyen.*,tinh.tieu_de AS ten_tinh FROM huyen INNER JOIN tinh ON tinh.id=huyen.tinh WHERE huyen.id='{$r_tt['huyen']}'");
} else {
	$thongtin_huyen = mysqli_query($conn, "SELECT huyen_moi.*,tinh_moi.tieu_de AS ten_tinh FROM huyen_moi INNER JOIN tinh_moi ON tinh_moi.id=huyen_moi.tinh WHERE huyen_moi.id='{$r_tt['huyen']}'");
}
if ($r_tt['id'] < 107) {
	$thongtin_xa = mysqli_query($conn, "SELECT * FROM xa WHERE id='{$r_tt['xa']}'");
} else {
	$thongtin_xa = mysqli_query($conn, "SELECT * FROM xa_moi WHERE id='{$r_tt['xa']}'");
}
$r_h = mysqli_fetch_assoc($thongtin_huyen);
$r_x = mysqli_fetch_assoc($thongtin_xa);
$r_tt['tinh'] = $r_h['ten_tinh'];
$r_tt['huyen'] = $r_h['tieu_de'];
$r_tt['xa'] = $r_x['tieu_de'];
$tach_menu = json_decode($class_index->list_menu($conn), true);
$tach_banner = json_decode($class_index->list_banner($conn), true);
$tach_list_category = json_decode($class_index->list_category($conn), true);
$link_xem = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$thongtin_caidat_tichdiem = mysqli_query($conn, "SELECT * FROM caidat_tichdiem WHERE shop='0'");
$total_caidat = mysqli_num_rows($thongtin_caidat_tichdiem);
if ($total_caidat == 0) {
	$hat_de = 0;
} else {
	$r_tichdiem = mysqli_fetch_assoc($thongtin_caidat_tichdiem);
	$hat_de = round(($r_tt['tongtien'] / 100) * $r_tichdiem['diem']);
}
$list_danhmuc_top = json_decode($class_index->list_category_danhmuc_top($conn), true);
$replace = array(
	'header' => $skin->skin_normal('skin/header'),
	'box_header' => $box_header,
	'list_danhmuc' => $list_danhmuc_top['list_top'],
	'footer' => $skin->skin_normal('skin/footer'),
	'script_footer' => $skin->skin_normal('skin/script_footer'),
	'mobile_menu' => $mobile_menu,
	'title' => 'Chi tiết đơn hàng #' . $order,
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
	'phantrang' => $phantrang,
	'fanpage' => $index_setting['fanpage'],
	'name' => $user_info['name'],
	'avatar' => $user_info['avatar'],
	'ma_don' => $r_tt['ma_don'],
	'ho_ten' => $r_tt['ho_ten'],
	'dia_chi' => $r_tt['dia_chi'] . ',' . $r_tt['xa'] . ',' . $r_tt['huyen'] . ',' . $r_tt['tinh'],
	'dien_thoai' => $r_tt['dien_thoai'],
	'email' => $r_tt['email'],
	'ghi_chu' => $r_tt['ghi_chu'],
	'thanhtoan' => strtoupper($r_tt['thanhtoan']),
	'date_post' => date('H:i:s d/m/Y', $r_tt['date_post']),
	'trang_thai' => $trang_thai,
	'class_status' => $class_status,
	'tamtinh' => number_format($r_tt['tamtinh']),
	'giam' => number_format($r_tt['giam']),
	'tongtien' => number_format($r_tt['tongtien']),
	'coupon' => strtoupper($r_tt['coupon']),
	'hat_de' => number_format($hat_de),
	'phi_ship' => $phi_ship,
	'list_sanpham' => $list_sanpham,
	'huyen' => $r_tt['huyen'],
	'tinh' => $r_tt['tinh'],
	'banner_top' => $tach_banner['top'],
	'list_danhmuc_noibat_timkiem' => $class_index->list_category_noibat_timkiem($conn), // chức năng tìm kiếm nâng cao
);
echo $skin->skin_replace('skin/order_detail', $replace);
